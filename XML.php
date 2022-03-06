<?php
ini_set('display_errors', 1); //for debugging
ini_set('display_startup_errors', 1); //for debugging
ini_set('memory_limit', 1073741824); //just about 1 GB memory allocation, XML manipulation is expensive
class XML
{
    function readXmlFile($xmlFile, $output)
    {
        try {
            $csv = new CSV();
            if (file_exists($xmlFile)) { //let's turn our XML to CSV, easier to manipulate that way     
                $xmlFileArray = explode(".", $xmlFile);
                $csvFile = $xmlFileArray[0] . ".csv"; //use same location and filename as the xml doc
                $headerAdded = false;
                $xml = simplexml_load_file($xmlFile); //simplexml_load_file is an easier api to use for this
                $f = fopen($csvFile, 'w');
                if ($xml->getName() != "root") { //xml structure is important
                    die("Please see the structure of xml supported in examples/products_comma_separated.xml");
                }
                foreach ($xml->row as $row) {
                    if ($row->getName() != "row") { //xml structure is important
                        die("Please see the structure of xml supported in examples/products_comma_separated.xml");
                    }
                    if (!$headerAdded) {
                        $headers = array();
                        foreach ($xml->children()->children() as $child)  //add headers to our csv, this are element names in xml doc              
                        {
                            $headers[] = $child->getName();
                        }
                        fputcsv($f, $headers, ',', '"');
                        $headerAdded = true;
                    }
                    fputcsv($f, get_object_vars($row), ',', '"');
                }
                fclose($f);
                $csv->ReadCSVFile($csvFile, $output); //let's deal with out CSV file now
                gc_collect_cycles(); //php often has issues dealing with large xml file and not freeing up memory
            } else {
                throw new Exception("file missing");
            }
        } catch (Exception $ex) {
        }
    }
}
