<?php

namespace App\Form;

use App\Form\Model\ImportUserFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsImportFile;

/**
 * Class ImportUserFormType
 * @package App\Form
 */
class ImportUserFormType extends AbstractType
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
            )
            ->add('duplicateEmail', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Do nothing' => 0,
                            'Duplicate' => 1,
                            'Replace' => 2,
                        ]
                ]);

        $builder->get('importFile')->addEventListener(FormEvents::POST_SUBMIT,
            function(FormEvent $event) {
                $form = $event->getForm();

                dd($form->getParent(), $form->getData());

//                $this->setupColumnFields($form->getParent(), $form->getData());
            }
        );
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Bind the form to the model
        $resolver->setDefaults(
            ['data_class' => ImportUserFormModel::class]
        );
    }
}