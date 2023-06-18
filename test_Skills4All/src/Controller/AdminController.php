<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Form\CarType;
use App\Model\SearchData;
use App\Entity\Car;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CarRepository;
use App\Repository\CarCategoryRepository;
use App\Entity\CarCategory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="car")
     */
    public function index(Request $request, PaginatorInterface $paginator, CarRepository $carRepository, CarCategoryRepository $carCategoryRepository): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        $car = $this->getDoctrine()->getRepository(Car::class)->findAll();
        $category = $carCategoryRepository->findbyGroup();
        if ($form->isSubmitted() && $form->isValid()){
            $car = $carRepository->findBySearch($searchData, $paginator);
            return $this->render('admin/index.html.twig', [
                'form' => $form->createView(),
                'Cars' => $car,
                'Categories' => $category,
                'url_admin' => "/admin"
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
        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'Cars' => $cars,
            'Categories' => $category,
            'url_admin' => "/admin"
        ]);
    }

    /**
     * @Route("/category/{name}", name="category")
     */
    public function category(Request $request, PaginatorInterface $paginator, CarRepository $carRepository, CarCategoryRepository $carCategoryRepository, $name): Response
    {
        if(!$name){
            return $this->redirectToRoute('admin_car');
        }

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        $car = $carCategoryRepository->findAllCategory($name);
        $category = $carCategoryRepository->findbyGroup();
        if ($form->isSubmitted() && $form->isValid()){
            $car = $carCategoryRepository->findBySearchCategory($searchData, $paginator, $name);
            return $this->render('admin/index.html.twig', [
                'form' => $form->createView(),
                'Cars' => $car,
                'Categories' => $category,
                'Categorie_name' => $name,
                'url_admin' => "/admin"
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
        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'Cars' => $cars,
            'Categories' => $category,
            'Categorie_name' => $name,
            'url_admin' => "/admin"
        ]);
    }

    /**
     * @Route("/ajout", name="voiture_ajout")
     */
    public function ajout(Request $request){
        $Car = new Car();
        $form = $this->createForm(CarType::class, $Car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Car);
            $em->flush();
            $this->addFlash(
                'success',
                'La nouvelle voiture a bien été créer.'
            );
            return $this->redirectToRoute('admin_car');
        }
        return $this->render('admin/form_ajout.html.twig', [
            'form' => $form->createView(),
            'ajout_voiture' => true,
            'Titre_page' => "Ajout d'un véhicule"
        ]);
    }

    /**
     * @Route("/update/{id}")
     */
    public function update(Request $request, $id, EntityManagerInterface $manager) {
        $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
        if (!$car){
            return $this->redirectToRoute('admin_car');
        }
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carupdate = $form->getData();
            $manager->persist($carupdate);
            $manager->flush();
            $this->addFlash(
                'success',
                'Les informations de la voiture ont été enregistrées.'
            );
            return $this->redirectToRoute('admin_car'); 
        }
        
        return $this->render('admin/form_ajout.html.twig', [
            'form' => $form->createView(),
            'ajout_voiture' => true,
            'Titre_page' => "Modification d'un véhicule"
        ]);
    }

    /**
     * @Route("/delete/{id}", name="voiture_delete")
     */
    public function delete(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $CarRepository=$em->getRepository(Car::class); 
        $car=$CarRepository->find($id); 
        if ($car == null) {
            return $this->redirectToRoute('admin_car');
        }
        $CarCategoryRepository=$em->getRepository(CarCategory::class); 
        $carcategory=$CarCategoryRepository->findBy(['car' => $car->getId()]); 
        foreach ($carcategory as $value) {
            $em->remove($value); 
            $em->flush(); 
            $request->getSession();     
        }
           
        
        $CarRepository=$em->getRepository(Car::class); 
        $car=$CarRepository->find($id); 
        $em->remove($car); 
        $em->flush(); 
        $request->getSession(); 
        $this->addFlash(
            'success',
            'Les informations de la voiture ont bien été supprimer.'
        );
        return $this->redirectToRoute('admin_car');
    }
}
