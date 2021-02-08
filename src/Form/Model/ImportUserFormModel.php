<?php

namespace App\Form\Model;

use App\Services\ImportHelper;

/**
 * Class ImportUserFormModel
 * @package App\Form\Model
 */
class ImportUserFormModel
{

    private $importHelper;

    /**
     * ImportUserFormModel constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    public $duplicateEmail;

    public $importFile;

    public $extraFields;

//    /**
//     * @return array
//     */
//    public function getExtraFields(): array
//    {
//        return $this->extraFields;
//    }
//
//    /**
//     * @param array $extraFields
//     */
//    public function setExtraFields(array $extraFields): void
//    {
//        $this->extraFields = $extraFields;
//    }
}