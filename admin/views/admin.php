<?php

/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package  Plugin_Name
 * @author   Your Name <email@example.com>
 * @license  GPL-2.0+
 * @link     http://example.com
 * @copyright 2014 Your Name or Company Name
 */


// faf_form_builder_ajax_dialog();
form_and_field_network_manage_menu();
// faf_admin_form_builder_create_page();


wp_enqueue_script( "jquery" );
wp_enqueue_script( "jquery-ui-core" );
wp_enqueue_script( "jquery-ui-dialog" );
wp_enqueue_script( "jquery-ui-draggable" );
wp_enqueue_script( "jquery-ui-droppable" );
wp_enqueue_script( "jquery-ui-sortable" );
wp_enqueue_script( "jquery-ui-accordion" );
wp_enqueue_script( "jquery-effects-core" );
wp_enqueue_script( "jquery-effects-fade" );


function faf_admin_form_builder_create_page() {
	faf_admin_init();
	faf_locations_init();
	// Create the form.
	$id = new FAF_Field_Text( 'form_id' ,  'Form ID' );
	$id->set_required( TRUE );
	$id->set_size( 30 );
	$id->set_max_length( 30 );
	$id->set_placeholder( 'Must be all lowercase with no spaces.' );

	$name = new FAF_Field_Text( 'form_name' ,  'Form Name' );
	$name->set_required( TRUE );
	$name->set_size( 30 );
	$name->set_max_length( 60 );
	$name->set_placeholder( 'Enter a human readable name.' );

	$scope = new FAF_Field_List( 'scope' , 'Scope' );
	$scope->set_required( TRUE );
	$scope->add_option( 'User' );
	$scope->add_option( 'Blog' );
	$scope->add_option( 'None' );
	$scope->add_class( 'form-maker-select' );
	$scope->set_description( 'A scope ties form submissions to a variable. So, if the scope is set to `user`, then it can be filled out only once per user.');

	$classes = new FAF_Field_Text( 'form_classes' , 'CSS Classes' );
	$classes->set_required( FALSE );
	$classes->set_size( 60 );
	$classes->set_placeholder( 'Separate class names with spaces.' );

	$instructions = new FAF_Field_Textarea( 'form_instructions' , 'Instructions' );
	$instructions->set_required( TRUE );
	$instructions->set_rows( 5 );
	$instructions->set_cols( 60 );
	$instructions->set_placeholder( 'Place any instructions for the form here.' );

	$method = new FAF_Field_List( 'form_handler' , 'Handler' );
	$method->set_required( TRUE );
	$method->add_option( 'Placeholder' );
	$method->set_default( 'placeholder' );
	$method->add_class( 'form-maker-select' );
	$method->set_disabled( TRUE );
	
?>

	<div class="wrap">
		<h2><?php echo esc_html( get_admin_page_title() . ': form builder '); ?></h2>
		<div id="form-maker">
		<form id="form">
			<table>
			<?php $id->render(); ?>
			<?php $name->render(); ?>
			<?php $scope->render(); ?>
			<?php do_action( 'faf_list_locations' ); ?>
			<?php $method->render(); ?>
			<?php $classes->render(); ?>
			<?php $instructions->render(); ?>
			</table>
			<div class="label">
				<h2>Canvas</h2>
			</div>
			<div id="canvas">
				<ul id="canvas-drop">
				</ul>
			</div>
			<div id="palette">
				<?php do_action( 'faf_list_fields' ); ?>
			</div>
			</form>
			<div id="dialog" class="" title="Form Element"></div>
		</div>
		<div id="zoneclear"></div>
		<br style="clear:both; float:none; display:block; height:1px;" />
	</div>

	<script>

		jQuery( document ).ready( function( $ )  {
			$( '#form' ).on( 'submit' ,  function( event )  {
				event.preventDefault();
				console.log( $( this ).serialize() );
			});

		});

	</script>


<?php
}
/**
 * The following functions need to be moved into another files to keep the MVC layout.
 *
 */


