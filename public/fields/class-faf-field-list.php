<?php

class FAF_Field_List extends FAF_Field {
	protected $options = array();
	protected $value;
	protected $multiple;
	protected $other;

	public function __construct( $name, $label ) {
		$this->set_name( $name );
		$this->set_type( 'select' );
		$this->set_label( $label );
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function add_option( $name, $value = '' ) {
		if ( empty( $value ) ) {
			$value = strtolower( $name );
		} else {
			$value = strtolower( $value );
		}
		if ( ! in_array( $name, $this->options ) ) {
			$this->options[$name] = array( "name" => $name, "value" => $value );
		}
	}

	public function remove_option( $name ) {
		if ( in_array( $name, array_keys( $this->options ) ) ) {
			unset( $this->options[$name] );
		}
	}

	public function get_option( $name ) {
		return $this->options[$name];
	}

	public function get_all_options() {
		return $this->options;
	}

	public function set_default( $name ) {
		if ( in_array( $name, array_keys( $this->options ) ) ) {
			$this->value = $name;
		}
	}

	// This might need to be altered.
	public function get_default() {
		return $this->value;
	}

	public function set_multiple( $multiple ) {
		if ( is_bool( $multiple ) ) {
			$this->multiple = $multiple;
		} else {
			return "The multiple value needs to be a bool.";
		}
	}

	public function get_multiple() {
		return $this->multiple;
	}

	public function set_other( $bool ) {
		$this->other = $bool;
	}
	public function get_other() {
		return $this->other;
	}

	public function render_field() {
		$return = "<select name='$this->name'";

		if ( ! empty( $this->classes ) ) {
			$return .= " class='" . implode( " ", $this->classes ) . "' ";
		}

		if ( isset( $this->required ) ) {
			if ( $this->required ) {
				$return .= " required ";
			}
		}

		if ( isset( $this->disabled ) ) {
			if ( $this->disabled ) {
				$return .= " disabled ";
			}
		}

		$return .=">\r\n";
		foreach ( $this->options as $option ) {
			$return .= "<option value='" . $option['value'] . "'";

			if ( $this->value == $option['name'] ) {
				$return .= " selected ";
			}
			$return .= ">" . $option['name'] . "</option>\r\n";

		}

		if ( $this->other ) {
			$return .= "<option value='other'>Other</option>\r\n";
		}

		$return .= "</select>\r\n";

		if ( $this->other ) {
			$return .= "<ul><li><label>Please Specify: <input type='text' value=''";
			$return .= " name='" . $this->name . "_other'></label></li></ul>\r\n";
		}

		return $return;
	}

}

?>
