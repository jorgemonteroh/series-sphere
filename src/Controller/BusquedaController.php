<?php
namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\StreamingRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
    #[Route('/busqueda', name: 'busqueda')]
    public function index(GeneroRepository $generoRepository, StreamingRepository $streamingRepository): Response
    {
        $array_generos = $generoRepository->findAll();
        $array_streamings = $streamingRepository->findAll();
        $anio = date('Y');
        $array_lanzamientos = array('1960s', '1970s', '1980s','1990s','2000s','2010s','2020s', $anio);

        return $this->render('busqueda/busqueda.html.twig', [
            'array_generos' => $array_generos,
            'array_streamings' => $array_streamings,
            'array_lanzamientos' => $array_lanzamientos,
            'array_series' => "",
            'container_empty' => "min-height:45vh",
            'busqueda_filtros' => ""
        ]);
    }

    #[Route('busquedaSubmit', name: 'busqueda_submit')]
    public function submit(GeneroRepository $generoRepository, StreamingRepository $streamingRepository): Response {     
        $array_generos = $generoRepository->findAll();
        $array_streamings = $streamingRepository->findAll();
        $anio = date('Y');
        $array_lanzamientos = array('1960s', '1970s', '1980s','1990s','2000s','2010s','2020s', $anio);
        $array_series = "";
   
        if (isset($_POST['genero']) && $_POST['genero'] !== "") {
            $filtro = $_POST['genero'];
            $genero = $generoRepository->buscarGenero($_POST['genero']);
            $array_series = $genero->getSerie();   
        } 
        
        if (isset($_POST['streaming']) && $_POST['streaming'] !== "") {
            $filtro = $_POST['streaming'];
            $streaming = $streamingRepository->buscarStreaming($_POST['streaming']);
            $array_series = $streaming->getSerie();
        }    

        return $this->render('busqueda/busqueda.html.twig', [
            'array_generos' => $array_generos,
            'array_streamings' => $array_streamings,
            'array_lanzamientos' => $array_lanzamientos,
            'container_empty' => "",
            'array_series' => $array_series,
            'busqueda_filtros' => $filtro
        ]);
    }
}
