<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): RedirectResponse
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->redirectToRoute('app_login');
    }
}
