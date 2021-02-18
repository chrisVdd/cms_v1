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
        $builder
            ->add('entity', ChoiceType::class,
                [
                    'label'     => 'For which entity do you to import datas?',
                    'choices'   =>
                        [
                            // 'Page'  => 'page',
                            // 'Post'  => 'post',
                            'User'  => 'user',
                        ]
                ]
            )
            ->add('deleteStandards', ChoiceType::class,
                [
                    'data' => 0,
                    'choices' =>
                        [
                            'Yes' => 1,
                            'No'  => 0
                        ]
                ]
            )
            ->add('deteteTests', ChoiceType::class,
                [
                    'data' => 0,
                    'choices' =>
                        [
                            'Yes' => 1,
                            'No'  => 0
                        ]
                ]
            )
            ->add('duplicateEmail', ChoiceType::class,
                [
                    'data' => 0,
                    'choices' =>
                        [
                            'Skip this user'      => 0,
                            'Insert this user'    => 1,
                            'Overwrite this user' => 2,
                        ]
                ]
            )
            ->add('emptyEmails', ChoiceType::class,
                [
                    'data' => 0,
                    'choices' =>
                    [
                        'Skip this user'   => 0,
                        'Insert this user' => 1,
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