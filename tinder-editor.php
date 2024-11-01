<?php

/*
    Copyright (C) 2015 WildFireWeb, Inc

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

	Please note that this license contains additional terms according to 
	section 7 of GPL Version 3. Before making any modifications or redistributing 
	this code please review the license additional terms.

    You should have received a copy of the GNU General Public License and the Additional Terms
    along with this program.  If not, see http://wildfireweb.com//tinder-gpl3-license.html

	This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/


define('TINDER_VERSION','1.0.2');

/**
 * @link              http://wildfireweb.com
 * @package           Tinder_Editor
 *
 * @wordpress-plugin
 * Plugin Name:       Tinder® Editor
 * Plugin URI:        http://wildfireweb.com/tinder-for-wordpress.html
 * Description:       Edit pages and posts directly with Tinder®
 * Version:           1.0.2
 * Author:            WildFireWeb Inc.
 * Author URI:        http://wildfireweb.com/
 * License:           GPL-3.0+
 * License URI:       http://wildfireweb.com/tinder-gpl3-license.html
 * Text Domain:       tinder-editor
 * Domain Path:       /
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_tinder_editor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tinder-editor-activator.php';
	Tinder_Editor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_tinder_editor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tinder-editor-deactivator.php';
	Tinder_Editor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tinder_editor' );
register_deactivation_hook( __FILE__, 'deactivate_tinder_editor' );

/**
 * The core plugin class
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tinder-editor.php';

/**
 * Begins execution of the plugin.
 */
function run_tinder_editor() {

	$plugin = new Tinder_Editor();
	$plugin->run();

}
run_tinder_editor();
