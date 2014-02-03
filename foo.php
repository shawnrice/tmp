<?php

function faf_registered_locations() {
	$reg_loc = array(
		'foo' => array(
			'label' => __( 'This is the foo location', 'form-and-field' ),
		),
		'bar' => array(
			'label' => __( 'This is the bar location', 'form-and-field' ),
		),
	);

	return apply_filters( 'faf_form_locations', $reg_loc );
}

// ....
//

?>

<select name="location">
	<?php foreach ( faf_registered_locations() as $rl => $rl_data ) : ?>
		<option value="<?php esc_attr( $rl ) ?>"><?php esc_html( $rl_data['label'] ) ?></option>
	<?php endforeach ?>
</select>
