<?php

namespace App\Form\Flow;

use App\Entity\Page;
use App\Entity\Post;
use App\Entity\User;
use App\Form\ImportForms\ImportEntityForm;
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
//    /**
//     * @var array|string[]
//     */
//    private array $mapEntity = [
//        Page::class,
//        Post::class,
//        User::class,
//    ];
//
//    public function getDataClass(array $properties) {
//        return$this->mapEntity;
//    }

    /**
     * @return array|string[]
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'Which entity',
                'form_type' => ImportEntityForm::class,
            ],
            [
                'label' => 'Excel file',
                'form_type' => ImportFileForm::class,
            ],
            [
                'label' => 'Questions',
                'form_type' => ImportQuestionForm::class,
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