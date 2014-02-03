<?php

class FAF_Form {

	protected $name;
	protected $submit;
	protected $regions = array();

	public function __construct( $name ) {
		$this->name = $name;
		$this->method = 'POST';
		$this->action = $_SERVER['PHP_SELF'] . "?page=" . $_GET['page'];
	}

	public function set_submit( $submit ) {
		$this->submit = $submit;
	}

	public function get_submit() {
		return $this->submit;
	}

	public function add_region( $region ) {
		$this->regions[$region] = array();
	}

	public function remove_region( $region ) {
		unset( $this->regions[$region] );
	}

	public function add_field( $region, $field ) {
		$this->regions[$region]['fields'][$field->get_name()] = $field;
	}

	public function remove_field( $region , $name ) {
		unset( $this->regions[$region]['fields'][$name] );
	}

	public function set_region_description( $region , $description ) {
		$this->regions[$region]['description'] = $description;
	}

	public function remove_region_description( $region ) {
		unset( $this->regions[$region]['description'] );
	}

	public function print_form() {
		if ( ( ! isset( $this->id ) ) || empty( $this->id ) ) {
			$this->id = $this->name;
		}
		print ( "<form id='$this->id' name='$this->name' method='$this->method' action='$this->action'>\r\n" );

		foreach ( $this->regions as $region => $fields ) {
			print( "<span class='faf-form-region'>$region</span>\r\n" );
			if ( isset( $this->regions[$region]['description'] ) ) {
				print( "<span class='faf-form-region-description'>" . $this->regions[$region]['description'] . "</span>\r\n" );
			}
			print( "<table class='form-table'>\r\n" );
			print( "<tbody>" );
			foreach ( $fields as $key => $field ) {
				if ( $key != 'description' ) {
					foreach ( $field as $f ) {
						$f->render();
					}
				}
			}
			print( "</tbody>" );
			print( "</table>\r\n" );
		}

		// if (! empty($this->submit) ) {
		//  print("<p class='submit'>\r\n");
		//  print("<input type='submit' name='submit' id='submit' class='button button-primary' value='$this->submit'>\r\n");
		//  print("</p>\r\n");
		// }
		print( "</form>\r\n" );
	}

}

?>
