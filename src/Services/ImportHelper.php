<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ImportHelper
 * @package App\Services
 */
class ImportHelper
{
    private $importFilesystem;
    private $entityManager;

    /**
     * ImportHelper constructor.
     * @param FilesystemInterface $importUploadsFilesystem
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        FilesystemInterface $importUploadsFilesystem,
        EntityManagerInterface $entityManager)
    {
        $this->importFilesystem = $importUploadsFilesystem;
        $this->entityManager    = $entityManager;
    }

    /**
     * @param string $filename
     * @return array
     */
    public function loadDocument(string $filename)
    {

        // @todo -> update for something better than this
        $path = __DIR__.'/../../import_uploaded/data_import/'.$filename;

        $spreadSheet = IOFactory::load($path);
        $sheetDatas = $spreadSheet->getActiveSheet()->toArray();

        return $sheetDatas;
    }

    /**
     * @param array $sheetDatas
     * @return array
     */
    public function getHeaders(array $sheetDatas)
    {
//        $headers = array_flip($sheetDatas[0]);
        $headers = $sheetDatas[0];

//        foreach ($headers as $header) {
//            str_replace(' ', '_', $header);
////            dump($string_good_format);
//        }
//        die();
        return $headers;
    }

    /**
     * @return mixed[]
     */
    public function getUserEntityFields()
    {
        // @TODO > transform this to ge more generic and not just for user
        $userEntityFields = $this->entityManager->getClassMetadata('App:User')->getColumnNames();

        return $userEntityFields;
    }

    /**
     *
     */
    public function test()
    {
        $test = $this->importFilesystem;
    }

}