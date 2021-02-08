<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('roles', ChoiceType::class,
                [
                    'choices' =>
                    [
                        'User'  => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'required' => true
                ]
            );

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(

            function ($rolesArray) {

                if (count($rolesArray)) {
                    $test = $rolesArray[0];
                } else {
                    $test = null;
                }

                dd($test);

//                return count($rolesArray) ? $rolesArray[0] : null;
            },

            function ($rolesString) {

                return [$rolesString];
            }
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
