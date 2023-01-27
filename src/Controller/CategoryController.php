<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Orm\EntityPaginatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController
{   
    /* #[IsGranted('ROLE_USER')] */
    #[Route('/categories', name: 'app_categories')]
    public function list(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $categoryRepository->createQueryBuilder('c'), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('category/list.html.twig', [
            'categories' => $pagination,
        ]);
}

    #[Route('/categories/{id}', name: 'app_category')]
    public function show(CategoryRepository $categoryRepository, string $id): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this-> createNotFoundException();
        }
        
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
