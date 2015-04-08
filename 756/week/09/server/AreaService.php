<?php
	class AreaService {
		/**
		 * Say "hello"
		 * @return string $hello
		 */
		 function helloWorld() {
		 	return "Hello World";
		 }
		 
		 /**
		   * Calculate the area of a rectangle
		   * 
		   * @param double $width
		   * @param double $height
		   * @return double $area
		 */
		 function calcRectangle($width, $height) {
		 	return $width *$height;
		 	
		 }
		 
		 /**
		   * Calculate the area of a cirlce
		   * 
		   * @param double $radius
		   * @return double $area
		 */
		 function calcCircle($radius) {
		 	return $radius*$radius;
		 	
		 }
		 
		 /**
		   * @param string $name
		   * @param int $age
		   * @return string $nameWithAge
		 */
		 function getNameWithAge($name, $age) {
		 	return "Your name is: $name and you are $age years old";
		 }

		 /**
		   * @param int $max
		   * @return string[] $count
		 */
		 function countTo($max) {
		 	$array = array();
		 	for ($i=0; $i < $max; $i++) {
		 		$array[] = "Number: ".($i+1);
		 	}
		 	return $array;
		 }

	}
?>