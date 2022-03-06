<?php
ini_set('display_errors', 1); //for debugging
ini_set('display_startup_errors', 1); //for debugging
ini_set('memory_limit', 1073741824); //just about 1 GB memory allocation, XML manipulation is expensive
class JSON
{
    function jsonToCSV($jfilename, $cfilename)
    {
        if (($json = file_get_contents($jfilename)) == false)
            die('Error reading json file...');
        $data = json_decode($json, true);
        $fp = fopen($cfilename, 'w');
        $header = false;
        foreach ($data as $row) {
            if (empty($header)) {
                $header = array_keys($row);
                fputcsv($fp, $header);
                $header = array_flip($header);
            }
            fputcsv($fp, array_merge($header, $row));
        }
        fclose($fp);
        return;
    }
    function readJsonFile($file, $output) // I have chosen to use this function as the focal point because it make maintanance easier
    {
        $csv = new CSV();
        if (($json = file_get_contents($file)) == false)
            die('Error reading json file');
        $jsonFileArray = explode(".", $file);
        $csvFile = $jsonFileArray[0] . ".csv"; //use same location and filename as the xml doc
        $this->jsonToCSV($file, $csvFile);
        $fileStream = fopen($csvFile, "r");
        $csv->ReadCSVFile($csvFile, $output);
        fclose($fileStream);
    }
}
