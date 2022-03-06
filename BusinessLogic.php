<?php
ini_set('display_errors', 1); //for debugging
ini_set('display_startup_errors', 1); //for debugging
ini_set('memory_limit', 1073741824); //just about 1 GB memory allocation, XML manipulation is expensive
include("Product.php");
class BusinessLogic{

    public function MapLineToProduct($line){    
        $product= new Product();    
        $product->brand_name=$line[0]??  throw new Exception("file has missing required field:brand name");
        $product->model_name=$line[1]?? throw new Exception("file has required field:model name");
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
        $counter=0;
        foreach($products as $product) {
            if($counter != count($products)-1){ //last element has no product details
                echo $header->brand_name.": ".$product->brand_name."\n";
                echo $header->model_name.": ".$product->model_name."\n";
                echo $header->condition_name.": ".$product->condition_name."\n";
                echo $header->gb_spec_name.": ".$product->gb_spec_name."\n";
                echo $header->colour_name.": ".$product->colour_name."\n";
                echo $header->network_name.": ".$product->network_name."\n";
                echo "-------------------------------------------------\n\n";    
            }
            $counter++;
        }
    }
    public function printProductCount($products,$counted, $output){
        if(count($products) < 1){
            throw new Exception("This file does not have any products.");
        }
        $fp = fopen($output, 'a');//open output file in append mode  
        $header=new Product(); //headers can change, let's get from file
        $header->brand_name=$products[0]->brand_name?? '';
        $header->model_name=$products[0]->model_name?? '';
        $header->condition_name=$products[0]->condition_name?? '';
        $header->gb_spec_name=$products[0]->gb_spec_name?? '';
        $header->colour_name=$products[0]->colour_name?? '';
        $header->network_name=$products[0]->network_name?? '';
        unset($counted[0]); //remove the headers
        foreach($counted as $k => $v) {
            $productString="";
            $p=explode("_",$k);
            $productString .= $header->brand_name.": ".$p[0]."\n";
            $productString .= $header->model_name.": ".$p[1]."\n";
            $productString .= $header->condition_name.": ".$p[2]."\n";
            $productString .= $header->gb_spec_name.": ".$p[3]."\n";
            $productString .= $header->colour_name.": ".$p[4]."\n";
            $productString .= $header->network_name.": ".$p[5]."\n";
            $productString .= "count:"." ".$v."\n";
            $productString .= "-----------------------------------------------\n\n";
            fwrite($fp, $productString);  
        }
        echo "File parsing done and summary file written to: ".$output;
        fclose($fp);   //close file, we are done
    }





}
