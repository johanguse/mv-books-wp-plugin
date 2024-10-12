<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://johanguse.dev
 * @since      1.0.0
 *
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 * @author     Johan Guse <johanguse@gmail.com>
 */
class MVUP_Books_i18n
{


  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.0.0
   */
  public function load_plugin_textdomain()
  {
    load_plugin_textdomain(
      'mvup-books',
      false,
      dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
    );
  }
}
