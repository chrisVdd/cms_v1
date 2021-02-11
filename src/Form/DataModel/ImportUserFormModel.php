<?php

namespace App\Form\DataModel;

use App\Entity\User;
use App\Services\ImportHelper;

/**
 * Class ImportUserFormModel
 * @package App\Form\DataModel
 */
class ImportUserFormModel
{
    /** @var string */
    public string $entity;

    /** @var int */
    public int $duplicateEmail;

    public $importFile;

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return int
     */
    public function getDuplicateEmail(): int
    {
        return $this->duplicateEmail;
    }

    /**
     * @param int $duplicateEmail
     */
    public function setDuplicateEmail(int $duplicateEmail): void
    {
        $this->duplicateEmail = $duplicateEmail;
    }
}