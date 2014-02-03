<?php

class FAF_Field_Number extends FAF_Field_Text {

	protected $min;
	protected $max;
	protected $size;
	protected $value;

	public function __construct( $name, $label ) {
		$this->set_name( $name );
		$this->set_type( 'number' );
		$this->set_label( $label );
		$this->classes = array( "form-field" );


		return TRUE;
	}

	public function set_min( $min ) {
		$this->min = $min;
	}

	public function get_min() {
		return $this->min;
	}

	public function set_max( $max ) {
		$this->max = $max;
	}

	public function get_max() {
		return $this->max;
	}

	public function set_value( $value ) {
		if ( is_numeric( $value ) ) {
			$this->value = $value;
		}
	}

	public function get_value() {
		return $this->value;
	}


	public function render_field() {
		$return = "<input name='$this->name' type='number' ";

		if ( isset( $this->classes ) ) {
			$return .= " class='" . implode( " ", $this->classes ) . "' ";
		}
		if ( isset( $this->size ) ) {
			$return .= " size='$this->size' ";
		}

		if ( isset( $this->disabled ) ) {
			if ( $this->disabled ) {
				$return .= " disabled ";
			}
		}

		if ( isset( $this->required ) ) {
			if ( $this->required ) {
				$return .= " required ";
			}
		}

		if ( isset( $this->placeholder ) ) {
			$return .= " placeholder='$this->placeholder' ";
		}

		if ( isset( $this->value ) ) {
			$return .= " value='$this->value' ";
		}

		if ( isset( $this->max ) ) {
			$return .= " max='$this->max' ";
		}

		if ( isset( $this->min ) ) {
			$return .= " min='$this->min' ";
		}

		$return .= ">\r\n";

		return $return;
	}

}

?>
