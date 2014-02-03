Extending Form and Field
========================

Form and Field (FAF) can be extended for more use cases.

When you write your own plugins, make sure that you add in
	if ( is_plugin_active( 'form_and_field/form_and_field.php' ) ) {
		// for an admin area
	}

And

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// check for plugin using plugin name
	if ( is_plugin_active( 'form_and_field' ) ) {
	  //plugin is activated
	} 

Otherwise.

look here for more: http://www.presscoders.com/2011/11/deactivate-wordpress-plugin-automatically/


Something

Create a new field type
-----------------------

To create a new field type, start, at minimum, by extending the base FAF_Field class. There are
only two functions that you need to overwrite, __construct. and render_field().

Render field should simply _return_ the markup for your new field.

	class MY_NEW_CLASS extends FAF_Field {
		
		public function __construct() {

		}

		public function render_field() {

			$return =  "";
			$return .= "";

			return $return;
		}

	}


Register a new location
-----------------------

To register a new location, create a function that will add to the locations array.

	function some_function_extends_faf_locations( $locations ) {
		'admin_settings' => array(
			'label' => __( 'Options Page', 'form-and-field' ),
			'type'	=> 'admin-options-menu',
			'value' => ''
		),
		$locations['boone'] = array(
			'label' => "Boone's location",
		);
	}
	add_filter( 'faf_form_locations', 'bbg_extend_faf_locations' );

The location is tripartite:
	'label'


The location needs to let us know what "type" of location it is. You must specify one of these options:

1. action
2. admin-options-menu
3. page

Register a new handler
----------------------

	function some_function_extends_faf_handlers( $handlers ) {
		$handlers['my_handler_name'] = array(
			'label' => __('My Label' , 'form_and_field'),
			'description' => __('My description', 'form_and_field'),
			'function' => 'my_function_name',
		);
	}

	add_filter( 'faf_form_handlers', 'some_function_extends_faf_handlers' );
	}

