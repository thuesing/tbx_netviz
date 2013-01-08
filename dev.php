<?php

$terms = array('one','two','two','tree');
$res = array();

foreach ($terms as $key => $value) {
	$res[$value]++;
}

print_r($res);





