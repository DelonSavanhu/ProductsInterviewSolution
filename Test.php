<?php
class Test{//this is a set of summy tests done in native code, I did not use any framework/library as instructed.

    public function testArgumentsFail(){
        $output=null;
        $retval=null;
        //exec ('php parser.php --file examples/all_fields_there.csv --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        exec ('php parser.php --file ',$output,$retval) ; //mimic command line execution
        if($output[0] == "Please check your command, it is missing arguments. Example usage: parser.php --file example_1.csv --unique-combinations=combination_count.csv"){
        echo "testArgumentsFail: Test Passed\n";
        }else{
            echo "testArgumentsFail: Test failed.\n";            
        }
    }

    public function testUnsupportedFileFail(){
        $output=null;
        $retval=null;
        exec ('php parser.php --file examples/all_fields_there.csvet --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        if($output[0] == "That file type is not supported yet. Please contact support to add new file types."){
        echo "testUnsupportedFileFail: Test Passed.\n";
        }else{
            echo "testUnsupportedFileFail: Test failed.\n";            
        }
    }
    public function testSummaryFileCreation(){
        $output=null;
        $retval=null;
        exec ('php parser.php --file examples/all_fields_there.csv --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        if(file_exists("combination_count.txt")){
        echo "testSummaryFileCreation: Test Passed.\n";
        }else{
            echo "testSummaryFileCreation: Test failed.\n";            
        }
    }
    public function testMissingInputFile(){
        $output=null;
        $retval=null;
        exec ('php parser.php --file examples/all_fields_there2.csv --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        if($output[0] == "Input file was not found."){
        echo "testMissingInputFile: Test Passed.\n";
        }else{
            echo "testMissingInputFile: Test failed.\n";            
        }
    }
    public function testRandomProduct(){
        $output=null;
        $retval=null;
        exec ('php parser.php --file examples/all_fields_there.csv --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        $fp = fopen("data.txt", 'a');//open output file in append mode 
        if(strpos(json_encode($output),"Karena") > 0){ //value is in our test file, it should be in our output
        echo "testRandomProduct: Test Passed.\n";
        }else{
            echo "testRandomProduct: Test failed.\n";            
        }
    }
    public function testMissingRequiredFieldMissing(){
        $output=null;
        $retval=null;
        exec ('php parser.php --file examples/new_products_comma_separated.csv --unique-combinations=combination_count.txt',$output,$retval) ; //mimic command line execution
        if($output[0] == "file has missing required field:brand name"){
        echo "testMissingRequiredFieldMissing: Test Passed.\n";
        }else{
            echo "testMissingRequiredFieldMissing: Test failed.\n";            
        }
    }
}
$test=new Test();
$test->testArgumentsFail();
$test->testUnsupportedFileFail();
$test->testSummaryFileCreation();
$test->testMissingInputFile();
$test->testRandomProduct();
$test->testMissingRequiredFieldMissing();
?>