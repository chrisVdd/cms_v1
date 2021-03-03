<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class ImportHelper
 * @package App\Services
 */
class ImportHelper
{
    private FilesystemInterface $importFilesystem;
    private EntityManagerInterface $entityManager;

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
     * @throws Exception
     */
    public function loadDocument(string $filename)
    {

        // @todo -> update for something better than this
        $path = __DIR__.'/../../import_uploaded/data_import/'.$filename;

        $reader = IOFactory::createReaderForFile($path);
        $spreadSheet = $reader->load($path);
        $reader->setReadDataOnly(true);

        $workSheet = $spreadSheet->getActiveSheet();

        $datas = [];

        foreach ($workSheet->getRowIterator() as $row) {

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            $tmp_row = [];

            foreach ($cellIterator as $cell) {

                $tmp_row[] = $cell->getValue();
            }

            $datas[] = $tmp_row;
        }

        return $datas;
    }

    /**
     * >> example of string: 'App:User'
     *
     * @param string $className
     * @return mixed[]
     */
    public function getEntityFields(string $className)
    {
        $allFields = $this->entityManager
            ->getClassMetadata('App:'.lcfirst($className))
            ->getColumnNames();

        return $allFields;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCleanImportDatas()
    {
        $listFolder = $this->importFilesystem->listContents(null, true);

        /** @var array $lastFileMetadatas */
        $lastFileMetadatas = $listFolder[array_key_last($listFolder)];

        $lastFilename = $lastFileMetadatas['basename'];

        return $this->loadDocument($lastFilename);
    }

}