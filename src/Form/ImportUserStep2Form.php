<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File as ConstraintsImportFile;

/**
 * Class ImportUserStep2Form
 * @package App\Form
 */
class ImportUserStep2Form extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var array $validExtension */
        $validExtension = [new ConstraintsImportFile(
            [
                'mimeTypes'        =>
                    [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ],
                'mimeTypesMessage' => 'Please, upload a valid Excel document'
            ])
        ];

        $builder
            ->add('importFile', FileType::class,
                ['constraints' => $validExtension]
            );
    }

    /**
     * @return mixed
     */
    public function getBlockPrefix()
    {
        return 'importUserStep2';
    }
}