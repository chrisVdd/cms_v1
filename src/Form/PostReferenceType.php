<?php

namespace App\Form;

use App\Entity\PostReference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Class PostReferenceType
 * @package App\Form
 */
class PostReferenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', VichFileType::class);
//            ->add('filename', FileType::class,
//                [
//                    'data_class' => null,
//                    'attr' =>
//                    [
//                        'class' => 'dropzone'
//                    ],
//                ]
//            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostReference::class,
            "allow_extra_fields" => true,
        ]);
    }
}
