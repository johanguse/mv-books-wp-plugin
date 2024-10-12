<?php

/**
 * Plugin Name: MV Books
 * Plugin URI: https://johanguse.dev/
 * Description: A plugin to manage books.
 * Version: 1.0.0
 * Author: Johan Guse
 * Author URI: https://johanguse.dev/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mvup-books
 * Domain Path: /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MVUP_BOOKS_VERSION', '1.0.0' );
define( 'MVUP_BOOKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once MVUP_BOOKS_PLUGIN_DIR . 'includes/class-mvup-books.php';

function run_mvup_books() {
	$plugin = new MVUP_Books();
	$plugin->run();
}
run_mvup_books();
