<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class ProfileType
 * @package App\Form
 */
class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var array $imageConstraints */
        $imageConstraints = [
            new Image([
                'maxSize' => '5M'
            ])
        ];

        $builder
            ->add('firstname', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('lastname', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('avatar', FileType::class,
                [
                    'mapped'        => false,
                    'required'      => false,
                    'constraints'   => $imageConstraints
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
