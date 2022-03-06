<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try{
include("BusinessLogic.php");
include("CSV.php");
include("JSON.php");
include("XML.php");

if (isset($argc)) {
    if($argc < 4){
        throw new Exception("Please check your command, it is missing arguments. Example usage: parser.php --file example_1.csv --unique-combinations=combination_count.csv");
    }
    if($argv[0] != "parser.php"){
        throw new Exception("Please specify the parse file as parse.php");
    }
    if($argv[1] != "--file"){
        throw new Exception("Please specify the input file argument --file");
    }
    if(strpos($argv[2],".") === false){
        throw new Exception("Please specify the input file example input.csv");
    }
    if(strpos($argv[3],"--unique-combinations=") === false){
        throw new Exception("Please specify the unique file output. Example --unique-combinations=output.txt");
    }

    //let's get input and output file details
    $inputFile=explode(".",$argv[2]);
    $outputFile=explode("=",$argv[3]);
    switch($inputFile[1]){ //swicth on input e=xtentions
        case "csv":
            $csv=new CSV();
            $csv->ReadCSVFile($argv[2],$outputFile[1]);
            break;
        case "json":
            $json=new JSON();
            $json->readJsonFile($argv[2],$outputFile[1]);
            break;
        case "xml":
            $xml=new XML();
            $xml->readXmlFile($argv[2],$outputFile[1]);
            break;
        default:
        echo "That file type is not supported yet. Please contact support to add new file types.";
    }
}
else {
	throw new Exception("argc and argv disabled\n");
}
}catch(Exception $ex){
    echo $ex->getMessage();
}
?>