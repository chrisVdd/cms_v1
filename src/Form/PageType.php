<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Template;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package App\Form
 */
class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subTitle')
            ->add('content', CKEditorType::class)
            ->add('template', TemplateType::class)
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
            'data_class' => Page::class,
        ]);
    }
}