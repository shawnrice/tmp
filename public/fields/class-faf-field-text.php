<?php

class FAF_Field_Text extends FAF_Field {

	protected $placeholder;
	protected $max_length;
	protected $size;
	protected $value;

	public function __construct($name, $label) {
		$this->set_name($name);
		$this->set_type('text');
		$this->set_label($label);
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function set_placeholder($placeholder) {
		$this->placeholder = $placeholder;
	}

	public function get_placeholder($placeholder) {
		return $this->placeholder;
	}

	public function set_max_length($max_length) {
		$this->max_length = $max_length;
	}

	public function get_max_length($max_length) {
		return $this->max_length;
	}

	public function set_size($size) {
		$this->size = $size;
	}

	public function get_size($size) {
		return $this->size;
	}

	public function set_value($value) {
		$this->value = $value;
	}

	public function get_value($value) {
		return $this->value;
	}

	public function render_field() {

		$return = "<input name='$this->name' type='text' ";


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

		if ( isset($this->size) ) {
			$return .= " size='$this->size' ";
		}

		if ( isset($this->max_length) ) {
			$return .= " max_length='$this->max_length' ";
		}

		if ( isset($this->placeholder) ) {
			$return .= " placeholder='$this->placeholder' ";
		}

		if ( isset($this->value) ){
			$return .= " value='$this->value' ";
		}

		$return .= ">\r\n";

		return $return;
	}

}

?>