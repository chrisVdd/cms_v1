<?php

namespace App\Form\ImportForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File as ConstraintsImportFile;

/**
 * Class ImportFileForm
 * @package App\Form\ImportForms
 */
class ImportFileForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validExtension = [new ConstraintsImportFile(
            [
                'mimeTypes'        =>
                    [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ],
                'mimeTypesMessage' => 'Please, upload a valid Excel document'
            ]
       )];

        $builder
            ->add('importFile', FileType::class,
                [
//                    'mapped' => false,
                    'constraints' => $validExtension
                ]
            );
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'importFileStep';
    }
}