function form_and_field_queue_inline_js() {
	// Insert dynamic footer JS here.
?>
  <script>

	function makeid() {
	    var text = "";
	    var possible = "abcdefghijklmnopqrstuvwxyz";

	    for( var i=0; i < 13; i++ )
	        text += possible.charAt(Math.floor(Math.random() * possible.length));

	    return text;
	}

	jQuery( document ).ready( function( $ )  {
		// http://jsfiddle.net/sxGtM/3/
		// http://stackoverflow.com/questions/1184624/convert-form-data-to-js-object-with-jquery
		$.fn.serializeObject = function()
		{
		    var o = {};
		    var a = this.serializeArray();
		    $.each(a, function() {
		        if (o[this.name] !== undefined) {
		            if (!o[this.name].push) {
		                o[this.name] = [o[this.name]];
		            }
		            o[this.name].push(this.value || '');
		        } else {
		            o[this.name] = this.value || '';
		        }
		    });
		    return o;
		};

		$( "#dialog" ).dialog( {
		    autoOpen: false ,
		    modal: true ,
		    minHeight: 600 ,
		    minWidth: 400 ,
		    height: 600,
		    width: '60%' ,
		    title: 'Field Configuration' ,
		    show: 'fade' ,
		    hide: 'fade' ,
		    closeOnEscape: false,
		    position: [ 'top', 60 ] ,
		    buttons : {
	            "Add Field": function()  {
    	            fid = $('#identifier').val();
    	            field_data = JSON.stringify($('#faf_configure_field_form').serializeObject());
    	            name = $( '#name' ).val();
    	            document.getElementById( fid ).innerHTML = '<span class="faf-name-li">' + name + '</span> <span class="faf-type-li">'
    	            	+ $( '#faf-type' ).val() + '</span><input type="hidden" name="' + fid + '" value="' + field_data + '" />';
    	            $( this ).dialog( 'close' );

        	    },
        	    "Remove Field": function()  {
        	    	// Confirm the removal before acting on it.
        	    	if (confirm('Are you sure that you want to remove the field?') == true ) {
	        	    	// Remove the field from the form.
	    	            $( '#' + $( '#identifier' ).val() ).parent().remove();
	    	            $( this ).dialog( 'close' );
					}
        	    }
        	},
		    open: function()  {
		    	// I really have no idea why, oh why I needed to do this, but, apparently, this works.
		    	// I need to find a less hackish way to go with this.
//				setTimeout(function() {
					$( '#spy' ).bind( "enterKey", function( e ) {
					  var lines = $( this ).val().split( '\n' );
					  var len = lines.length;
					  var dom = "<select class='default' name='default'><option value=''>---</option>";
						$.each( lines, function( index, element ){

							if ( this != "" )
							{
								dom = dom + "<option value=\'" + this + "\'>" + this + "</option>";
							}
					  });
					  dom = dom + "</select>";
					  $( '#written' ).html( dom );
					});
					$( '#spy' ).keyup( function( e ){
					    if ( e.keyCode == 13 ) {
					        $( this ).trigger( 'enterKey' );
					    }
					    if ( e.keyCode == 8 ) {
					        $( this ).trigger( 'enterKey' );
					    }
					    if ( e.keyCode == 46 ) {
					        $( this ).trigger( 'enterKey' );
					    }
					});
					$( '#spy' ).change( function() {
					    $( this ).trigger( 'enterKey' );
					});
					// Set the focus to the first text box
					$( '#name' ).focus();
					// Put in a hidden field with the identifier.
					$( '<input type="hidden" name="identifier" id="identifier" value=' +
						field_id + ' />' ).insertBefore( 'input#name' );

			//	}, 1000 );
		    }
		});

        $( '.draggable' ).draggable( {
        	helper: 'clone' ,
        	cursor: 'move' ,
        	zIndex: 200 ,
        	opacity: .75 ,
        	containment: 'window' ,
        	connectToSortable: '#canvas-drop',
        	addClasses: false,
        	start: function () {
            	origin = 'draggable';
        	}
    	});

		var origin = 'sortable';

    	$( '#canvas-drop' ).droppable( {
			activeClass: "ui-state-default" ,
			hoverClass: "ui-state-hover" ,
			accept: "#palette > ul > li" ,
			drop: function ( event, ui ) {
				// Null. For now.
         	}
		}).sortable( {
			items: "li:not( .placeholder ) " ,
			cursor: "move" ,
			forcePlaceholderSize: true ,
			placeholder: 'placeholder',
			beforeStop: function( event, ui ) {
				if ( origin == 'draggable' ) {
					$( ui.item[0] ).addClass( 'canvas-element' );
					origin = 'sortable';
					field_id = makeid();
					ui.item[0].innerHTML = '<span id="' + field_id + '"></span>';
					$( ui.item[0] ).append( '<input type="button" class="edit-field-button" value="Edit" />' );
				}
			},
			receive: function( event ,  ui )  {
				var id = ui.item.attr( 'id' );
				var url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
				var data = {
					// our current ajax handler
					action: 'dd_ajax' ,
					id: id ,
				};
				$.post( url , data , function( data )  {
					document.getElementById( 'dialog' ).innerHTML = data;
									$( '#dialog' ).dialog( 'open' );

				});
			},

			sort: function( event ,  ui )  {
				$( this ).removeClass( 'ui-state-default' );
			}
		});
	});

</script>
<?php
}

