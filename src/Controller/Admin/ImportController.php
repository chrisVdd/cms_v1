<?php

namespace App\Controller\Admin;

use App\Form\ImportUserFlow;
use App\Form\ImportUserFormType;
use App\Form\Model\ImportUserFormModel;
use App\Services\ImportHelper;
use App\Services\UploadHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
     * @param ImportHelper $importHelper
     * @param ImportUserFlow $importUserFlow
     * @return Response
     */
    public function index(
        Request $request,
        UploadHelper $uploadHelper,
        ImportHelper $importHelper,
        ImportUserFlow $importUserFlow): Response
    {
        $formData = new ImportUserFormModel();
        $importUserFlow->bind($formData);

        $form = $importUserFlow->createForm();

        if ($importUserFlow->isValid($form)) {

            $importUserFlow->saveCurrentStepData($form);

            // Launch when Excel is post
            if ($importUserFlow->getCurrentStepNumber() === 2) {

                $importUserModel = $form->getData();

                $uploadedFile = $form['importFile']->getData();

                if ($uploadedFile) {

                    // Upload the file in the good folder
                    $newFilename = $uploadHelper->uploadImport($uploadedFile);

                    /** @var array $importDatas */
                    $importDatas = $importHelper->loadDocument($newFilename);

                    $headers = $importHelper->getHeaders($importDatas);
                    $userEntityFields = $importHelper->getUserEntityFields();

                    dd($importUserFlow->getStep(3));


//                    dd($headers, $userEntityFields);
//                    foreach ($userEntityFields as $entityField) {
//                        $form->add($entityField, ChoiceType::class,
//                            [
//                                'placeholder' => 'Choose a column from the excel file',
//                                'choices'     => array_flip($headers),
//                                'multiple'    => false,
//                                'required'    => false
//                            ]
//                        );
//                    }
//                    dd($form);
                }
            }

            if ($importUserFlow->getCurrentStepNumber() === 3) {

                $form = $importUserFlow->createForm();

                dd($form);

                die('asldkslkadlsk');
                $form->getData();
            }

            if ($importUserFlow->nextStep()) {

                $form = $importUserFlow->createForm();

            } else {

                dd($formData);

//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($formData);
//                $entityManager->flush();

                $importUserFlow->reset();

                return $this->redirect($this->generateUrl('admin_import_success'));
            }

//            // All datas from the import FORM
//            $importUserModel = $form->getData();
//
//            $uploadedFile = $form['importFile']->getData();
//
//            if ($uploadedFile) {
//
//                // Upload the file in the good folder
//                $newFilename = $uploadHelper->uploadImport($uploadedFile);
//
//                /** @var array $importDatas */
//                $importDatas = $importHelper->loadDocument($newFilename);
//            }
//            dd($importUserModel, $uploadedFile, $newFilename);

        }

        return $this->render("admin/import/index.html.twig",
            [
                'form' => $form->createView(),
                'flow' => $importUserFlow
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