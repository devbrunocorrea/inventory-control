<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    // public function __construct()
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

}