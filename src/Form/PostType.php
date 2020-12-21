<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $imageConstraints = [
            new Image([
                'maxSize' => '5M'
            ])
        ];

        $builder
            ->add('title')
            ->add('content')
            ->add('categories')
            ->add('imageFilename', FileType::class,
                [
                    'mapped'    => false,
                    'required'      => false,
                    'constraints'   => $imageConstraints,
                ]
            )
            ->add('online', CheckboxType::class, 
                ['label_attr' => ['class' => 'switch-custom']]
            )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
