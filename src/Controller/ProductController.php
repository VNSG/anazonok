<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function list(ProductRepository $productRepository): Response
    {
        return $this->render('product/list.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function show(ProductRepository $productRepository, string $id, Request $request, EntityManagerInterface $manager): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this-> createNotFoundException();
        }
        $review = new Review;
        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);
        
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()){
            $review->setProduct($product);
            
            $manager->persist($review);
            $manager->flush();

            $this->addFlash('success', 'Votre message est bien envoyé!!!');

        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'reviewForm' => $reviewForm->createView()
        ]);
    }
}
