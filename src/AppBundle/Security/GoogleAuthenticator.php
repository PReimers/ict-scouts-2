<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 25.08.17
 * Time: 08:14
 */

namespace AppBundle\Security;


use AppBundle\Entity\User;
use AppBundle\Service\GoogleService;
use AppBundle\Service\GoogleUserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GoogleAuthenticator extends AbstractGuardAuthenticator
{

    /** @var GoogleService $googleService */
    protected $googleService;

    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var RouterInterface $router */
    protected $router;

    /** @var RequestStack $requestStack */
    protected $requestStack;

    /** @var GoogleUserService $googleUserService */
    protected $googleUserService;

    public function __construct(
        GoogleService $googleService,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        RequestStack $requestStack,
        GoogleUserService $googleUserService)
    {
        $this->googleService = $googleService;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->googleUserService = $googleUserService;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function start( Request $request, AuthenticationException $authException = null )
    {
        return new RedirectResponse('/login');
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array). If you return null, authentication
     * will be skipped.
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      if ($request->request->has('_username')) {
     *          return array(
     *              'username' => $request->request->get('_username'),
     *              'password' => $request->request->get('_password'),
     *          );
     *      } else {
     *          return;
     *      }
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials( Request $request )
    {
        if ($request->getPathInfo() !== '/login/google-check') {
            return;
        }

        return $request->get('code');

    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
     * @throws \Exception
     */
    public function getUser( $credentials, UserProviderInterface $userProvider )
    {
        $client = $this->googleUserService->getGoogleService()->auth(GoogleService::USER);
        $this->googleService->getClient()->fetchAccessTokenWithAuthCode($credentials);

        $userData = (new \Google_Service_Oauth2($client))->userinfo_v2_me->get();
        if ($userData->getHd() !== $this->googleService->getGoogleConfig()['apps_domain']) {
            return;
        }

        $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $userData->getId()]);

        /** If user does not exist create it. */
        if (!$user) {
            $user = new User();
            $user->setGoogleId($userData->getId());
            $user->setEmail($userData->getEmail());
            $user->setFamilyName($userData->getFamilyName());
            $user->setGivenName($userData->getGivenName());

            $this->entityManager->persist($user);
        }

        $user->setAccessToken($client->getAccessToken()['access_token']);
        $user->setAccessTokenExpiresAt(
            (new \DateTime())->add(new \DateInterval('PT'.($client->getAccessToken()['expires_in'] - 5).'S'))
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed         $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials( $credentials, UserInterface $user )
    {
        return true;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess( Request $request, TokenInterface $token, $providerKey )
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    /**
     * Does this method support remember me cookies?
     *
     * Remember me cookie will be set if *all* of the following are met:
     *  A) This method returns true
     *  B) The remember_me key under your firewall is configured
     *  C) The "remember me" functionality is activated. This is usually
     *      done by having a _remember_me checkbox in your form, but
     *      can be configured by the "always_remember_me" and "remember_me_parameter"
     *      parameters under the "remember_me" firewall key
     *
     * @return bool
     */
    public function supportsRememberMe() : bool
    {
        return false;
    }
}