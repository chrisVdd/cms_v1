<?php

namespace App\Form\Model;


/**
 * Class ImportUserFormModel
 * @package App\Form\Model
 */
class ImportUserFormModel
{

    public $duplicateEmail;

    public $importFile;

    /** @var array array */
    public $extraFields =  [];

    /**
     * @return array
     */
    public function getExtraFields(): array
    {
        return $this->extraFields;
    }

    /**
     * @param array $extraFields
     */
    public function setExtraFields(array $extraFields): void
    {
        $this->extraFields = $extraFields;
    }


}