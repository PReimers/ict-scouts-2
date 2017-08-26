<?php

namespace AppBundle\Controller;

use AppBundle\Service\GoogleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method("GET")
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function loginAction(): RedirectResponse
    {
        $googleService = $this->get(GoogleService::class);
        $client = $googleService->auth($googleService::USER);
        $client->setHostedDomain($googleService->getGoogleConfig()['apps_domain']);

        return $this->redirect($client->createAuthUrl());
    }

    /**
     * Placeholer methode
     *
     * @Route("/login/google-check")
     * @Method("GET")
     *
     * @return RedirectResponse
     */
    public function loginGoogleCheckAction(): RedirectResponse
    {
        return $this->redirect($this->generateUrl('home'));
    }
}
