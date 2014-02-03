<?php

class FAF_Field_Double extends FAF_Field {

	protected $first_placeholder;
	protected $second_placeholder;
	protected $first_max_length;
	protected $second_max_length;
	protected $first_size;
	protected $second_size;
	protected $first_value;
	protected $second_value;

	public function __construct( $name, $label ) {
		$this->set_name( $name );
		$this->set_type( 'double' );
		$this->set_label( $label );
		$this->classes = array( "form-field" );

		return TRUE;
	}


	public function set_first_placeholder( $placeholder ) {
		$this->first_placeholder = $placeholder;
	}

	public function get_first_placeholder( $placeholder ) {
		return $this->first_placeholder;
	}

	public function set_first_max_length( $max_length ) {
		$this->first_max_length = $max_length;
	}

	public function get_first_max_length( $max_length ) {
		return $this->max_length;
	}

	public function set_first_size( $size ) {
		$this->first_size = $size;
	}

	public function get_first_size( $size ) {
		return $this->first_size;
	}

	public function set_first_value( $value ) {
		$this->first_value = $value;
	}

	public function get_first_value( $value ) {
		return $this->first_value;
	}

	public function set_second_placeholder( $placeholder ) {
		$this->second_placeholder = $placeholder;
	}

	public function get_second_placeholder( $placeholder ) {
		return $this->second_placeholder;
	}

	public function set_second_max_length( $max_length ) {
		$this->second_max_length = $max_length;
	}

	public function get_second_max_length( $max_length ) {
		return $this->max_length;
	}

	public function set_second_size( $size ) {
		$this->second_size = $size;
	}

	public function get_second_size( $size ) {
		return $this->second_size;
	}

	public function set_second_value( $value ) {
		$this->second_value = $value;
	}

	public function get_second_value( $value ) {
		return $this->second_value;
	}


	public function render_field() {

		$return = "<td>";
		$return .= '<input type="hidden" name="count" value="1" />';
		$return .= "<input name='$this->name' id='$this->id' type='text' ";


		if ( isset( $this->classes ) ) {
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

		if ( isset( $this->size ) ) {
			$return .= " size='$this->size' ";
		}

		if ( isset( $this->max_length ) ) {
			$return .= " max_length='$this->max_length' ";
		}

		if ( isset( $this->placeholder ) ) {
			$return .= " placeholder='$this->placeholder' ";
		}

		if ( isset( $this->value ) ) {
			$return .= " value='$this->value' ";
		}

		$return .= "></td> ";

		$return .= "<td><input name='$this->name' id='$this->id' type='text' ";


		if ( isset( $this->classes ) ) {
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

		if ( isset( $this->size ) ) {
			$return .= " size='$this->size' ";
		}

		if ( isset( $this->max_length ) ) {
			$return .= " max_length='$this->max_length' ";
		}

		if ( isset( $this->placeholder ) ) {
			$return .= " placeholder='$this->placeholder' ";
		}

		if ( isset( $this->value ) ) {
			$return .= " value='$this->value' ";
		}

		$return .= "></td><td valign='middle'><div class='faf-add-button'> </div></td>";


		return $return;
	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	public function render() {
		// For simple fields, do not override this function. Since this is two fields as one, it needs to be
		// overridden.
		
		$return = "<tr valign='top' class='form-field";
		if ( $this->required ) {
			$return .= " form-required'>\r\n";
		} else {
			$return .= "'>\r\n";
		}
		$return .= "<th scope='row'><label for='$this->name'>$this->label:</label></th>\r\n";

		$return .= "<td>\r\n";
		$return .= "<table class='faf-double-field-table'>\r\n";
		$return .= "<tr valign='top'>";
		// if ( isset( $this->wrapper ) ) {
		// 	$return .= '<' . $this->wrapper['element'] . ' id="' . $this->wrapper['id'] . '"';
		// 	if ( isset( $this->wrapper['class'] ) && is_array( $this->wrapper['class'] ) && ( count( $this->wrapper['class'] > 0 ) ) ) {
		// 		$return .= " class='";
		// 		foreach ( $this->wrapper['class'] as $class ) {
		// 			$return .= "$class ";
		// 		}
		// 		$return .= "'";
		// 	}
		// 	$return .= ">\r\n";
		// }
		$return .= $this->render_field() . "\r\n";
		// if ( isset( $this->wrapper ) ) {
		// 	$return .= '</' . $this->wrapper['element'] . ">\r\n";
		// }

		$return .= "</tr>\r\n";
		$return .= "</table>\r\n";

		if ( isset( $this->description ) && ( ! empty( $this->description ) ) ) {
			$return .= "<span class='faf-description'>" . $this->description . "</span>\r\n";
		}

		$return .= "</td>\r\n";
		$return .= "</tr>\r\n";

		print $return;

	}

}

?>
