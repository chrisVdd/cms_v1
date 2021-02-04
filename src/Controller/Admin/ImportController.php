<?php

namespace App\Controller\Admin;

use App\Form\ImportUserFormType;
use App\Services\UploadHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImportController
 * @Route("/admin/import")
 * @package App\Controller\Admin
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/", name="admin_import_index", methods={"GET", "POST"})
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @return Response
     */
    public function index(Request $request, UploadHelper $uploadHelper): Response
    {
        $form = $this->createForm(ImportUserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // All datas from the import FORM
            $importUserModel = $form->getData();

            $uploadedFile = $form['importFile']->getData();

            if ($uploadedFile) {

                $newFilename = $uploadHelper->uploadImport($uploadedFile);

//                $newFilename = $uploadHelper->uploadPostImage($uploadedFile, $post->getImageFilename());
//                $post->setImageFilename($newFilename);
            }





            dd($importUserModel, $uploadedFile, $newFilename);

        }

//        $uploadedFile = $request->files->get('importFile');
//        if ($uploadedFile) {
//            $newFilename = $uploadHelper->uploadImport($uploadedFile);
//        }


        return $this->render("admin/import/index.html.twig",
            [
                'form' => $form->createView(),
            ]
        );
    }
}