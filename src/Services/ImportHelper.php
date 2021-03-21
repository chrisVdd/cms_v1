<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

/**
 * Class ImportHelper
 * @package App\Services
 */
class ImportHelper
{
    private Filesystem $importFilesystem;
    private EntityManagerInterface $entityManager;

    /**
     * ImportHelper constructor.
     * @param Filesystem $importUploadsFilesystem
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Filesystem $importUploadsFilesystem,
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
     * @throws FilesystemException
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