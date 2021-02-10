<?php

namespace App\Form\ImportForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImportQuestionForm
 * @package App\Form\ImportForms
 */
class ImportQuestionForm extends AbstractType
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
                        'Duplicate the user' => 1,
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
        return 'importQuestionStep';
    }
}