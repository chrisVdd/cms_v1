<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImportUserStep1Form
 * @package App\Form
 */
class ImportUserStep1Form extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('duplicateEmail', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Do nothing' => 0,
                            'Duplicate' => 1,
                            'Replace' => 2,
                        ]
                ]
        );
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'importUserStep1';
    }
}