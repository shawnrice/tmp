<?php

class FAF_Field_Checkbox extends FAF_Field_Radio {

	public function __construct( $name, $label ) {
		$this->set_name( $name );
		$this->set_type( 'checkbox' );
		$this->set_label( $label );
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function render_field() {

		$return = "";
		$return .= "<ul>\r\n";

		foreach ( $this->options as $name => $value ) {
			$return .= "<li><label><input type='checkbox' ";
			$return .= " id='" . $name . "' ";
			if ( ! empty( $this->classes ) ) {
				$return .= " class='" . implode( ' ', $this->classes ) . "' ";
			}
			$return .= " name='" . $this->name . "' ";
			$return .= " value='" . $value . "' ";
			$return .= "> $name </label></li>\r\n";
		}

		if ( $this->other ) {
			$return .= "<li><label><input type='checkbox' value='other'> Other </label></li>";
			$return .= "<li><label>Please Specify: <input type='text' value=''";
			$return .= " name='" . $this->name . "_other'></label></li>\r\n";
		}

		$return .= "</ul>";

		return $return;
	}
}

?>
