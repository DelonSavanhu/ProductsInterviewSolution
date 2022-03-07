<?php
ini_set('display_errors', 1); //for debugging
ini_set('display_startup_errors', 1); //for debugging
ini_set('memory_limit', 1073741824); //just about 1 GB memory allocation, XML manipulation is expensive
class CSV
{
    public function ReadCSVFile($path, $output)
    { // function used to read CSV files
        try {
            if(!file_exists($path)){
                die("Input file was not found.");
            }
            $bl = new BusinessLogic();
            $products = array();
            $file = fopen($path, "r");
            while (!feof($file)) {
                $products[] = $bl->MapLineToProduct(fgetcsv($file));
            }
            $bl->printProducts($products);
            $counts = array_count_values(array_column($products, 'hash'));
            $bl->printProductCount(array_slice($products, 0, 1, true), $counts, $output); //we slice, we only need headers
            fclose($file);
        } catch (Throwable $ex) {
            echo $ex->getMessage();
        }
    }
}
