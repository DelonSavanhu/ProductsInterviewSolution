<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', 1073741824);
include("Product.php");
class BusinessLogic{
public function ReadCSVFile($path){
try{
    
$products=array();
$file = fopen($path,"r");
while(!feof($file))
  {
  $products[]=$this->MapLineToProduct(fgetcsv($file));  
  }  
  $this->printProducts($products);
  $counts = array_count_values(array_column($products, 'hash'));
  //$bl->printProductCount(array_slice($products,0,1,true),$counts); //we slice, we only need headers
  fclose($file);
}catch (Throwable $ex){
    echo $ex->getMessage();
    
}
    }
    public function MapLineToProduct($line){    
        $product= new Product();    
        $product->brand_name=$line[0]?? '';// throw new Exception("required field");
        $product->model_name=$line[1]?? '';
        $product->condition_name=$line[2]?? '';
        $product->gb_spec_name=$line[3]?? '';
        $product->colour_name=$line[4]?? '';
        $product->network_name=$line[5]?? '';
        $product->hash=strtolower($product->brand_name."_".$product->model_name."_".$product->condition_name."_".$product->gb_spec_name."_".$product->colour_name."_".$product->network_name);
       return $product;
    }
    public function printProducts($products){
        if(count($products) < 1){
            throw new Exception("This file does not have any products.");
        }
        $header=new Product(); //headers can change, let's get from file
        $header->brand_name=$products[0]->brand_name?? throw new Exception("required field");
        $header->model_name=$products[0]->model_name?? '';
        $header->condition_name=$products[0]->condition_name?? '';
        $header->gb_spec_name=$products[0]->gb_spec_name?? '';
        $header->colour_name=$products[0]->colour_name?? '';
        $header->network_name=$products[0]->network_name?? '';
        unset($products[0]); //remove the headers
        foreach($products as $product) {
            echo $header->brand_name." ".$product->brand_name."<br>";
            echo $header->model_name." ".$product->model_name."<br>";
            echo $header->condition_name." ".$product->condition_name."<br>";
            echo $header->gb_spec_name." ".$product->gb_spec_name."<br>";
            echo $header->colour_name." ".$product->colour_name."<br>";
            echo $header->network_name." ".$product->network_name."<br>";
            echo "<hr><br>";
        }
    }
    public function printProductCount($products,$counted){
        if(count($products) < 1){
            throw new Exception("This file does not have any products.");
        }
        $header=new Product(); //headers can change, let's get from file
        $header->brand_name=$products[0]->brand_name?? '';
        $header->model_name=$products[0]->model_name?? '';
        $header->condition_name=$products[0]->condition_name?? '';
        $header->gb_spec_name=$products[0]->gb_spec_name?? '';
        $header->colour_name=$products[0]->colour_name?? '';
        $header->network_name=$products[0]->network_name?? '';
        unset($counted[0]); //remove the headers
        foreach($counted as $k => $v) {
            $p=explode("_",$k);
            echo $header->brand_name." ".$p[0]."<br>";
            echo $header->model_name." ".$p[1]."<br>";
            echo $header->condition_name." ".$p[2]."<br>";
            echo $header->gb_spec_name." ".$p[3]."<br>";
            echo $header->colour_name." ".$p[4]."<br>";
            echo $header->network_name." ".$p[5]."<br>";
            echo "count:"." ".$v;
            echo "<hr><br>";
        }
    }
    function readJsonFile($file)
    {
        if (($json = file_get_contents($file)) == false)
        die('Error reading json file...');
        $data = json_decode($json, false, 10);
        $products[]=$this->MapLineToProduct(fgetcsv($data));  
        $this->printProducts($products);
        $counts = array_count_values(array_column($data, 'hash'));
        //$bl->printProductCount(array_slice($products,0,1,true),$counts); //we slice, we only need headers
    }

    function jsonToCSV($jfilename, $cfilename)
    {
    if (($json = file_get_contents($jfilename)) == false)
        die('Error reading json file...');
    $data = json_decode($json, true);
    $fp = fopen($cfilename, 'w');
    $header = false;
    foreach ($data as $row)
    {
        if (empty($header))
        {
            $header = array_keys($row);
            fputcsv($fp, $header);
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row));
    }
    fclose($fp);
    return;
}
function xml2csv($xmlFile, $csvFile) {
try{
  if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $f = fopen($csvFile, 'w');
    
    foreach ($xml->row as $row) {
        fputcsv($f, get_object_vars($row),',','"');
    }
    fclose($f);
//    }
//    $this->createCsv($xml, $f);
    fclose($f);
    gc_collect_cycles();
}else{
    throw new Exception("file missing");
}
}catch(Exception $ex){}
}
function createCsv($xml,$f)
 {
       foreach ($xml->children() as $item) 
        {
           $hasChild = (count($item->children()) > 0)?true:false;
           if( ! $hasChild)
           {
              $put_arr = array($item->getName(),$item); 
              fputcsv($f, $put_arr ,',','"');
           }
           else
           {
              $this->createCsv($item, $f);
           }
        }
 }
}


?>