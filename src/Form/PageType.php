<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Widget;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class PageType
 * @package App\Form
 */
class PageType extends AbstractType
{
    private $slugger;

    /**
     * PageType constructor.
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
        $builder
            ->add('title')
            ->add('content', CKEditorType::class)
            ->add('template', TemplateType::class)
            ->add('online', CheckboxType::class)
            ->add('position', IntegerType::class)
            ->add('widgets', EntityType::class,
                [
                    'class' => Widget::class,
                    'multiple' => true,
                    'expanded' => true,
                ])
//            ->add('slug', TextType::class,
//                ['attr' => ['disabled' => 'disabled']]
//            )
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

                /** @var Page */
                $page = $event->getData();
                if (null !== $pageTitle = $page->getTitle()) {
                    $page->setSlug($this->slugger->slug($pageTitle)->lower());
                }
            });
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