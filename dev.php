<?php

$stack = $terms = array('one','two','tree');
/*
print_r(array_pop ( $terms ));
print_r(array_pop ( $terms ));
print_r(array_pop ( $terms ));
exit;
*/



	$edges = array(); // term connections
	$res = array();
	//while (sizeof($stack) > 0) {
	//	$x = array_pop ( $stack );
	while ($x = array_pop ( $stack )) {
		$diff = array_diff($terms, array($x));
		$y = array_fill_keys($diff, $x);
		//print_r($y);
		foreach ($y as $target => $source) {
			$res[] = array(
					'source' => $source,
					'target' => $target
				);
		}
	}


	print_r($res);



