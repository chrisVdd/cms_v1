<?php

namespace App\Form;

use App\Services\ImportHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImportUserStep3Form
 * @package App\Form
 */
class ImportUserStep3Form extends AbstractType
{
//    /**
//     * @var ImportHelper
//     */
//    private $importHelper;
//
//    /**
//     * ImportUserStep3Form constructor.
//     * @param ImportHelper $importHelper
//     */
//    public function __construct(ImportHelper $importHelper)
//    {
//        $this->importHelper = $importHelper;
//    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('testinput', TextType::class);

//        $userEntityFields = $this->importHelper->getUserEntityFields();
//
//        $headersTest = ['username', 'emails'];
//
//        foreach ($userEntityFields as $userField) {
//            $builder->add($userField, ChoiceType::class,
//                [
//                    'placeholder' => 'Choose a column from the excel file',
//                    'choices'     => $options['headers'],
//                    'choices'     => $headersTest,
//                    'multiple'    => false,
//                    'required'    => false
//                ]
//            );
//        }
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(
//            [
//                'headers' => 'Headers specify in plain text in ImportUserStep3Form for test purpose'
//            ]
//        );
//    }

    /**
     * @return mixed
     */
    public function getBlockPrefix()
    {
        return 'importUserStep3';
    }
}