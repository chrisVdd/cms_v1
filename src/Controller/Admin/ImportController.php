<?php

namespace App\Controller\Admin;

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
        $uploadedFile = $request->files->get('importFile');

        if ($uploadedFile) {

            $newFilename = $uploadHelper->uploadImport($uploadedFile);


        }


        return $this->render("admin/import/index.html.twig", []);
    }
}