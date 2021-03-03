<?php

namespace App\Form\ImportForms;

use App\Services\ImportHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $builder->add('email', ChoiceType::class,
            [
                'label'       => 'Email',
                'placeholder' => 'Choose a column from the excel file',
                'choices'     => $options['csvHeaders'],
                'required'    => false
            ]
        );

        $builder->add('username', ChoiceType::class,
            [
                'label'       => 'Username',
                'placeholder' => 'Choose a column from the excel file',
                'choices'     => $options['csvHeaders'],
                'required'    => false
            ]
        );

        $builder->add('password', ChoiceType::class,
            [
                'label'       => 'Password',
                'placeholder' => 'Choose a column from the excel file',
                'choices'     => $options['csvHeaders'],
                'required'    => false
            ]
        );
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'ImportMatchFieldsStep';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['csvHeaders' => false]);
    }
}