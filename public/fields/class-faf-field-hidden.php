<?php

class FAF_Field_Hidden extends FAF_Field {

	protected $value;
	protected $id;
 	
 	public function __construct($name, $label) {
		// I need to do some sanitization functions on this.
		$this->set_name($name);
		$this->set_type('hidden');
		$this->set_label($label);
		$this->set_id($name);
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function set_value( $value ) {
		$this->value = $value;
	}

	public function get_value() {
		return $this->value;
	}

	public function render_field() {

		$return = "<input name='$this->name' type='hidden' ";


		if ( isset($this->classes) ) {
			$return .= " class='" . implode(" ", $this->classes) . "' ";
		}

		if ( isset($this->required) ) {
			if ($this->required) {
				$return .= " required ";
			}
		}

		if ( isset($this->disabled) ) {
			if ($this->disabled) {
				$return .= " disabled ";
			}
		}

		if ( isset($this->id) ) {
			$return .= " id='$this->id' ";
		}

		if ( isset($this->value) ){
			$return .= " value='$this->value' ";
		}

		$return .= ">\r\n";

		return $return;
	}

	// Since this particular field is hidden, we shouldn't put it in the table.
	public function render() {
		$return = "<tr valign='top' class='form-field";
		if ($this->required) {
			$return .= " form-required'>\r\n";
		} else {
			$return .= "'>\r\n";
		}
		$return .= "<th scope='row'><label for='$this->name'></label></th>\r\n";
		$return .= "<td>\r\n";
		if ( isset( $this->wrapper ) ) {
			$return .= '<' . $this->wrapper['element'] . ' id="' . $this->wrapper['id'] . '"';
			if ( isset( $this->wrapper['class'] ) && is_array( $this->wrapper['class'] ) && ( count( $this->wrapper['class'] > 0 ) ) ) {
				$return .= " class='";
				foreach ( $this->wrapper['class'] as $class ) {
					$return .= "$class ";
				}
				$return .= "'";
			}
			$return .= ">\r\n";
		}
		$return .= $this->render_field() . "\r\n";
		if ( isset( $this->wrapper ) ) {
			$return .= '</' . $this->wrapper['element'] . ">\r\n"; 
		}
		$return .= "</td>\r\n";
		
		$return .= "</tr>\r\n";

		print $return;

	}	

}

?>