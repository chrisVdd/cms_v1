<?php

namespace App\Controller\Admin;

use App\Form\DataModel\ImportUserFormModel;
use App\Form\Flow\ImportFlow;
use App\Services\ImportHelper;
use App\Services\UploadHelper;
use League\Flysystem\FileExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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
     * @param ImportFlow $importFlow
     * @param UploadHelper $uploadHelper
     * @param ImportHelper $importHelper
     * @return Response
     * @throws FileExistsException
     */
    public function index(
        Request $request,
        UploadHelper $uploadHelper,
        ImportHelper $importHelper,
        ImportFlow $importFlow): Response
    {

        /** @var ImportUserFormModel $formData */
        $formData = new ImportUserFormModel($importHelper);
        $importFlow->bind($formData);

        // Create the form for the first step

        /** @var FormInterface $form */
        $form = $importFlow->createForm();

        if ($importFlow->isValid($form)) {

            $importFlow->saveCurrentStepData($form);

            // If there is a NEXT step
            if ($importFlow->nextStep()) {

                $form = $importFlow->createForm();

                if ($formData->importFile) {

                    $newFilename = $uploadHelper->uploadImport($formData->importFile);
                }

//                if ($importFlow->getCurrentStepNumber() === 3) {
//
//                    $csvDatas = $importHelper->getCleanImportDatas();
//                    $headers = $csvDatas[0];
//                }

            } else {

                dd($formData);
//                $entityManager->persist($formData);
//                $entityManager->flush();

                $importFlow->reset();


                return $this->redirect($this->generateUrl('admin_import_success'));
            }
        }

        return $this->render("admin/import/index.html.twig",
            [
                'form' => $form->createView(),
                'flow' => $importFlow
            ]
        );
    }

    /**
     * @Route("/success", name="admin_import_success", methods={"GET"})
     * @return Response
     */
    public function importSuccess():Response
    {
        return $this->render('admin/import/success.html.twig');
    }
}