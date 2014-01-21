<?php

class FAF_Field_Password extends FAF_Field_Text {

	public function render_field() {

		$return = "<input name='$this->name' type='password' ";

		if ( isset($this->classes) ) {
			$return .= " class='" . implode(" ", $this->classes) . "' ";
		}
		if ( isset($this->size) ) {
			$return .= " size='$this->size' ";
		}

		if ( isset($this->max_length) ) {
			$return .= " max_length='$this->max_length' ";
		}

		if ( isset($this->disabled) ) {
			if ($this->disabled) {
				$return .= " disabled ";
			}
		}

		if ( isset($this->required) ) {
			if ($this->required) {
				$return .= " required ";
			}
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