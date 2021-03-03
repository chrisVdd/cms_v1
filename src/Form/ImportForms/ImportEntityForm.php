<?php

namespace App\Form\ImportForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImportEntityForm
 * @package App\Form\ImportForms
 */
class ImportEntityForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('entity', ChoiceType::class,
            [
                'label'     => 'For which entity do you to import datas?',
                'choices'   =>
                    [
//                        'Page'  => 'page',
//                        'Post'  => 'post',
                        'User'  => 'user',
                    ]
            ]
        );
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'importEntityStep';
    }
}