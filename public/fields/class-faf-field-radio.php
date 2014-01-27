<?php

class FAF_Field_Radio extends FAF_Field_List {

	protected $options = array();

	public function __construct($name, $label) {
		$this->set_name($name);
		$this->set_type('radio');
		$this->set_label($label);
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function add_option( $name, $value = '' ) {
		if (empty($value)) {
			$value = strtolower($name);
		} else {
			$value = strtolower($value);
		}
		if (! in_array($name, $this->options ) ) {
			$this->options[$name] = array( "name" => $name, "value" => $value );
		}
	}

	public function remove_option( $name ) {
		if (in_array( $name, array_keys($this->options) )) {
			unset($this->options[$name]);
		}
	}

	public function render_field() {

		$return = "";
		$return .= "<ul>\r\n";

		foreach ($this->options as $name => $value) {
			$return .= "<li><label><input type='radio' ";
			$return .= " id='" . $name . "' ";
			if (! empty($this->classes)) {
				$return .= " class='" . implode(' ', $this->classes) . "' ";
			}
			$return .= " name='" . $this->name . "' ";
			$return .= " value='" . $value['value'] . "' ";
			if ($this->get_default() == $value['name']) {
				$return .= " checked";
			}
			$return .= ">$name</label></li>\r\n";
		}

		if ($this->other) {
			$return .= "<li><label><input type='radio' value='other'> Other </label></li>";
			$return .= "<li><label>Please Specify: <input type='text' value=''";
			$return .= " name='" . $this->name . "_other'></label></li>\r\n";
		}

		$return .= "</ul>";

		return $return;
	}



}

?>