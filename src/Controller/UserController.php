<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}