<?php
/**
 * Plugin Name.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-form-and-field-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Plugin_Name
 * @author  Your Name <email@example.com>
 */
class Form_And_Field {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'form-and-field';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );

		// Run the database update check.
		add_action( 'plugins_loaded', array( $this, 'form_and_field_db_check') );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		self::form_and_field_install_tables();

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// Does not delete the data tables. Only uninstalling will do that.


		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// @TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

	/**
	 * Creates the init, form, and meta tables.
	 * @return null
	 */
	public function form_and_field_install_tables() {
		global $wpdb;
		$faf_db_version = '1.01';


		$location_table = $wpdb->base_prefix . 'form_and_field_init';

		// Check to make sure the location table exists. If not, make it.
	    if( $wpdb->get_var( 'SHOW TABLES LIKE ' . $location_table ) != $location_table ) {

	    	/**
	    	 *
	    	 * I've named this table "init" even though it's the location table.
	    	 * This is just a 'key/value' sort of table that will be queried on
	    	 * every page load in order to queue the correct actions to load all
	    	 * of the forms. If there is a better way to do this, then I'd like
	    	 * to know. Currently, it's fairly unsatisfying.
	    	 * 
	    	 */
	    	
			$sql = "CREATE TABLE $location_table (
			  			location varchar(60) NOT NULL, 
			  			formid varchar(15) NOT NULL,
			  			KEY (location)
		  			);
		  		";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		}

		$form_table = $wpdb->base_prefix . 'form_and_field_meta';

		// Check to make sure the form table exists. If not, make it.
	    if( $wpdb->get_var( 'SHOW TABLES LIKE ' . $form_table ) != $form_table ) {

	    	/**
	    	 *
	    	 *	FormId is obviously the unique name.
	    	 *	The blogid is what the form is tied to, i.e. who created it.
	    	 *	The form is a serialized representation of the form.
	    	 * 
	    	 */

			$sql = "CREATE TABLE $form_table (
			  			formid varchar(15) NOT NULL,
			  			blogid int NOT NULL,
			  			form text NOT NULL,
			  			PRIMARY KEY (formid),
			  			KEY (location)
		  			);
		  		";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		}

		$data_table = $wpdb->base_prefix . 'form_and_field_data';

		// Check to make sure the data table exists. If not, make it.
	    if( $wpdb->get_var( 'SHOW TABLES LIKE ' . $data_table ) != $data_table ) {

	    	/**
	    	 *
	    	 * We'll have only one data table. But, we want this to accommodate multisite
	    	 * as well as single.
	    	 *
	    	 * Hence, the 'id' just makes sure things are separate.
	    	 *
	    	 * The blogid / userid should be used only if the data is bound to either a
	    	 * blog / user, respectively.
	    	 *
	    	 * The name field is the name of the field. These can be multiple for multiple
	    	 * answers. The data is just the value. And the formid is, obviously, the form
	    	 * that also serves as the "decoder" ring for what the values actually are.
	    	 *
	    	 * I might reconsider the indexes.
	    	 * 
	    	 */


			$sql = "CREATE TABLE $data_table (
						id int NOT NULL AUTO_INCREMENT,
						blogid int ,
						userid varchar(50) ,
						formid varchar(15) NOT NULL,
						name varchar(30) NOT NULL,
						data text NOT NULL,
						PRIMARY KEY (id),
						KEY (formid),
						KEY (blogid)
					);
				";

			/**
			 * I wish I could add the below lines:
			 * ---
			 * FOREIGN KEY (formid)
			 *	REFERENCES $form_table(formid)
			 *	ON UPDATE CASCADE ON DELETE RESTRICT
			 **/

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		}

		// Register the database version.
		if (get_site_option( 'form_and_field_db_version' )) {
			update_option('form_and_field_db_version', $faf_db_version);	
		} else {
	    	add_option('form_and_field_db_version', $faf_db_version);
		}
	}


	/**
	 * Checks to make sure that the database tables are installed
	 * @return null
	 */
	public function form_and_field_db_check() {
	    global $faf_db_version;
	    if ( get_site_option( 'form_and_field_db_version' ) != $faf_db_version ) {
	        self::form_and_field_install_tables();
	    }
	}

	

}
