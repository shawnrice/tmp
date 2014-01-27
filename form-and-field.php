<?php
/**
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Form and Field
 * @author    Shawn Patrick Rice <rice@shawnrice.org>asdf
 * @license   GPL-2.0+
 * @link      http://asdf
 * @copyright 2014 Shawn Patrick Rice
 *
 * @wordpress-plugin
 * Plugin Name:       Form and Field
 * Plugin URI:        @TODO
 * Description:       Build custom forms through the admin interface.
 * Version:           1.0.0
 * Author:            Shawn Patrick Rice
 * Author URI:        http://www.shawnrice.org
 * Text Domain:       form-and-field-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/shawnrice/form-and-field
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// This is for the callback for the adding the field thingie. Man, I need to sleep.
add_action( 'wp_ajax_dd_ajax' , 'faf_configure_field_form' );


// I need to make this "hook-able" to allow other people extend it with other fields...
function faf_configure_field_form($id) {
// Get the form element type
$id = $_POST['id'];

// Get the other data if posted.
// $data = ....;

// Create the form.
$form = new FAF_Form('faf_configure_field_form');

// Create two regions.
$form->add_region('Configure Element');
$form->add_region('More Attributes');

// Create the fields shared on each 
$name = new FAF_Field_Text('name', 'Name');
$name->set_required(TRUE);
$name->set_max_length(60);
$name->set_size(50);
$name->set_id('name');
$name->set_description('Alphanumeric characters only.');

$label = new FAF_Field_Text('label', 'Label');
$label->set_required(TRUE);
$label->set_max_length(100);
$label->set_size(50);
$label->set_description('Enter the label text for the field.');

$desc = new FAF_Field_Text('description', 'Description');
$desc->set_size(50);
$desc->set_description('Set any help text to be displayed for the field.');

$classes = new FAF_Field_Text('classes', 'Classes');
$classes->set_size(50);
$classes->set_description('Specify any CSS classes you want to add. Separate them with a space.');

$form->add_field('Configure Element', $name);
$form->add_field('Configure Element', $label);
$form->add_field('Configure Element', $desc);
$form->add_field('Configure Element', $classes);

// These are generic enough that we'll create the fields here and just queue them below.
$size = new FAF_Field_Text('width' , 'Width');
$size->set_description('Specify a size for the text field.');
$size->set_size(10);
$max_length = new FAF_Field_Text('max_length', 'Max Length');
$max_length->set_description('Specify a maximum length for the text field.');
$max_length->set_size(10);
$placeholder = new FAF_Field_Text('placeholder', 'Placeholder Text');
$placeholder->set_size(50);
$placeholder->set_description('Enter any placeholder text that you want.');

$type = new FAF_Field_Hidden('type', 'Type');
$type->set_id('faf-type');
/***
 * Start switch statement...
 * Here, we're just using a switch statement to return the form for the field element.
 *
 ***/

switch ( $id ) :
	case "field-element-text":
		$type->set_value('text');
		$form->add_field('Configure Element', $size);
		$form->add_field('Configure Element', $max_length);
		$form->add_field('Configure Element', $placeholder);
		break;

	case "field-element-password":
		$form->add_field('Configure Element', $size);
		$form->add_field('Configure Element', $max_length);
		$form->add_field('Configure Element', $placeholder);
		$type->set_value('password');
	break;

	case "field-element-textarea":

	// These are for the textarea field.
		$rows = new FAF_Field_Text('rows', 'Rows');
		$rows->set_description('Enter the number of rows for field.');
		$rows->set_size(10);
		$cols = new FAF_Field_Text('cols', 'Columns');
		$cols->set_size(10);
		$cols->set_description('Enter the number of columns for field.');
		$type->set_value('textarea');

		$form->add_field('Configure Element', $rows);
		$form->add_field('Configure Element', $cols);
		$form->add_field('Configure Element', $max_length);
		$form->add_field('Configure Element', $placeholder);
	break;

	case "field-element-list":
		$options = new FAF_Field_Textarea('options', 'Options');
		$options->set_required(TRUE);
		$options->set_id('spy');
		$options->set_cols(49);
		$options->set_rows(6);
		$options->set_description('Enter the options for the select list one per line.');

		$default = new FAF_Field_List('default', 'Default');
		$default->add_class('default');
		$default->add_option('---', '');
		$default->set_wrapper('span' , 'written' , '' );
		$default->set_description('Select a default option.');
		$type->set_value('list');
		$form->add_field('Configure Element', $options);
		$form->add_field('Configure Element', $default);
	break;


	case "field-element-checkbox":
		$type->set_value('checkbox');
	?>
		<h3>Configure Checkbox Field Element</h3>
		<p></p>
		<p>Enter a <span class="emph">&lt; label &gt;</span> for the field: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
		<p>On value: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
		<p>Off value: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
	<?php

	break;

	case "field-element-radio":
		$type->set_value('radio');
	?>
	<h3>Configure Radio Field Element</h3>

	<?php
	break;

	case "field-element-hidden":

		$value = new FAF_Field_Text('value', 'Hidden Value');
		$value->set_placeholder('Enter the value of the hidden field');
		$value->set_required(TRUE);
		$type->set_value('hidden');
		$form->add_field('Configure Element', $value);
	break;

	/* These need to be written for "core" FAF
	 *
	case "field-element-date-picker":
	break;

	case "field-element-time-picker":
	break;

	case "field-element-button":
	break;
	*/


	default:
	?>
		<p>What are you doing here? If you're seeing this, then somehow you've managed to call a field that doesn't exist. Don't do it again.</p>
	<?php
		echo $id;
		break;
