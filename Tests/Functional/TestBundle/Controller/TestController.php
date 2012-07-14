<?php

namespace FSC\P3PBundle\Tests\Functional\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('admin');
    }

    /**
     * @Route("/contact")
     */
    public function contactAction()
    {
        return new Response('contact');
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return new Response('');
    }
}
