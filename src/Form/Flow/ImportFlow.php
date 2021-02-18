<?php

namespace App\Form\Flow;

use App\Form\ImportForms\ImportFileForm;
use App\Form\ImportForms\ImportMatchFieldsForm;
use App\Form\ImportForms\ImportQuestionForm;
use Craue\FormFlowBundle\Form\FormFlow;

/**
 * Class ImportFlow
 * @package App\Form\Flow
 */
class ImportFlow extends FormFlow
{
    /**
     * @return array|string[]
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'Questions',
                'form_type' => ImportQuestionForm::class,
            ],
            [
                'label' => 'Excel file',
                'form_type' => ImportFileForm::class,
            ],
            [
                'label' => 'Matches fields',
                'form_type' => ImportMatchFieldsForm::class,
            ],
            [
                'label' => 'Confirmation'
            ]
        ];
    }
}