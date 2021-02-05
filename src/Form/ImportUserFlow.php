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
            [
                'label' => 'Questions',
                'form_type' => ImportUserStep1Form::class
            ],
            [
                'label' => 'Excel file',
                'form_type' => ImportUserStep2Form::class
            ],
            [
                'label' => 'Matches fields',
                'form_type' => ImportUserStep3Form::class,
            ],
            [
                'label' => 'confirmation'
            ]
        ];
    }
}