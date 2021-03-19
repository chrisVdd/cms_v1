<?php

namespace App\Form;

use App\Entity\Widget;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class WidgetType
 * @package App\Form
 */
class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', EntityType::class,
            [
                'class'     => Widget::class,
                'multiple'  => true,
                'expanded'  => false,
            ]
        );
    }
}
