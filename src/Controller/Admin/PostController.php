<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\UploadHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="admin_post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_post_new", methods={"GET","POST"})
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @return Response
     * @throws Exception
     */
    public function new(Request $request, UploadHelper $uploadHelper): Response
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post = $form->getData();

            dd($post);


            $post->setAuthor($this->getUser());

            $uploadedFile = $form['imageFilename']->getData();

            if ($uploadedFile) {
                $newFilename = $uploadHelper->uploadPostImage($uploadedFile, $post->getImageFilename());
                $post->setImageFilename($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="admin_post_show", methods={"GET"})
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        return $this->render('admin/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_post_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Post $post
     * @param UploadHelper $uploadHelper
     * @return Response
     * @throws Exception
     */
    public function edit(Request $request, Post $post, UploadHelper $uploadHelper): Response
    {
//        dd($post);

        $form = $this->createForm(PostType::class, $post);

//        dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['imageFilename']->getData();

            if ($uploadedFile) {

                $newFilename = $uploadHelper->uploadPostImage($uploadedFile, $post->getImageFilename());
                $post->setImageFilename($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
