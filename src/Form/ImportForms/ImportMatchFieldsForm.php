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

//        dd($options);

        $entityFields = $this->importHelper->getEntityFields('user');
        $forbiddenFields = ['id', 'create_date', 'update_date'];

        $fields = array_diff($entityFields, $forbiddenFields);

        $csvHeaders = $headersTest = ['username', 'emails', 'lastName'];

        foreach ($fields as $field) {

            $choices[$field] = array_flip($csvHeaders);

            $builder->add($field, ChoiceType::class,
                [
                    'label'       => $field,
                    'placeholder' => 'Choose a column from the excel file',
                    'choices'     => $choices[$field],
                    'multiple'    => false,
                    'expanded'    => false,
                    'required'    => false,
                    'mapped'      => false
                ]
            );
       }
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'ImportMatchFieldsStep';
    }
}