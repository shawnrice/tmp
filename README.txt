=== Form and Field ===
Contributors: shawn-patrick-rice
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=rice@shawnrice.com
Tags: forms, fields, form generator
Requires at least: 3.5.1
Tested up to: 3.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Both an API and a frontend for building forms with custom handlers. These forms can be inserted anywhere.

== Description ==

Currently, this plugin is available only for WPMU or Buddypress enabled sites. There is a stock set of fields that have been defined, but these can be extended with other plugins. The same goes with the locations.

Out of the box, the plugin supports...

Look in public/fields to see how field types can be created.

Forms are stored in a serialized manner in {wp-prefix}_form_and_field_forms. Using the native storage hook, the data is stored in {wp_prefix}_form_and_field_data.

*	Locations
**	BP Sign-up form
**	WPMU Sign-up form
*	Domains
**	Blog
**	User
**	None 

=== Available hooks: ===
*	faf_list_fields
** 	Called on the Form Builder admin page when generating the "field palette"
*	faf_list_locations
** 	Called on the Form Builder admin page when generating the "Locations" box for the form


To add your own fields:

To add, you'll need to write a class that `extends FAF_Field` or one of the other fields located in the 'fields' directory. 
The most important functions that you will need to include/override are the `__construct` and the `render_field` functions.

1. add_action('form_and_field_register_add_on_locations' , 'MY_CUSTOM_FIELD_FUNCTION');
2.	function MY_CUSTOM_FIELD_FUNCTION() {
		require_once( plugin_dir_path( __FILE__ ) . 'MY_CUSTOM_FIELD_CLASS.php');
	}



This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'form-and-field'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `form-and-field.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `form-and-field.zip`
2. Extract the `form-and-field` directory to your computer
3. Upload the `form-and-field` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

== Updates ==

This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable direct from GitHub. Any submission to WP.org repo will make this redundant.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin


Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`


Includes jQueryValidation MIT license.

