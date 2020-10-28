<?php
/**
 * @package freichat
 */
/*
Plugin Name: FreiChat
Plugin URI: https://freichat.com/
Description: A scalable chat solution - The best way to engage your users
Version: 1.0.3
Author: Codologic
Author URI: https://codologic.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2019 Codologic.
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'FREICHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


if ( is_admin() ) {

	require_once( FREICHAT__PLUGIN_DIR . 'class.freichat-admin.php' );
	require_once FREICHAT__PLUGIN_DIR . 'helper.php';
	add_action( 'init', array( 'FreiChat_Admin', 'init' ) );
	register_activation_hook( __FILE__, array( 'FreiChat_Admin', 'plugin_activation' ) );
} else {
	require_once( FREICHAT__PLUGIN_DIR . 'class.freichat.php' );
	add_action( 'wp_footer', array( 'FreiChat', 'init' ) );
}

