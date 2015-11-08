<?php

ini_set('memory_limit', '1000M');

require_once 'classes/PHPExcel/IOFactory.php';

$excel = PHPExcel_IOFactory::load("input.xlsx");
$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
$writer->setDelimiter(",");
$writer->setEnclosure("");
$writer->setLineEnding("\r\n");
$writer->setSheetIndex(0);
$writer->save("input.csv");


function getJsonFromCsv($file,$delimiter) { 
    if (($handle = fopen($file, 'r')) === false) {
        die('Error opening file');
    }

    $headers = fgetcsv($handle, 4000, $delimiter);
    $csv2json = array();

    while ($row = fgetcsv($handle, 4000, $delimiter)) {
      $csv2json[] = array_combine($headers, $row);
    }

    fclose($handle);
    return json_encode($csv2json); 
}

$file = 'input.csv';
$current = getJsonFromCsv($file, ',');
$fileJson = 'country.json';
file_put_contents($fileJson, $current);
