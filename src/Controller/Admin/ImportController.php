<?php

namespace App\Controller\Admin;

use App\Form\DataModel\ImportUserFormModel;
use App\Form\Flow\ImportFlow;
use App\Repository\UserRepository;
use App\Services\ImportHelper;
use App\Services\UploadHelper;
use Doctrine\Persistence\ObjectManager;
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
     * @param UploadHelper $uploadHelper
     * @param ImportHelper $importHelper
     * @param ImportFlow $importFlow
     * @param UserRepository $userRepository
     * @return Response
     * @throws FileExistsException
     */
    public function index(
        Request $request,
        UploadHelper $uploadHelper,
        ImportHelper $importHelper,
        ImportFlow $importFlow,
        UserRepository $userRepository): Response
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

            } else {

                /** @var ObjectManager $entityManager */
                $entityManager = $this->getDoctrine()->getManager();

                $csvDatas = $importHelper->getCleanImportDatas();
                $headers = array_shift($csvDatas);

                $stringKey = $headers[0];

                $test = [];
                foreach ($csvDatas as $row) {

//                    $test = ;

                }



                dd($test, $stringKey, $headers, $csvDatas);

            // if deteteTests = 1 > delete users with is_test = 1
                switch ($formData->deteteTests) {
//                    case 0:
//                    break;

                    case 1:
                        $userRepository->deleteTestUsers();
                    break;
                }

            // if duplicateEmail
                switch ($formData->duplicateEmail) {
                    // = 0 > do nothing
                    case 0:
                    break;

                    // = 1 > insert a new user
                    case 1:

                        dump($csvDatas);

                        foreach ($csvDatas as $csvData) {

                            if ($users = $userRepository->findBy(['email' => $csvData])) {
                                dump($csvData);
                            }
                        }


                        die('sjdkjsdk');

                        $userRepository->insertUserFromImport($csvDatas);
                    break;

                    // = 2 > update the user with the same email
                    case 2:

                        $userRepository->updateUserFromImport($csvDatas);
                    break;
                }

                // if emptyEmails
                switch ($formData->emptyEmails) {

                    // = 0 > do nothing
                    case 0:
                    break;
                    // = 1 > insert a new user
                    case 1:
                        $userRepository->insertUserFromImport($csvDatas);
                    break;
                }


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