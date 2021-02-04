<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ImportHelper
 * @package App\Services
 */
class ImportHelper
{
    /**
     * @param string $filename
     * @return array
     */
    public function loadDocument(string $filename)
    {

//        @todo -> update for something better than this
        $path = __DIR__.'/../../import_uploaded/data_import/'.$filename;

        $spreadSheet = IOFactory::load($path);

        // $row = $spreadSheet->getActiveSheet();

        $sheetDatas = $spreadSheet->getActiveSheet()->toArray();

        $header = $sheetDatas[0];
        dd($sheetDatas, $header);

        return $sheetDatas;
    }
}