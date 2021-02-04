<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Widget;
use App\Form\PageType;
use App\Repository\PageRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="page_show", methods={"GET"})
     * @param Page $page
     * @param PostRepository $postRepository
     * @return Response
     */
    public function show(Page $page, PostRepository $postRepository): Response
    {
        /** @var string $templateName */
        $templateName = $page->getTemplate()->getFilename();

        /** @var Widget $widgetPages */
        $widgetPages = $page->getWidgets();

        foreach ($widgetPages as $widget) {

            switch ($widget) {
                case "last posts":
                    echo "i est une pomme";
                    break;
                case "contact form":
                    echo "i est une barre";
                    break;
                case "map":
                    echo "i est un gateau";
                    break;
                case "map":
                    echo "i est un gateau";
                    break;
            }
        }




//        if ($widgetPages->getName() === 'last posts') {
//            dd($widgetPages);
//        }



        $lastPosts = $postRepository->findLatest(5);

        return $this->render('page/show.html.twig',
            [
                'templateName' => $templateName,
                'page'         => $page,
                'lastPost'     => $lastPosts,
            ]
        );
    }
}
