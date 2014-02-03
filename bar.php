<?php

function bbg_extend_faf_locations( $locations ) {
	$locations['boone'] = array(
		'label' => "Boone's location",
	);
}
add_filter( 'faf_form_locations', 'bbg_extend_faf_locations' );
