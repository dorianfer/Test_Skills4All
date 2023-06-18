<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{

    public function meteo(HttpClientInterface $httpClient){
        $response = $httpClient->request(
            'GET',
            'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m,weathercode&forecast_days=1'
        );
        $response = $response->getContent();
        $response = json_decode($response);
        $response = $response->hourly;
        date_default_timezone_set('Europe/Paris');
        $heure = intval(date('H'));
        $data = file_get_contents($this->getParameter('JSON_WMO')); 
        $obj = json_decode($data);
        $weathercode = $response->weathercode[$heure];
        $meteo = [$response->temperature_2m[$heure], $obj->$weathercode->description, $heure];
        return $meteo;
    }


    /**
     * @Route("/", name="car")
     */
    public function index(Request $request, PaginatorInterface $paginator, CarRepository $carRepository, CarCategoryRepository $carCategoryRepository, HttpClientInterface $httpClient): Response
    {
        $meteo = $this->meteo($httpClient);
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        $car = $this->getDoctrine()->getRepository(Car::class)->findAll();
        $category = $carCategoryRepository->findbyGroup();
        if ($form->isSubmitted() && $form->isValid()){
            $car = $carRepository->findBySearch($searchData, $paginator);
            return $this->render('home/index.html.twig', [
                'form' => $form->createView(),
                'Cars' => $car,
                'Categories' => $category,
                'url_admin' => "",
                'meteo' => $meteo 
            ]);
        }
        $page = $request->query->getInt('page', 1);
        $limit = 20;
        $cars = $paginator->paginate(
            // Doctrine Query, not results
            $car,
            // Define the page parameter
            $page,
            // Items per page
            $limit
        );
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'Cars' => $cars,
            'Categories' => $category,
            'url_admin' => "",
            'meteo' => $meteo 
        ]);
    }

    /**
     * @Route("category/{name}", name="category")
     */
    public function category(Request $request, PaginatorInterface $paginator, CarRepository $carRepository, CarCategoryRepository $carCategoryRepository, $name, HttpClientInterface $httpClient): Response
    {
        if(!$name){
            return $this->redirectToRoute('home_car');
        }
        $meteo = $this->meteo($httpClient);
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        $car = $carCategoryRepository->findAllCategory($name);
        $category = $carCategoryRepository->findbyGroup();
        if ($form->isSubmitted() && $form->isValid()){
            $car = $carCategoryRepository->findBySearchCategory($searchData, $paginator, $name);
            return $this->render('home/index.html.twig', [
                'form' => $form->createView(),
                'Cars' => $car,
                'Categories' => $category,
                'Categorie_name' => $name,
                'url_admin' => "",
                'meteo' => $meteo 
            ]);
        }
        $page = $request->query->getInt('page', 1);
        $limit = 20;
        $cars = $paginator->paginate(
            // Doctrine Query, not results
            $car,
            // Define the page parameter
            $page,
            // Items per page
            $limit
        );
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'Cars' => $cars,
            'Categories' => $category,
            'Categorie_name' => $name,
            'url_admin' => "",
            'meteo' => $meteo 
        ]);
    }
}
