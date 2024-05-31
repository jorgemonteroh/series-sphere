<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeguimientoController extends AbstractController
{
    #[Route('/seguimiento_serie', name: 'seguimiento_serie')]
    public function index(): Response
    {
        return $this->render('seguimiento/index.html.twig', [
            'controller_name' => 'SeguimientoController',
        ]);
    }
}
