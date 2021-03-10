<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Entity\Template;
use App\Entity\User;
use App\Form\PageType;
use App\Repository\PageRepository;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FileExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="admin_page_index", methods={"GET"})
     * @param PageRepository $pageRepository
     * @return Response
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('admin/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_page_new", methods={"GET","POST"})
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @return Response
     * @throws FileExistsException
     */
    public function new(Request $request, UploadHelper $uploadHelper): Response
    {
        $form = $this->createForm(PageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Page $page */
            $page = $form->getData();

            /** @var Template $template */
            $template = $form['template']->getData();

            $uploadedFile = $form['template']['filename']->getData();

            /** @var EntityManagerInterface $entityManager */
            $entityManager = $this->getDoctrine()->getManager();

            if ($uploadedFile) {

                $newFilename = $uploadHelper->uploadTemplate($uploadedFile);
                $template->setFilename($newFilename);
            }

            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('admin_page_index');
        }

        return $this->render('admin/page/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page_show", methods={"GET"})
     * @param Page $page
     * @return Response
     */
    public function show(Page $page): Response
    {
        return $this->render('admin/page/show.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_page_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Page $page
     * @return Response
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_page_index');
        }

        return $this->render('admin/page/edit.html.twig',
            [
                'page' => $page,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="admin_page_delete", methods={"DELETE"})
     * @param Request $request
     * @param Page $page
     * @return Response
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {

            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_page_index');
    }
}
