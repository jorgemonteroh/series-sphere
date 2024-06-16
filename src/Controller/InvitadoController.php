<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\SerieRepository;
use App\Repository\StreamingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InvitadoController extends AbstractController
{
    // Página destacados de la sección de invitados:
    #[Route('index/destacados', name: 'destacados_invitado')]
    public function destacados(SerieRepository $serieRepository) {
        $array_series = $serieRepository->findAll();  

        return $this->render('page/invitado/destacados/destacados.html.twig', [
            'array_series' => $array_series
        ]);
    }

    // Página de búsqueda de la sección de invitados:
    #[Route('index/busqueda', name: 'busqueda_invitado')]
    public function index(GeneroRepository $generoRepository, StreamingRepository $streamingRepository): Response
    {
        $array_generos = $generoRepository->findAll();
        $array_streamings = $streamingRepository->findAll();
        $anio = date('Y');
        $array_lanzamientos = array('1960s', '1970s', '1980s','1990s','2000s','2010s','2020s', $anio);

        return $this->render('page/invitado/busqueda/busqueda.html.twig', [
            'array_generos' => $array_generos,
            'array_streamings' => $array_streamings,
            'array_lanzamientos' => $array_lanzamientos,
            'array_series' => "",
            'container_empty' => "min-height:45vh",
            'busqueda_filtros' => ""
        ]);
    }

    #[Route('index/busquedaSubmit', name: 'busqueda_submit_')]
    public function submit(GeneroRepository $generoRepository, StreamingRepository $streamingRepository, SerieRepository $serieRepository): Response {     
        $array_generos = $generoRepository->findAll();
        $array_streamings = $streamingRepository->findAll();
        $anio = date('Y');
        $array_lanzamientos = array('1960s', '1970s', '1980s','1990s','2000s','2010s','2020s', $anio);
        $array_series = "";
        $filtro = "";
   
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
        
        if (isset($_POST['lanzamiento']) && $_POST['lanzamiento'] !== "") {
            $filtro = $_POST['lanzamiento'];
            $array_series = $serieRepository->buscarLanzamiento($_POST['lanzamiento']);
        } 

        if (isset($_POST["input"])) {
            $filtro = $_POST["input"];
            $array_series = $serieRepository->buscarSeries($filtro);
        }

        return $this->render('page/invitado/busqueda/busqueda.html.twig', [
            'array_generos' => $array_generos,
            'array_streamings' => $array_streamings,
            'array_lanzamientos' => $array_lanzamientos,
            'container_empty' => "",
            'array_series' => $array_series,
            'busqueda_filtros' => $filtro
        ]);
    }

    #[Route('index/livesearchI', name: 'livesearchI')]
    public function livesearchI(SerieRepository $serieRepository, GeneroRepository $generoRepository, StreamingRepository $streamingRepository) {
        $array_generos = $generoRepository->findAll();
        $array_streamings = $streamingRepository->findAll();
        $anio = date('Y');
        $array_lanzamientos = array('1960s', '1970s', '1980s','1990s','2000s','2010s','2020s', $anio);

        if (isset($_POST["input"])) {
            $input = $_POST["input"];

            if ($input == "selectAll") {
                $array_series = $serieRepository->findAll();
                $input = 'Todas las series';
            } else {
                $array_series = $serieRepository->buscarSeries($input);
            }

            return $this->render('page/invitado/busqueda/busqueda.html.twig', [
                'array_generos' => $array_generos,
                'array_streamings' => $array_streamings,
                'array_lanzamientos' => $array_lanzamientos,
                'container_empty' => "",    
                'array_series' => $array_series,
                'busqueda_filtros' => "'".$input."'"
            ]);    
        }
    }

    // Página de serie en la sección de invitados:
    #[Route('index/mostrarSerie/id={id}', name: 'mostrar_serie_id_invitado')]
    public function mostrarSerie(SerieRepository $serieRepository, int $id): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        $array_temporadas = $serie->getTemporadas();

        return $this->render('page/invitado/serie/showSerie.html.twig', [
            'id_serie' => $serie->getId(),
            'nombre_serie' => $serie->getNombre(),
            'poster_serie' => $serie->getposter_src(),
            'streaming_serie' => $serie->getStreamings(),
            'genero_serie' => $serie->getGenero(),
            'director_serie' => $serie->getDirector(),
            'sinopsis_serie' => $serie->getSinopsis(),
            'valoracion_serie' => $serie->getValoracion(),
            'array_temporadas' => $array_temporadas
        ]);
    }

    // Páginas del footer sección de invitados:
    // Accesibilidad:
    #[Route('index/declaracionAccesibilidad', name: 'declaracion_accesibilidad_invitado')]
    public function accesibilidad(): Response {
        return $this->render('page/invitado/footer/accesibilidad.html.twig');
    }

    // Mapa web:
    #[Route('index/mapaWeb', name: 'mapa_web_invitado')]
    public function mapaWeb(): Response {
        return $this->render('page/invitado/footer/mapaWeb.html.twig');
    }
}
