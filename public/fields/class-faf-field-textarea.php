<?php


class FAF_Field_Textarea extends FAF_Field_Text {

	protected $rows;
	protected $cols;
	protected $wrap;

	/**
	 * [__construct description]
	 * @param [type] $name  [description]
	 * @param [type] $label [description]
	 */
	public function __construct($name, $label) {
		$this->set_name($name);
		$this->set_type('textarea');
		$this->set_label($label);
		$this->set_rows(4);
		$this->set_cols(80);
		$this->classes = array( "form-field" );
	}

	/**
	 * Set the number of rows for the textarea
	 * @param integer $rows number of rows
	 */
	public function set_rows( $rows ) {
		$this->rows = is_numeric($rows) ? $rows : $this->rows;
	}

	/**
	 * Returns the number of rows of the textarea
	 * @return integer number of rows
	 */
	public function get_rows() {
		return $this->rows;
	}

	/**
	 * Set the number of columns of the text area
	 * @param integer $cols number of columns
	 */
	public function set_cols( $cols ) {
		$this->cols = is_numeric($cols) ? $cols : $this->cols;
	}

	/**
	 * Returns the number of columns of the textarea
	 * @return integer the number of columns
	 */
	public function get_cols() {
		return $this->cols;
	}

	/** 
	 * Set the wrap on the text area to either hard or soft 
	 * @param string $wrap only takes "hard" or "soft"
	 */
	public function set_wrap( $wrap ) {
		$wrap = str_to_lower($wrap);
		if ( ! ( $wrap == "hard" || $wrap =="soft" ) ) {
			$this->wrap = $wrap;
		}
	}

	/**
	 * Returns the wrap variable
	 * @return string either "hard" or "soft"
	 */
	public function get_wrap() {
		return $this->wrap;
	}


	public function render_field() {
		$return = "<textarea name='$this->name' ";
		if ( isset($this->id) ) {
			$return .= " id='" . $this->id . "'";
		}
		if (! empty($this->classes)) {
				$return .= " class='" . implode(' ', $this->classes) . "' ";
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

		if ( isset($this->max_length) ) {
			$return .= " max_length='$this->max_length' ";
		}

		if ( isset($this->placeholder) ) {
			$return .= " placeholder='$this->placeholder' ";
		}

		if ( isset($this->cols) ) {
			$return .= " cols=$this->cols";
		}
		if ( isset($this->rows) ) {
			$return .= " rows=$this->rows";
		}
		$return .= ">";
		if ( isset($this->value) ) {
			$return .= $this->value;
		}
		$return .= "</textarea>";

		return $return;
	}


}