<?php


namespace App\Entity;


use App\Form\DataModel\ImportUserFormModel;

/**
 * Class ImportContainer
 * @package App\Entity
 */
class ImportContainer
{
    /**
     * @var array
     */
    public $forms;

    /**
     * @var ImportUserFormModel
     */
    public $import;

    /**
     * @var
     */
    public $currentPlace;

    /**
     * ImportContainer constructor.
     * @param $import
     * @param $forms
     */
    public function __construct($import, $forms)
    {
        $this->import = $import;
        $this->forms = $forms;
    }
}