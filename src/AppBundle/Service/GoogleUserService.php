<?php

namespace AppBundle\Service;

//use AppBundle\Entity\Group;
//use AppBundle\Entity\Person;
//use AppBundle\Entity\Scout;
//use AppBundle\Entity\Talent;
//use AppBundle\Entity\TalentStatusHistory;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class GoogleUserService.
 */
class GoogleUserService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var GoogleService
     */
    private $googleService;

//    /**
//     * @var Group
//     */
//    private $adminGroup;
//
//    /**
//     * @var Group
//     */
//    private $scoutGroup;
//
//    /**
//     * @var Group
//     */
//    private $talentGroup;

    /**
     * GoogleUserService constructor.
     *
     * @param KernelInterface $kernel
     * @param EntityManagerInterface $entityManager
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function __construct(KernelInterface $kernel, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->googleService = $kernel->getContainer()->get(GoogleService::class);
    }

    /**
     * Get googleService.
     *
     * @return GoogleService
     */
    public function getGoogleService()
    {
        return $this->googleService;
    }

    /**
     * Get all users from provided domain.
     *
     * @param $domain
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Exception
     */
    public function getAllUsers($domain)
    {
        $this->googleService->auth(GoogleService::SERVICE);
        $this->googleService->getClient()->setSubject($this->googleService->getAdminUser());

        $service = new \Google_Service_Directory($this->googleService->getClient());

        /** @var \Google_Service_Directory_Users $users */
        $users = $service->users->listUsers(['domain' => $domain])->getUsers();

        /** @var \Google_Service_Directory_User $user */
        foreach ($users as $user) {
            $dbUser = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $user->getId()]);

            if (!$dbUser) {
                //$dbUser = new User($this->createPerson($user), $user->getId(), $user->getPrimaryEmail());
                //$this->entityManager->persist($dbUser);
                $this->createUser($user);
                $this->entityManager->flush();
            }

            //$this->updateUser($dbUser, $user);
        }
    }

    public function createUser(\Google_Service_Directory_User $googleUser): void
    {
        $user = new User();
        $user->setGoogleId($googleUser->getId());
        $user->setEmail($googleUser->getPrimaryEmail());
        $this->entityManager->persist($user);

        $person = new Person($googleUser->getName()->getFamilyName(), $googleUser->getName()->getGivenName(), null, null, $googleUser->getPrimaryEmail());
        $person->setUser($user);
        $this->entityManager->persist($person);
        $user->setPerson($person);
    }

    public function getUser($initUser)
    {
        /** @ToDO: Fix permission error. */
        $serviceClient = clone($this->googleService);
        $serviceClient->auth(GoogleService::SERVICE);
        $serviceClient->getClient()->setSubject($this->googleService->getAdminUser());

        $service = new \Google_Service_Directory($serviceClient->getClient());

        $user = $service->users->get($initUser);

        var_dump($user);
    }

//    /**
//     * Update AccessToken data.
//     *
//     * @param int   $googleId
//     * @param array $accessToken =null
//     *
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     * @throws \Exception
//     *
//     * @return bool
//     */
//    public function updateUserAccessToken($googleId, array $accessToken = null): bool
//    {
//        /** @var User $user */
//        $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $googleId]);
//
//        if ($user) {
//            if ($accessToken) {
//                $user->setAccessToken($accessToken['access_token']);
//                $user->setAccessTokenExpire(
//                    (new \DateTime())->add(new \DateInterval('PT'.($accessToken['expires_in'] - 5).'S'))
//                );
//
//                $this->entityManager->persist($user);
//                $this->entityManager->flush();
//            }
//
//            return true;
//        }
//
//        return false;
//    }
}
