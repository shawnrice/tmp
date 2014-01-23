<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Form and Field
 * @author    Shawn Patrick Rice <rice@shawnrice.org>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Drop the tables.
form_and_field_drop_tables();
// Delete the db_version from the options table
//delete_option('form_and_field_db_version');
//add_action( 'admin_notices', 'form_and_field_uninstall_notice' );

function form_and_field_uninstall_notice() {
    ?>
    <div class="updated">
        <p><?php _e( 'All forms and form data from Form and Field has been removed from the database.', 'my-text-domain' ); ?></p>
    </div>
    <?php
}

/**
 * Drops the FAF tables.
 * @return null
 */
function form_and_field_drop_tables() {
	global $wpdb;

	$form_table = $wpdb->base_prefix . 'form_and_field_meta';
	$data_table = $wpdb->base_prefix . 'form_and_field_data';

	$sql = "DROP TABLE IF EXISTS $data_table, $form_table;";
	$wpdb->query($sql);

	// Well, it was sad to see you go. 
	// J'espère que vous avez une bonne vie.
}
