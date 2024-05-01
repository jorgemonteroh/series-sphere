<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
    #[Route('/busqueda', name: 'busqueda')]
    public function index(): Response
    {
        return $this->render('busqueda/index.html.twig');
    }
}
