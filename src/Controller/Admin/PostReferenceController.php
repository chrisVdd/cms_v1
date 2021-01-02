<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\PostReference;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use League\Flysystem\FileExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PostReferenceController
 * @package App\Controller\Admin
 *
 * @Route("/admin")
 */
class PostReferenceController extends AbstractController
{
    /**
     * @Route("/post/{id}/reference/add", name="admin_post_add_reference", methods={"POST"})
     *
     * @param Post $post
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws FileExistsException
     */
    public function uploadPostReference(
        Post $post,
        Request $request,
        UploadHelper $uploadHelper,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator)
    {

        $uploadedFile = $request->files->get('reference');

        $violations = $validator->validate($uploadedFile,
            [
                new NotBlank(),
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'text/plain'
                    ]
                ])
            ]
        );

        if ($violations->count() > 0) {
            return $this->json($violations, 400);
        }

        /** @var string $filename */
        $filename = $uploadHelper->uploadPostReference($uploadedFile);

        /** @var PostReference $postReference */
        $postReference = new PostReference($post);

        $postReference->setFilename($filename);
        $postReference->setOriginalFilename($uploadedFile->getClientOriginalName() ?? $filename);
        $postReference->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');

        $entityManager->persist($postReference);
        $entityManager->flush();

        return $this->json(
            $postReference,
            201,
            [],
            [
                'groups' => ['main']
            ]
        );
    }

    /**
     * @Route("/post/{id}/references", name="admin_post_list_references", methods="GET")
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function getPostReferences(Post $post)
    {
        return $this->json(
            $post->getPostReferences(),
            200,
            [],
            [
                'groups' => ['main']
            ]
        );
    }

    /**
     * @Route("/post/reference/{id}/download", name="admin_post_download_reference", methods={"GET"})
     * @param PostReference $postReference
     * @param UploadHelper $uploadHelper
     *
     * @return StreamedResponse
     */
    public function downloadPostReference(
        PostReference $postReference,
        UploadHelper $uploadHelper)
    {
        /** @var Post $post */
        $post = $postReference->getPost();

        $response = new StreamedResponse(function () use ($postReference, $uploadHelper) {

            $outputStream = fopen('php://output', 'wb');
            $fileStream = $uploadHelper->readStream($postReference->getFilePath(), false);

            stream_copy_to_stream($fileStream,$outputStream);
        });

        $response->headers->set('Content-Type', $postReference->getMimeType());

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $postReference->getOriginalFilename()
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    /**
     * @Route("/post/{id}/references/reorder", methods="POST", name="admin_post_reorder_references")
     * @param Post $post
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function reorderPostReference(
        Post $post,
        Request $request,
        EntityManagerInterface $entityManager)
    {
        $orderedIds = json_decode($request->getContent(), true);

        if ($orderedIds === null) {
            return $this->json(
                [
                    'detail' => 'Invalid body'
                ], 400
            );
        }

        $orderedIds = array_flip($orderedIds);

        foreach ($post->getPostReferences() as $postReference) {
            $postReference->setPosition($orderedIds[$postReference->getId()]);
        }

        $entityManager->flush();

        return $this->json(
            $post->getPostReferences(),
            200,
            [],
            [
                'groups' => ['main']
            ]
        );
    }

    /**
     * @Route("/post/reference/{id}", name="admin_post_delete_references", methods={"DELETE"})
     * @param PostReference $postReference
     * @param UploadHelper $uploadHelper
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws Exception
     */
    public function deletePostReference(
        PostReference $postReference,
        UploadHelper $uploadHelper,
        EntityManagerInterface $entityManager)
    {
        /** @var Post $post */
        $post = $postReference->getPost();

        $entityManager->remove($postReference);
        $entityManager->flush();

        $uploadHelper->deleteFile($postReference->getFilePath(), false);

        return new Response(null, 204);
    }

    /**
     * @Route("/post/references/{id}", name="admin_post_edit_references", methods={"PUT"})
     *
     * @param PostReference $postReference
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function updatePostReference(
        PostReference $postReference,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Request $request,
        ValidatorInterface $validator)
    {
        /** @var Post $post */
        $post = $postReference->getPost();

        $serializer->deserialize(
            $request->getContent(),
            PostReference::class,
            'json',
            [
                'object_to_populate' => $postReference,
                'groups' => ['input']
            ]
        );

        $violations = $validator->validate($postReference);

        if ($violations->count() > 0) {
            return  $this->json($violations, 400);
        }

        $entityManager->persist($postReference);
        $entityManager->flush();

        return $this->json(
            $postReference,
            200,
            [],
            [
                'groups' => ['main']
            ]
        );
    }
}