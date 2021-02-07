<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class PostType
 * @package App\Form
 */
class PostType extends AbstractType
{
    private $slugger;

    /**
     * PostType constructor.
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

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
            ->add('title', null,
                [
                    'attr' => ['autofocus' => true]
                ]
            )
            ->add('content', CKEditorType::class)
            ->add('categories', EntityType::class,
                [
                    'class' => Category::class,
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->add('imageFilename', FileType::class,
                [
                    'mapped'        => false,
                    'required'      => false,
                    'constraints'   => $imageConstraints,
                ]
            )
            ->add('online', CheckboxType::class, 
                ['label_attr' => ['class' => 'switch-custom']]
            )
            
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
