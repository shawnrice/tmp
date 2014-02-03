<?php
/**
 * Plugin Name.
 *
 * @package   Form_And_Field_Admin
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Form_And_Field
 * @author  Shawn Patrick Rice <email@example.com>
 */
class FAF_Field {

	public $name;
	protected $label;
	protected $description;
	protected $type;
	protected $id;

	public function __construct( $name, $label, $type ) {
		// I need to do some sanitization functions on this.
		$this->set_name( $name );
		$this->set_type( $type );
		$this->set_label( $label );
		$this->set_id( $name );
		$this->classes = array( "form-field" );

		return TRUE;
	}

	public function set_name( $name ) {
		$this->name = $name;
	}

	public function get_name() {
		return $this->name;
	}

	public function set_label( $label ) {
		$this->label = $label;
	}

	public function get_label() {
		return $this->label;
	}

	public function set_id( $id ) {
		$this->id = $id;
	}
	public function get_id() {
		return $this->id;
	}

	public function set_description( $description ) {
		$this->description = $description;
	}

	public function get_description() {
		return $this->description;
	}

	public function set_type( $type ) {
		$this->type = $type;
	}

	public function get_type() {
		return $this->type;
	}

	public function set_wrapper( $element , $id , $class = array() ) {
		$options = array( 'div', 'p', 'span' );
		if ( ! in_array( $element, $options ) )
			return;
		$this->wrapper = array( 'element' => $element, 'id' => $id, 'class' => $class );
	}

	public function remove_wrapper() {
		unset( $this->wrapper );
	}

	public function get_wrapper() {
		return $this->wrapper;
	}

	public function set_required( $required ) {
		if ( $required ) {
			$this->required = TRUE;
			$this->add_class( 'required' );
		} else {
			$this->required = FALSE;
			$this->remove_class( 'required' );
		}
	}

	public function get_required() {
		return $this->required;
	}

	public function set_disabled( $disabled ) {
		if ( $disabled ) {
			$this->disabled = TRUE;
		} else {
			$this->disabled = FALSE;
		}
	}

	public function get_disabled() {
		return $this->disabled;
	}


	public function set_read_only( $read_only ) {
		if ( $read_only ) {
			$this->read_only = TRUE;
		} else {
			$this->read_only = FALSE;
		}
	}

	public function get_read_only() {
		return $this->read_only;
	}


	public function add_class( $class ) {
		array_push( $this->classes, $class );
	}

	public function remove_class( $class ) {
		unset( $this->classes[array_search( $class , $this->classes )] );
	}

	public function get_classes() {
		return $this->classes;
	}
	/**
	 * Retrieve set attribute of a field
	 *
	 * @param array   $attribute the array of attributes to query
	 * @return array             the array of attributes with the values
	 */
	public function get_attributes( $attributes ) {

		if ( ! is_array( $attributes ) ) {
			return false;
		}

		$return = array();

		foreach ( $attributes as $att ) {
			$return[$att] = $att;
		}

	}

	public function set_attribute( $name , $value ) {
		$name = "set_" . $name;

		if ( method_exists( $this, $name ) ) {
			$this->$name( $value );
		}
		else {
			print( "$this->name doesn't have the $name property." );
		}

	}

	public function render() {
		$return = "<tr valign='top' class='form-field";
		if ( $this->required ) {
			$return .= " form-required'>\r\n";
		} else {
			$return .= "'>\r\n";
		}
		$return .= "<th scope='row'><label for='$this->name'>$this->label:</label></th>\r\n";
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
		if ( isset( $this->description ) && ( ! empty( $this->description ) ) ) {
			$return .= "<span class='faf-description'>" . $this->description . "</span>\r\n";
		}
		$return .= "</td>\r\n";

		$return .= "</tr>\r\n";

		print $return;

	}

}


?>
