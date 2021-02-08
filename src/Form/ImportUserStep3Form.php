<?php

namespace App\Form;

use App\Services\ImportHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImportUserStep3Form
 * @package App\Form
 */
class ImportUserStep3Form extends AbstractType
{
    /**
     * @var ImportHelper
     */
    private $importHelper;

    /**
     * ImportUserStep3Form constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

//      $userEntityFields = $this->importHelper->getUserEntityFields();
        $userEntityFields = ['username', 'email', 'lastname', 'firstname'];   // FORM LABEL
        $headersTest = ['username', 'emails', 'lastName'];                  // OPTIONS for select

//      dd($userEntityFields, $headersTest, 'DIE');

        foreach ($userEntityFields as $userField) {

            $test[$userField] = array_flip($headersTest);

            $builder->add('extraFields', ChoiceType::class,
                [
                    'label'       => $userField,
                    'placeholder' => 'Choose a column from the excel file',
                    'choices'     => $test,
                    'multiple'    => false,
                    'expanded'    => false,
                    'required'    => false
                ]
            );
        }

//        $builder->get('extraFields')->addModelTransformer(new CallbackTransformer(
//
//            function ($extraFieldsArray) {
//
////                dd($extraFieldsArray);
//
//                if (count($extraFieldsArray)) {
//                    $test = $extraFieldsArray[0];
//                } else {
//                    $test = null;
//                }
//
//                dd($test);
//
//                return count($extraFieldsArray) ? $extraFieldsArray[0] : null;
//            },
//
//            function ($extraFieldsString) {
//                return [$extraFieldsString];
//            }
//        ));

//        $builder->addModelTransformer(new CollectionToArrayTransformer(), true);

//        $builder
//            ->get('extraFields')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($array) {
//
//                    dump('transform the array to a string');
//                    dd($array);
//                    // transform the array to a string
//                    $work = count($array)? $array[0]: null;
//
//                    dd($work);
//
//                    return $work;
//                },
//
//                function ($string) {
//                    // transform the string back to an array
//                    dump('transform the string back to an array');
//                    return [$string];
//                }
//            ));
    }

    /**
     * @return mixed
     */
    public function getBlockPrefix()
    {
        return 'importUserStep3';
    }
}