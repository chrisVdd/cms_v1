<?php

namespace App\Form;

use Craue\FormFlowBundle\Form\FormFlow;

/**
 * Class ImportUserFlow
 * @package App\Form
 */
class ImportUserFlow extends FormFlow
{
    /**
     * @return array|string[]
     */
    protected function loadStepsConfig()
    {
        return [
            // STEP 1
            [
                'label'     => 'Questions',
                'form_type' => ImportUserStep1Form::class
            ],
            // STEP 2
            [
                'label'     => 'Excel file',
                'form_type' => ImportUserStep2Form::class
            ],
//            // STEP 3
            [
                'label'     => 'Matches fields',
                'form_type' => ImportUserStep3Form::class,
            ],
            // STEP 4
            [
                'label' => 'confirmation'
            ]
        ];
    }

//    /**
//     * @param $step
//     * @param array $options
//     * @return array
//     */
//    public function getFormOptions($step, array $options = [])
//    {
//        /** @var array $options */
//        $options = parent::getFormOptions($step, $options);
//
//        if ($step === 3) {
//
////            dump($this->getFormData());
//
//            $options['headers'] = [];
//        }
//
//        return $options;
//    }
}