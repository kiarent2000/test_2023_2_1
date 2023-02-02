<?php 
declare(strict_types=1);
session_start();
if($_SESSION['data']){
$data=$_SESSION['data'];
}

spl_autoload_register(function ($class) {
    include __DIR__ . '../../class/'.$class.'.php';
});



try
{
	$result = $_SESSION['data'][$_POST['arr']['elem']];
	
	if($result)
	{
		echo '<b>Курс: </b>'. $result;
	} else {
		echo "Курс на дану дату не знайдено!";
	}

} 
    catch (Exception $ex) {
    echo $ex->getMessage();
}


?>