<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("Product.php");
include("BusinessLogic.php");
$products=array();
$bl=new BusinessLogic();
$file = fopen("examples/products_comma_separated.csv","r");
while(!feof($file))
  {
  $products[]=$bl->MapLineToProduct(fgetcsv($file));  
  }  
  $bl->printProducts($products);
  $counts = array_count_values(array_column($products, 'hash'));
  //$bl->printProductCount(array_slice($products,0,1,true),$counts); //we slice, we only need headers
  fclose($file);

?>