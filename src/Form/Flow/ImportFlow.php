<?php

namespace App\Form\Flow;

use App\Form\ImportForms\ImportFileForm;
use App\Form\ImportForms\ImportMatchFieldsForm;
use App\Form\ImportForms\ImportQuestionForm;
use App\Services\ImportHelper;
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

    private ImportHelper $importHelper;

    /**
     * ImportMatchFieldsForm constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    /**
     * @param $step
     * @param array $options
     * @return array
     */
    public function getFormOptions($step, array $options = [])
    {
        $options = parent::getFormOptions($step, $options);
        $formData = $this->getFormData();

        $csvDatas = $this->importHelper->getCleanImportDatas();
        $properChoicesList = array_combine($csvDatas[0], $csvDatas[0]);

        if ($step === 3) {
            $options['csvHeaders'] = $properChoicesList;
        }

        return $options;
    }
}