endswitch;
?>


<?php
// <div style="text-align:right; padding-right: 20px; margin-top: 40;">
// 	<input id='dialog-submit' type="submit" value="Submit">
// 	<input id="cancel-element" type="submit" value="Cancel">
// 	<input type="submit" value="Remove">
// </div>
// </form>
?>

<?php
	
	// These options should be valid for every field but hidden ones.
	if ($id != 'field-element-hidden') {
		$read_only = new FAF_Field_Radio('read_only', 'Read Only');
		$read_only->add_option('On', 'on');
		$read_only->add_option('Off', 'off');
		$read_only->set_default('Off');
		$disabled = new FAF_Field_Radio('disabled', 'Disabled');
		$disabled->add_option('On', 'on');
		$disabled->add_option('Off', 'off');	
		$disabled->set_default('Off');
		$required = new FAF_Field_Radio('required', 'Required');
		$required->add_option('On', 'on');
		$required->add_option('Off', 'off');
		$required->set_default('Off');	

		$form->add_field('More Attributes' , $required);
		$form->add_field('More Attributes' , $disabled);
		$form->add_field('More Attributes' , $read_only);
		$form->add_field('More Attributes' , $type);
	}

	$form->print_form();

	// This is important to make sure that the ajax callback works.
	die();

}


require_once( plugin_dir_path( __FILE__ ) . 'public/class-form-and-field.php' );



/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/



/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */

register_activation_hook( __FILE__, array( 'Form_And_Field', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Form_And_Field', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Form_And_Field', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Form_And_Field', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * 
 *   ...
 * }
 *
 */

// if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-form-and-field-admin.php' );
	add_action( 'plugins_loaded', array( 'Form_And_Field_Admin', 'get_instance' ) );

	require_once( plugin_dir_path( __FILE__ ) . 'public/class-faf-field.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'public/class-faf-form.php' );

	// These have to be loaded in a specific order because of how they extend each other
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-text.php');  	// Priority A1
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-hidden.php');  	// Priority A2	
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-textarea.php');  // Priority A2	
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-password.php');  // Priority A2
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-list.php');  	// Priority B1
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-radio.php'); 	// Priority B2
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-checkbox.php');  // Priority B3
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-number.php');  	// Priority A2


	// Load all the individual field classes in the field folder but not listed above
	foreach (glob( plugin_dir_path( __FILE__ ) . 'public/fields/*.php') as $class)
	{
	    require_once($class);
	}

	// Currently empty, but this is where others can load their fields
	do_action('form_and_field_register_add_on_fields');
	// Currently empty, but this is where others can load their locations
	do_action('form_and_field_register_add_on_locations');

}


function form_and_field_enqueue_jquery_validation() {

	// Microsoft CDN
	// http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js
	// http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js

	// faf_jquery_validate_cdnjs : local | cdnjs | microsoft
	// add_option( 'faf_jquery_validate_cdn' , $cdn );
	// update_option( 'faf_jquery_validate_cdn' , $cdn );
	// delete_option( 'faf_jquery_validate_cdn' , $cdn );

	if ( get_option( 'faf_jquery_validate_cdn' , FALSE ) ) {

		$cdnjs = "//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js";
		$cdnjs_additional = "//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.min.js";

		wp_register_script('jquery_validate', $cdnjs , array('jquery'), 'null', TRUE);
		wp_register_script('jquery_validate_additional', $cdnjs_additional , array('jquery', 'jquery_validate'), 'null', TRUE);

	} else {

		$base = ( plugin_dir_path( __FILE__ ) . 'assets/js/jquery.validate');
		wp_register_script('jquery_validate', "$base/jquery.validate.min.js" , array('jquery'), 'null', TRUE);
		wp_register_script('jquery_validate_additional', "$base/additional-methods.min.js" , array('jquery', 'jquery_validate'), 'null', TRUE);

	}

	wp_enqueue_script('jquery_validate');
	wp_enqueue_script('jquery_validate_additional');

}

