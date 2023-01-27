<?php

namespace App\Controller;
use App\Repository\CategoryRepository;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function list(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $productRepository->createQueryBuilder('p'), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('product/list.html.twig', [
            'products' => $pagination,
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
            return $this->redirectToRoute('app_products'); 
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'reviewForm' => $reviewForm->createView()
        ]);

    }
    #[Route('/product', name: 'app_product_detail')]
    public function detail(ProductRepository $productRepository): Response
    {
        return $this->render('product/detail.html.twig',[
            'products' => $productRepository->findAll(),
        ]);
    }


}
