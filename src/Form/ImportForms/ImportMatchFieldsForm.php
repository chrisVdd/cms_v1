<?php

namespace App\Form\ImportForms;

use App\Services\ImportHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportMatchFieldsForm extends AbstractType
{

    private ImportHelper $importHelper;

    /**
     * ImportMatchFieldsForm constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityFields = $this->importHelper->getEntityFields('user');

        $csvHeaders = $headersTest = ['username', 'emails', 'lastName'];

        foreach ($entityFields as $entityField) {

            $choices[$entityField] = array_flip($csvHeaders);

            $builder->add($entityField, ChoiceType::class,
                [
                    'label' => $entityField,
                    'placeholder' => 'Choose a column from the excel file',
                    'choices' => $choices[$entityField],
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'mapped' => false
                ]
            );
       }
    }
}