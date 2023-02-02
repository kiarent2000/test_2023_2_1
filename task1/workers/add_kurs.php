<?php 
declare(strict_types=1);
session_start();
if(@$_SESSION['data']){
$data=$_SESSION['data'];
}

spl_autoload_register(function ($class) {
    include __DIR__ . '../../class/'.$class.'.php';
});



try
{
	$data[$_POST['arr']['date']]=$_POST['arr']['curs']; 
	$_SESSION['data']=$data; 
	
	$sorted = (new ArrayClass($_SESSION['data']))->sort();
	
	$result=array();
	
	$result['arr']=$sorted;
	$result['status']="ok";
	
	echo json_encode($result);

} 
    catch (Exception $ex) {
    echo $ex->getMessage();
}


?>