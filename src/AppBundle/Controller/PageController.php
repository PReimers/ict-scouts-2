<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * Get homepage.
     *
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('page/index.html.twig');
    }

    /**
     * Get imprint.
     *
     * @Route("/imprint", name="imprint")
     * @Method("GET")
     */
    public function imprintAction()
    {
        return $this->render('page/imprint.html.twig');
    }
}
