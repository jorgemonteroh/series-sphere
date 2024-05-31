<?php

namespace App\Controller;

use App\Entity\ContadorCapitulos;
use App\Entity\Temporada;
use App\Repository\CapituloRepository;
use App\Repository\ContadorCapitulosRepository;
use App\Repository\ListaRepository;
use App\Repository\SerieListaRepository;
use App\Repository\SerieRepository;
use App\Repository\TemporadaRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    public function obtenerDatos($user, $serie, $datos, $entityManager, $temporadaRepository) {
    }

    #[Route('/home', name: 'home')]
    public function index(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, TemporadaRepository $temporadaRepository, ContadorCapitulosRepository $contadorCapitulosRepository): Response
    {
        // Recoger Usuario actual:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener Listas viendo y por ver
        $listaUsuarioViendo = $listaRepository->listaSeriesViendo($currentUserID);
        $listaUsuarioPorVer = $listaRepository->listaSeriesPorVer($currentUserID);

        // Devolver error 404 si no se encuentra la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuarioViendo || !$listaUsuarioPorVer) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Obtener ID de las listas:
        $currentListaViendoID = $listaUsuarioViendo->getId();
        $currentListaPorVerID = $listaUsuarioPorVer->getId(); 

        // Obtener un array con todas las series de la lista con los ID obtenidos antes (SerieLista):
        $series_lista_viendo = $serieListaRepository->getSerieIdFromLista($currentListaViendoID);
        $series_lista_por_ver = $serieListaRepository->getSerieIdFromLista($currentListaPorVerID);

        $array_temporadas = [];
        $array_capitulos = [];

        // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
        $array_id_series_viendo = [];
        foreach ($series_lista_viendo as $id_serie) {
            $array_id_series_viendo[] = $id_serie['serie_id'];
            $array_temporadas[] = $temporadaRepository->buscarTemporadas($id_serie['serie_id']);
        }

        $array_id_series_por_ver = [];
        foreach ($series_lista_por_ver as $id_serie) {
            $array_id_series_por_ver[] = $id_serie['serie_id'];
        }

        // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
        $array_series_viendo = [];
        foreach ($array_id_series_viendo as $id_serie) {
            $array_series_viendo[] = $serieRepository->find($id_serie);
        }  
        
        $array_series_por_ver = []; 
        foreach ($array_id_series_por_ver as $id_serie) {
            $array_series_por_ver[] = $serieRepository->find($id_serie);
        }

        $seriesSelectedValores = [];
        if(isset($_POST['current_seguimiento']) && isset($_POST['serie_seguimiento'])) {
            $serie = $serieRepository->find($_POST['serie_seguimiento']);
            $serieActualizar = $contadorCapitulosRepository->buscarSerieSeguimiento($serie->getId());
            $seriesSelectedValores[$serie->getId()] = $_POST['current_seguimiento'];
            // Si la serie ya existe se actualiza:
            if (count($serieActualizar) == 1) {
                $contadorCapitulos = $entityManager->getRepository(ContadorCapitulos::class)->find($serieActualizar[0]['id']);
                $patron = '/T(\d+)C(\d+)/';
        
                preg_match($patron, $_POST['current_seguimiento'], $valores);
        
                if (isset($valores[1]) && isset($valores[2])) {
                    $valor_temporada = (int)$valores[1];
                    $valor_capitulo = (int)$valores[2];
        
                    $temporada = $temporadaRepository->find($valor_temporada);                
        
                    $contadorCapitulos->setUsuario($currentUser);
                    $contadorCapitulos->setSerie($serie);
                    $contadorCapitulos->setTemporada($temporada);
                    $contadorCapitulos->setCapituloActual($valor_capitulo);
                    $entityManager->persist($contadorCapitulos);
                    $entityManager->flush();
                }
            // Si la serie no existe se crea una nueva entrada en la base de datos:
            } else {
                $contadorCapitulos = new ContadorCapitulos();
                $patron = '/T(\d+)C(\d+)/';
        
                preg_match($patron, $_POST['current_seguimiento'], $valores);
        
                if (isset($valores[1]) && isset($valores[2])) {
                    $valor_temporada = (int)$valores[1];
                    $valor_capitulo = (int)$valores[2];
        
                    $temporada = $temporadaRepository->find($valor_temporada);                
        
                    $contadorCapitulos->setUsuario($currentUser);
                    $contadorCapitulos->setSerie($serie);
                    $contadorCapitulos->setTemporada($temporada);
                    $contadorCapitulos->setCapituloActual($valor_capitulo);
                    $entityManager->persist($contadorCapitulos);
                    $entityManager->flush();
                }
            } 
        }

        foreach ($array_series_viendo as $serie) {
            $serieId = $serie->getId();
            $contadorCapitulos = $contadorCapitulosRepository->buscarSerieSeguimiento($serieId);
            if(!empty($contadorCapitulos)) {
                $temporadaId = $contadorCapitulos[0]['temporada_id'];
                $capituloActual = $contadorCapitulos[0]['capitulo_actual'];
                $seriesSelectedValores[$serieId] = 'T' . $temporadaId . 'C' . $capituloActual;
            }
        }

        return $this->render('page/home/home.html.twig', [
            'array_series_viendo' => $array_series_viendo,
            'array_series_por_ver' => $array_series_por_ver,
            'array_temporadas' => $array_temporadas,
            'seriesSelectedValores' => $seriesSelectedValores
        ]);
    }
}
