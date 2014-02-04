<?php

class FAF_Field_Key_Value extends FAF_Field {

	protected $key_placeholder;
	protected $value_placeholder;
	protected $key_max_length;
	protected $value_max_length;
	protected $key_size;
	protected $value_size;

	protected $values;
	protected $rows;

	public function __construct( $name, $label ) {
		$this->set_name( $name );
		$this->set_type( 'key-value' );
		$this->set_label( $label );
		$this->classes = array( 'form-field' , 'faf-key-value-variable-field' );

		$this->values = array();

		return TRUE;
	}

	public function add_value( $key , $value ) {
		if ( ! in_array( $key, $this->values ) ) {
			$this->values[$key] = $value;
		}
	}

	public function get_value( $key ) {
		return $this->values[$key];
	}

	public function get_all_values() {
		return $this->values;
	}

	public function set_rows( $rows ) {
		$this->rows = $rows;
	}

	public function get_rows() {
		return $this->rows;
	}

	public function set_key_placeholder( $placeholder ) {
		$this->key_placeholder = $placeholder;
	}

	public function get_key_placeholder( $placeholder ) {
		return $this->key_placeholder;
	}

	public function set_key_max_length( $max_length ) {
		$this->key_max_length = $max_length;
	}

	public function get_key_max_length( $max_length ) {
		return $this->max_length;
	}

	public function set_key_size( $size ) {
		$this->key_size = $size;
	}

	public function get_key_size( $size ) {
		return $this->key_size;
	}


	public function set_value_placeholder( $placeholder ) {
		$this->value_placeholder = $placeholder;
	}

	public function get_value_placeholder( $placeholder ) {
		return $this->value_placeholder;
	}

	public function set_value_max_length( $max_length ) {
		$this->value_max_length = $max_length;
	}

	public function get_value_max_length( $max_length ) {
		return $this->max_length;
	}

	public function set_value_size( $size ) {
		$this->value_size = $size;
	}

	public function get_value_size( $size ) {
		return $this->value_size;
	}


