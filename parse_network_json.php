<?php
// Achtung im Tag counter sind massiv leere einträge

error_reporting(E_ALL);

require_once 'exhibit-json-parser.inc.php';
require_once 'exhibit-taxo-parser.inc.php';

$query = new EntityFieldQuery();

$for_type = 'expert';

$res = $query
->entityCondition('entity_type', 'node', '=')
->propertyCondition('status', 1, '=')
->propertyCondition('type', $for_type)->execute();

$nids = array_keys($res['node']);

// $nids= array($res[0]);

$nodes = $links = array();
$tag_count = array();

/*
 * nodes
 */


foreach ($nids as $id) { // node entries and edges

  	$wrapper = entity_metadata_wrapper('node', $id);

    // print_r($wrapper->getPropertyInfo());
    // print_r($wrapper->title->value());

  	$terms = array(); // store for edges

	foreach ($wrapper->field_policy_areas->value() as $val) {
	   $val = (object) $val;
	   if(empty($val->name)) continue; // empty vals will crash viz
	   $tag_count[$val->name]++; // Tag counter
	    $term = array(
			'name' => $val->name,
			'id' => $val->tid,
      		'artist' => $val->tid
	    );
	    $nodes[$val->name] = $term; // single val per node
	    $terms[$val->tid] = $val->name;
	}



	/*
	 * edges for node
	 */
	$stack = $terms = array_keys($terms);

	while ($x = array_pop ( $stack )) {
		$diff = array_diff($terms, array($x));
		$y = array_fill_keys($diff, $x);
		//print_r($y);
		foreach ($y as $target => $source) {
			$links[] = array(
					'source' => $source,
					'target' => $target
				);
		}
	}
	/* end edges */

} // foreach ($nids as $id) 

// Tag count
$nodes = array_values($nodes);

foreach ($nodes as &$term) {
        $count = $tag_count[$term['name']] ;
        $term['match'] = 1;
        $term['playcount'] = $count * 1000000;    	
}

//print_r($nodes);

//print_r($links);

$json = array(
	'nodes' => $nodes,
	'links' => $links
	);
$json = drupal_json_encode($json);
print_r($json);





