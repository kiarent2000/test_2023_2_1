<?php

/*
Скрипт працює за умови, що на вхід подажається зображення чорно-біле розміром 300 на 300 пікселів.

Також можна зробити, що скрипт автоматично працював з зображеннями різного розміру.

Для роботи скрипта потрібна бібліотека ImageMagik7

Нахил зображення повинен бути невеликим, я задав допуски до 20 пікселів

Також допускаються невеликі шуми

*/

$imagick = new Imagick();
$imagick->readImage('triangle.jpg');

$width=300;
$height=0;

$diff=array();

while($height<=300) //проходимо всі рядки зображення по висоті і вираховуємо кількість чорних пікселів
{	
  $pixels = $imagick->exportImagePixels(0, $height, $width, 1, "R", Imagick::PIXEL_CHAR); 
  $a=0;
  $b=0;
  
  foreach($pixels as $pixel)
  {
	 if($pixel===255) {$a++;} else {$b++;}
  }
  
  $diff_value =  $b - $a;
  
  if($a<290)
  {
	$diff[]=$diff_value; // заповняємо масив з кількстью чорних пікселів
  }
  $height++;
}

$min=min($diff);
$max=max($diff);

if(($max-$min)<20) // якщо різниця між рядком з найбільшою кількістю пікселів і рядком з найменшою кількстью пікселів незначна, то скоріше за все це квадрат 
{
   echo "На рисунке изображен квадрат"; 
}  elseif(($max - count($diff)<20)) {   // якщо різниця між максимальною кількістью пікселів і кількістю непустих рядків невелика, то скоріше це коло.
   echo "На рисунке изображен круг";
}  else {
   echo "На рисунке изображен треугольник";
}



?>