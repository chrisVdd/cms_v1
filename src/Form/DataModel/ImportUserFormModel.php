<?php

namespace App\Form\DataModel;

use App\Entity\User;
use App\Services\ImportHelper;

/**
 * Class ImportUserFormModel
 * @package App\Form\DataModel
 */
class ImportUserFormModel extends User
{

    private ImportHelper $importHelper;

    /**
     * ImportMatchFieldsForm constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    /** @var string */
    public string $entity;

    /** @var int */
    public int $deleteStandards;

    /** @var int */
    public int $deteteTests;

    /** @var int */
    public int $duplicateEmail;

    /** @var int */
    public int $emptyEmails;

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
    public function getDeleteStandards(): int
    {
        return $this->deleteStandards;
    }

    /**
     * @param int $deleteStandards
     */
    public function setDeleteStandards(int $deleteStandards): void
    {
        $this->deleteStandards = $deleteStandards;
    }

    /**
     * @return int
     */
    public function getDeteteTests(): int
    {
        return $this->deteteTests;
    }

    /**
     * @param int $deteteTests
     */
    public function setDeteteTests(int $deteteTests): void
    {
        $this->deteteTests = $deteteTests;
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

    /**
     * @return int
     */
    public function getEmptyEmails(): int
    {
        return $this->emptyEmails;
    }

    /**
     * @param int $emptyEmails
     */
    public function setEmptyEmails(int $emptyEmails): void
    {
        $this->emptyEmails = $emptyEmails;
    }
}