function faf_admin_init() {
	add_action( 'faf_list_fields' ,  'faf_list_fields_start' ,  1 );
	add_action( 'faf_list_fields' ,  'faf_list_fields_end' ,  999 );
	add_action( 'faf_list_fields' ,  'faf_add_defaults' ,  10 );
}



function faf_list_fields_start() {
	echo "<ul>";
}
function faf_list_fields_end() {
	echo "</ul>";
}

function faf_add_defaults() {
	$defaults = array(  'text' ,
		'textarea' ,
		'list' ,
		'radio' ,
		'checkbox' ,
		'number' ,
		'password',
		'hidden',
	);
	foreach ( $defaults as $field ) {
		faf_add_field( $field );
	}
}

function faf_add_field( $field ) {
	echo "<li id='field-element-$field' class='draggable element'><div>" . ucfirst( $field )  . "</div></li>";
}

function faf_locations_init() {
	add_action( 'faf_list_locations' , 'faf_locations_start' , 1 );
	add_action( 'faf_list_locations' , 'faf_locations_end' , 99 );

	// Add the BP signup form location only if BP is active.
	if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
		add_action( 'faf_list_locations' , 'faf_location_bp_signup' );
	}
}

/**
 * Action to start the beginning of the location select box on the form maker.
 *
 * @return [type] [description]
 */
function faf_locations_start() {
?>
	<tr valign='top' class='form-field form-required' required>
		<th scope='row'><label for='form_locations'>Form Location: </label></th>
		<td>
			<select name='form_locations' class='form-maker-select form-field'>
	<?php
}

/**
 * Action to close the location select box on the form maker.
 *
 * @return [type] [description]
 */
function faf_locations_end() {
?>
			</select>
		</td>
	</tr>
	<?php
}

/**
 * Function to add location to allow the alteration of the bp blog signup form.
 *
 * @return [type] [description]
 */
function faf_location_bp_signup() {
?>
		<option value='action-signup_blogform'>BP signup blog form</option>
	<?php
}



function form_and_field_network_manage_menu() {
	$tab = $_GET['tab'];
	form_and_field_network_admin_tabs( $tab );

}

function form_and_field_network_admin_tabs( $current = 'general' ) {
	// $dir=plugins_url( 'images/data_32.png' , __FILE__ );

	$plugin_slug = "form-and-field";

	$tabs = array(  'general' => 'General' ,
		'form-builder' => 'Form Builder' ,
		'locations' => 'Locations',
		'settings' => 'Settings',
	);
	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="">';
	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab == $current )  ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=$plugin_slug&tab=$tab'>$name</a>";
	}
	echo '</h2>';

	switch ( $current ) {
	case 'general':
		faf_admin_general();
		break;
	case 'form-builder':
		faf_admin_form_builder_create_page();
		break;
	case 'settings':
		faf_admin_settings();
		break;
	default:
		faf_admin_general();
		break;
	}
}


function faf_admin_general() {
	echo "This is the general page";
}

function faf_admin_settings() {

	$settings = new FAF_Form( 'faf_settings' );

	$settings->add_region( 'Assets' );
	$settings->set_region_description( 'Assets' , 'Please specify where you would like to load the external assets from.' );
	$jvalidate = new FAF_Field_List( 'jvalidate' , 'jQuery Validate' );
	$jvalidate->add_option( 'local' , 'Locally Hosted' );
	$jvalidate->add_option( 'cdnjs' , 'CDNjs' );
	$jvalidate->add_option( 'microsoft' , 'Microsoft' );
	$jvalidate->set_description( 'Choose where to load jQuery Validate from.' );
	$jvalidate->set_default( 'Locally Hosted' );

	$settings->add_field( 'Assets', $jvalidate );
	$settings->print_form();


}