	/**
	 * [render_field description]
	 *
	 * @todo Make it so that I can fill in the goddamn values.
	 * @todo Make a way to sort the values...
	 * @return [type] [description]
	 */
	public function render_field() {

		if ( ( ! isset( $this->rows ) ) || ( $this->rows < 1 ) ) {
			$this->rows = 1;
		}

		// We can't have the field have fewer rows than the number of
		// set values.
		if ( count( $this->values ) > $this->rows ) {
			$this->rows = count( $this->values );
		}

		$return = "";

		// We'll use a for loop in case they want to redo the number of values.
		for ( $i = 0; $i < $this->rows; $i++ ) {

			$return .= "<tr><td>";
			// The key field
			$return .= "<input name='" . $this->name . "_key_" . ( $i + 1 ) . "' type='text' ";
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
			if ( isset( $this->key_size ) ) {
				$return .= " size='$this->key_size' ";
			}
			if ( isset( $this->key_max_length ) ) {
				$return .= " max_length='$this->key_max_length' ";
			}
			if ( isset( $this->key_placeholder ) ) {
				$return .= " placeholder='$this->key_placeholder' ";
			}
			if ( is_array( $this->values ) && key( $this->values ) ) {
				$return .= " value='" . key( $this->values ) . "' ";
			}
			$return .= "></td> ";

			// Now the value field.
			$return .= "<td><input name='" . $this->name . "_value_" . ( $i + 1 ) . "' type='text' ";
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
			if ( isset( $this->value_size ) ) {
				$return .= " size='$this->value_size' ";
			}
			if ( isset( $this->value_max_length ) ) {
				$return .= " max_length='$this->value_max_length' ";
			}
			if ( isset( $this->value_placeholder ) ) {
				$return .= " placeholder='$this->value_placeholder' ";
			}
			if ( is_array( $this->values ) && current( $this->values ) ) {
				$return .= " value='" . current( $this->values ) . "' ";
			}

			$return .= "></td><td valign='middle'><div class='faf-add-button faf-add-button-$this->name' onclick='add_another();'></div>";
			if ( $i > 0 ) {
				$return .= "<div class='faf-delete-button faf-delete-button-$this->name'></div>";
			}
			$return .= "</td>";
			$return .= "</tr>";

			// Just pop off the first value in the array because we already used it.
			if ( isset( $this->values ) && ( is_array( $this->values ) && ( count( $this->values ) > 0 ) ) ) {
				$values = array_shift( $this->values );
			}
		}

		// This script will allow more values to be added and to be deleted, so we need
		// to dynamically produce some jQuery. How inelegant. These will be some variables
		// to make the javascript variables easier to print.

		$base   = "<td><input name='$this->name";
		$key_end   = "' type='text'";
		if ( isset( $this->classes ) ) {
			$key_end .= " class='" . implode( " ", $this->classes ) . "' ";
		}
		if ( isset( $this->required ) ) {
			if ( $this->required ) {
				$key_end .= " required ";
			}
		}
		if ( isset( $this->disabled ) ) {
			if ( $this->disabled ) {
				$key_end .= " disabled ";
			}
		}
		if ( isset( $this->key_size ) ) {
			$key_end .= " size='$this->key_size' ";
		}
		if ( isset( $this->key_max_length ) ) {
			$key_end .= " max_length='$this->key_max_length' ";
		}
		if ( isset( $this->key_placeholder ) ) {
			$key_end .= " placeholder='$this->key_placeholder' ";
		}
		$key_end .= "></td>";

		$value_end = "' type='text'";
		if ( isset( $this->classes ) ) {
			$value_end .= " class='" . implode( " ", $this->classes ) . "' ";
		}
		if ( isset( $this->required ) ) {
			if ( $this->required ) {
				$value_end .= " required ";
			}
		}
		if ( isset( $this->disabled ) ) {
			if ( $this->disabled ) {
				$value_end .= " disabled ";
			}
		}
		if ( isset( $this->value_size ) ) {
			$value_end .= " size='$this->value_size' ";
		}
		if ( isset( $this->value_max_length ) ) {
			$value_end .= " max_length='$this->value_max_length' ";
		}
		if ( isset( $this->value_placeholder ) ) {
			$value_end .= " placeholder='$this->value_placeholder' ";
		}
		$value_end .= "></td>";

//		ob_start();

		$script = "<script>\r\n";
		$script .= "var " . str_replace('-','_',$this->name) . "_count = " . ($i + 1) . ";\r\n";
		$script .= "jQuery(document).on( 'click', '.faf-add-button-$this->name' , function(e) {\r\n";
		$script .= "var " . str_replace('-','_',$this->name) . " = \"<tr>" . $base . "_key_\" + " . str_replace('-','_',$this->name) . "_count + \"" . $key_end;
		$script .= $base . "\" + " . str_replace('-','_',$this->name) . "_count + \"" . $value_end . "<td valign='middle'><div class='faf-add-button faf-add-button-$this->name'></div> <div class='faf-delete-button faf-delete-button-$this->name'></div></td></tr>\";\r\n";
		$script .= str_replace('-','_',$this->name) . "_count++;\r\n";
		$script .= "jQuery(this).closest('tr').parent().append(" . str_replace('-','_',$this->name) . ");\r\n";
		$script .= "});\r\n";
		$script .= "jQuery(document).on('click', '.faf-delete-button-$this->name' , function(e) {\r\n";
		$script .= "jQuery(this).closest('tr').remove();\r\n";
		$script .= "});\r\n";
		$script .= "</script>\r\n";

?>
	<script>
		// var <?php echo str_replace('-','_',$this->name) ?>_count = <?php echo $i + 1; ?>;
		// jQuery(document).on( 'click', '.faf-add-button-<?php echo $this->name; ?>' , function(e) {
		// 	var <?php echo str_replace('-','_',$this->name) ?> = "<tr><?php echo $base; ?>_key_" + <?php echo str_replace('-','_',$this->name) ?>_count + "<?php echo $key_end . $base; ?>" + <?php echo str_replace('-','_',$this->name) ?>_count + "<?php echo $value_end;?><td valign='middle'><div class='faf-add-button faf-add-button-<?php echo $this->name; ?>'></div> <div class='faf-delete-button faf-delete-button-<?php echo $this->name; ?>'></div></td></tr>";
		// 	<?php echo str_replace('-','_',$this->name) ?>_count++;
		// 	jQuery(this).closest('tr').parent().append(<?php echo str_replace('-','_',$this->name) ?>);
		// });
		// jQuery(document).on('click', '.faf-delete-button-<?php echo $this->name; ?>' , function(e) {
		// 	jQuery(this).closest('tr').remove();
		// });

	</script>
<?php
//	$script = ob_get_flush();
		print_r($script);

		return $return;
	}

	/**
	 * [render description]
	 *
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
		$return .= "<table class='faf-key-value-field-table'>\r\n";
//		$return .= "<tr valign='top'>";
		// if ( isset( $this->wrapper ) ) {
		//  $return .= '<' . $this->wrapper['element'] . ' id="' . $this->wrapper['id'] . '"';
		//  if ( isset( $this->wrapper['class'] ) && is_array( $this->wrapper['class'] ) && ( count( $this->wrapper['class'] > 0 ) ) ) {
		//   $return .= " class='";
		//   foreach ( $this->wrapper['class'] as $class ) {
		//    $return .= "$class ";
		//   }
		//   $return .= "'";
		//  }
		//  $return .= ">\r\n";
		// }
		$return .= $this->render_field() . "\r\n";
		// if ( isset( $this->wrapper ) ) {
		//  $return .= '</' . $this->wrapper['element'] . ">\r\n";
		// }

//		$return .= "</tr>\r\n";
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
