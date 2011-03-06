<?php
/*
Plugin Name: Simple Fields Prettify
Plugin URI: http://github.com
Description: Changes edit view of the fantastic Simple Fields plugin, removes dependency on jQuery UI CDN and bypasses an issue with the Custom Field Template plugin
Version: 0.1
Author: Thomas Jaggi
Author URI: http://backflip.info
License: GLP2
*/

/*  Copyright 2011  Simple Fields Prettify  (thomas@backflip.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// is_plugin_active does not work for some reason

function my_is_plugin_active($plugin) {
    return in_array($plugin, (array) get_option( 'active_plugins', array()));
}

if (!my_is_plugin_active('simple-fields/simple_fields.php')) return;


// Add script and styles

function my_plugin_admin_init() {
	wp_register_script('simple-fields-prettify', plugins_url('/_script.js', __FILE__), '', false, true);
	wp_enqueue_script('simple-fields-prettify');
	
	wp_register_style('simple-fields-prettify', plugins_url('/_styles.css', __FILE__));
	wp_enqueue_style('simple-fields-prettify');
	
	// Overwrite links to the jQuery UI CDN in order to work offline
	wp_enqueue_script("jquery-ui-effects-core", plugins_url('/jquery-ui/effects.core.js', __FILE__));
	wp_enqueue_script("jquery-ui-effects-highlight", plugins_url('/jquery-ui/effects.highlight.js', __FILE__));
}

add_action( 'admin_init', 'my_plugin_admin_init' );


// media_send_to_editor hooks don't play well with eachother --> change priorities

if (my_is_plugin_active('custom-field-template/custom-field-template.php')) {
	add_filter('media_send_to_editor', 'media_send_to_custom_field', 14);
	add_filter('media_send_to_editor', 'simple_fields_media_send_to_editor', 14, 2);
}

?>
