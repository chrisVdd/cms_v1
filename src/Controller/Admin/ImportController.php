<?php

namespace App\Controller\Admin;

use App\Form\ImportUserFlow;
use App\Form\Model\ImportUserFormModel;
use App\Services\ImportHelper;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FileExistsException;
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
     * @param ImportHelper $importHelper
     * @param ImportUserFlow $importUserFlow
     * @return Response
     * @throws FileExistsException
     */
    public function index(
        Request $request,
        UploadHelper $uploadHelper,
        ImportHelper $importHelper,
        ImportUserFlow $importUserFlow): Response
    {

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var ImportUserFormModel $formData */
        $formData = new ImportUserFormModel();
        $importUserFlow->bind($formData);

        $steps = $importUserFlow->getSteps();
        // dump($steps);

        // Create the form for the first step
        $form = $importUserFlow->createForm();

        if ($importUserFlow->isValid($form)) {

            $importUserFlow->saveCurrentStepData($form);

            // If there is a NEXT step
            if ($importUserFlow->nextStep()) {

                // Create the form for the next step
                $form = $importUserFlow->createForm();

                // dump($form);
                dump($importUserFlow->getCurrentStep());

                /*
                 * TODO
                 * WORK on the STEP 2 or 3 ?????
                 *      1. upload the file
                 *      2. use the data from the file to generate the 3th form
                 * */
                if ($importUserFlow->getCurrentStep() === '2') {

                    $uploadedFile = $form['testinput']->getData();
                    dd($uploadedFile);
                }



//                $uploadedFile = $form['importFile']->getData();
//
//                if ($uploadedFile) {
//
//                    dump($uploadedFile);
//
//                    // Upload the file in the good folder
//                    $newFilename = $uploadHelper->uploadImport($uploadedFile);
//
//                    /** @var array $importDatas */
//                    $importDatas = $importHelper->loadDocument($newFilename);
//
//                    $headers['headers'] = $importHelper->getHeaders($importDatas);
//                    $importUserFlow->setGenericFormOptions($headers);
//                }








            } else {

//                $entityManager->persist($formData);
//                $entityManager->flush();

                dump($formData);

                $importUserFlow->reset();

                return $this->redirect($this->generateUrl('admin_import_success'));
            }



//            // Launch when Excel is 'post'
//            if ($importUserFlow->getCurrentStepNumber() === 2) {
//
//                $importUserModel = $form->getData();
//
//                $uploadedFile = $form['importFile']->getData();
//
//                if ($uploadedFile) {
//
//                    // Upload the file in the good folder
//                    $newFilename = $uploadHelper->uploadImport($uploadedFile);
//
//                    /** @var array $importDatas */
//                    $importDatas = $importHelper->loadDocument($newFilename);
//
//                    $headers['headers'] = $importHelper->getHeaders($importDatas);
//                    $importUserFlow->setGenericFormOptions($headers);
//                }
//            }
//
//            if ($importUserFlow->nextStep()) {
//
//                $form = $importUserFlow->createForm();
//
//            } else {
//
////                $entityManager = $this->getDoctrine()->getManager();
////                $entityManager->persist($formData);
////                $entityManager->flush();
//
//                $importUserFlow->reset();
//
//                return $this->redirect($this->generateUrl('admin_import_success'));
//            }
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