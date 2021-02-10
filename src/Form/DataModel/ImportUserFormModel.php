<?php

namespace App\Form\DataModel;

use App\Entity\User;

/**
 * Class ImportUserFormModel
 * @package App\Form\DataModel
 */
class ImportUserFormModel
{
    /** @var string */
    public $entity;

    /** @var int */
    public $duplicateEmail;

    public $importFile;

//    public static function getValidEntityNames() {
//        return [
//            'page' => 'Page',
//            'post' => 'Post',
//            'user' => 'User',
//        ];
//    }

    public array $entityFields = ['entity_username', 'entity_email'];

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