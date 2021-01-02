<?php

namespace App\Controller\Admin;

use App\Entity\Template;
use App\Form\TemplateType;
use App\Repository\TemplateRepository;
use App\Services\UploadHelper;
use League\Flysystem\FileExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/template")
 */
class TemplateController extends AbstractController
{
    /**
     * @Route("/", name="admin_template_index", methods={"GET"})
     * @param TemplateRepository $templateRepository
     * @return Response
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('admin/template/index.html.twig',
            ['templates' => $templateRepository->findAll(),]
        );
    }

    /**
     * @Route("/new", name="admin_template_new", methods={"GET","POST"})
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @return Response
     * @throws FileExistsException
     */
    public function new(Request $request, UploadHelper $uploadHelper): Response
    {

        /** @var FormInterface $form */
        $form = $this->createForm(TemplateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Template $template */
            $template = $form->getData();

            $uploadedFile = $form['filename']->getData();

            if ($uploadedFile) {
                $newFilename = $uploadHelper->uploadTemplate($uploadedFile);
                $template->setFilename($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($template);
            $entityManager->flush();

            return $this->redirectToRoute('admin_template_index');
        }

        return $this->render('admin/template/new.html.twig',
            [
                'form'      => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="admin_template_show", methods={"GET"})
     * @param Template $template
     * @return Response
     */
    public function show(Template $template): Response
    {
        return $this->render('admin/template/show.html.twig',
            [
                'template' => $template,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="admin_template_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Template $template
     * @param UploadHelper $uploadHelper
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, Template $template, UploadHelper $uploadHelper): Response
    {
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['filename']->getData();

            if ($uploadedFile) {

                $newFilename = $uploadHelper->uploadPostImage($uploadedFile, $template->getFilename());
                $template->setFilename($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_template_index');
        }

        return $this->render('admin/template/edit.html.twig',
            [
                'template'  => $template,
                'form'      => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="admin_template_delete", methods={"DELETE"})
     * @param Request $request
     * @param Template $template
     * @return Response
     */
    public function delete(Request $request, Template $template): Response
    {
        if ($this->isCsrfTokenValid('delete'.$template->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($template);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_template_index');
    }
}
