<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("BusinessLogic.php");
$bl=new BusinessLogic();
//$bl->ReadCSVFile("examples/products_comma_separated.csv");
//$bl->readJsonFile("examples/products_comma_separated.json");
//$bl->jsonToCSV("examples/products_comma_separated.json", "examples/new_products_comma_separated.csv");
//$bl->ReadCSVFile("examples/new_products_comma_separated.csv");
//$bl-> xml2csv("examples/products_comma_separated.xml", "examples/new_from_xml_products_comma_separated.csv");
$bl->ReadCSVFile("examples/new_from_xml_products_comma_separated.csv");
?>