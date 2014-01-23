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

wp_enqueue_script("jquery");
wp_enqueue_script("jquery-ui-core");
wp_enqueue_script("jquery-ui-dialog");
wp_enqueue_script("jquery-ui-draggable");
wp_enqueue_script("jquery-ui-droppable");
wp_enqueue_script("jquery-ui-sortable");
wp_enqueue_script("jquery-ui-accordion");
wp_enqueue_script("jquery-effects-core");
wp_enqueue_script("jquery-effects-fade");
// Put in the jQuery to make the fieldsets open and close
?>
  <script>
  $(function() {
    $(".toggle").click(function () {
        // check the visibility of the next element in the DOM
        if ($(this).next().is(":hidden")) {
            $(this).next().slideDown("fast"); // slide it down
        } else {
            $(this).next().hide("fast"); // hide it
        }
    });
  });
  </script>

 <?php

/***
 * Start switch statement...
 * Here, we're just using a switch statement to return the form for the field element.
 *
 ***/

switch ( $id ) :
case "field-element-text":
?>
	<h3>Configure Text Field Element</h3>
	<p>Enter a <span class="emph">&lt; label &gt;</span> for the field: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
	<p>Specify a size for the text field: <input type="text" size="5" value="100" style="text-align: right;"></p>
	<p>Specify the maximum length: <input type="text" size="5" value="255" style="text-align: right;"></p>
<?php
break;

case "field-element-textarea":
?>

	<h3>Configure Textarea Field Element</h3>
	<p>Enter a <span class="emph">&lt; label &gt;</span> for the field: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
	<p>Specify the number of rows for the text area: <input type="text" size="5" value="10" style="text-align: right;"></p>
	<p>Specify the number of columns for the text area: <input type="text" size="40" value="10" style="text-align: right;"></p>	
	<p>Specify the maximum length: <input type="text" size="5" value="255" style="text-align: right;"></p>
	<p><input type="checkbox"> Add placeholder text</p>

	
<?php

//  <p><input type="text" size="100" value="" style="text-align: right;"></p>
break;

case "field-element-list":
?>

	<script type="text/javascript">
			$('#spy').bind("enterKey",function(e){
			  var lines = $(this).val().split('\n');
			  var len = lines.length;
			  var dom = "<select class='default' name='default'><option value=''>---</option>";
				$.each(lines, function( index, element){

					if ( this != "" )
					{
						dom = dom + "<option value=\'" + this + "\'>" + this + "</option>";
					}
			  });
			  dom = dom + "</select>";
			  $("#written").html( dom );
			});
			$('#spy').keyup(function(e){
			    if(e.keyCode == 13)
			    {
			        $(this).trigger("enterKey");
			    }
			    if(e.keyCode == 8) 
			    {
			        $(this).trigger("enterKey");
			    }
			    if(e.keyCode == 46) 
			    {
			        $(this).trigger("enterKey");
			    }
			});
			$( "#spy" ).change(function() {
			    $(this).trigger("enterKey");
			});
	</script>

	<h3>Configure Select List Field Element</h3>
	<p> </p>

	<p>Enter a <span class="emph">&lt; label &gt;</span> for the field: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>

	<p>Would you like to include a <span class="emph">&lt; null value &gt;</span> option? <input type="radio" name="null" value="1" checked> Yes <input type="radio" name="null" value="0"> No</p>

	<p>Input the select list values on separate lines in the textarea below. You may input as many as you'd like.</p>
	<textarea id="spy" name="spy" rows="7" style="font-size: 1.2em; padding: 5px 10px; font-family: 'Open Sans'; width: 100%;"></textarea>


	<div style="">
		<p>Please select a <span class="emph">&lt; default &gt;</span> option:
			<span id="written"><select class='default' name='default'><option value=''>---</option></select></span>
		</p>
	</div>
<?php

	break;


case "field-element-checkbox":
?>
	<h3>Configure Checkbox Field Element</h3>
	<p></p>
	<p>Enter a <span class="emph">&lt; label &gt;</span> for the field: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
	<p>On value: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
	<p>Off value: <input type="text" style="font-size: 1.2em; padding: 5px; font-family: 'Open Sans'; width: 50%; margin-left: 10px;"></p>
<?php

break;


case "field-element-password":
?>
<h3>Configure Password Field Element</h3>

<?php
break;

case "field-element-radio":
?>
<h3>Configure Radio Field Element</h3>

<?php
break;

case "field-element-date-picker":
?>
<h3>Configure Date Picker Field Element</h3>

<?php
break;

case "field-element-time-picker":
?>
<h3>Configure Time Picker Field Element</h3>

<?php
break;

case "field-element-button":
?>
<h3>Configure Button Field Element</h3>

<?php
break;

case "field-element-hidden":
?>
<h3>Configure Hidden Field Element</h3>

<?php
break;


default:
?>
	<p>What are you doing here?</p>
<?php
	echo $id;
	break;
endswitch;
?>
	<div style="border: 1px black solid; margin-top: 2em;">
		<span class="toggle" style="cursor:pointer; margin-left: 2em; padding: 0 .5em; display:inline-block; background: #fff; position:relative; top: -.8em; left: -1em;">More Attributes &raquo;</span>
		<div style="display: none; margin: 1em 2em 2em 2em;">
			<table>
				<tr>
					<td><label for="required">Required</label></td>
					<td><input id="required" name="required" type="checkbox"></td>
				</tr>
				<tr>
					<td><label for="disabled">Disabled</label></td>
					<td><input id="disabled" name="disabled" type="checkbox"></td>
				</tr>
				<tr>
					<td><label for="read-only">Read Only</label></td>
					<td><input id="read-only" name="read-only" type="checkbox"></td>
				</tr>
			</table>
		</div>
	</div>

<div style="text-align:right; padding-right: 20px; margin-top: 40;">
	<input type="submit" value="Submit">
	<input id="cancel-element" type="submit" value="Cancel">
	<input type="submit" value="Remove">
</div>
<script>
	$('#formid').serializeArray();
</script>
<?php

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
 * if ( is_admin() ) {
 *   ...
 * }
 *
 */

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-form-and-field-admin.php' );
	add_action( 'plugins_loaded', array( 'Form_And_Field_Admin', 'get_instance' ) );

	require_once( plugin_dir_path( __FILE__ ) . 'public/class-faf-field.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'public/class-faf-form.php' );

	// These have to be loaded in a specific order because of how they extend each other
	require_once( plugin_dir_path( __FILE__ ) . 'public/fields/class-faf-field-text.php');  	// Priority A1
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


function form_and_field_install() {

}











