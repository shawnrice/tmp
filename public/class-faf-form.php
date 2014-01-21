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
		unset($this->regions[$region] );
	}

	public function add_field( $region, $field ) {
		$this->regions[$region]['fields'][$field->get_name()] = $field;
	}

	public function remove_field( $region , $name ) {
		unset($this->regions[$region]['fields'][$name]);
	}

	public function print_form() {
		print ("<form name='$this->name' method='$this->method' action='$this->action'>\r\n");

		foreach( $this->regions as $region => $fields ) {
			print("<h2>$region</h2>\r\n");
			print("<table class='form-table'>\r\n");
			print("<tbody>");
			foreach( $fields as $field ) {
				foreach( $field as $f ) {
					$f->render();
				}
			}
			print("</tbody>");
			print("</table>\r\n");
		}

		if (! empty($this->submit) ) {
			print("<p class='submit'>\r\n");
			print("<input type='submit' name='submit' id='submit' class='button button-primary' value='$this->submit'>\r\n");
			print("</p>\r\n");
		}
		print("</form>\r\n");
	}

}

?>