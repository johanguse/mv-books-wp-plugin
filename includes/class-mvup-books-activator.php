<?php

/**
 * Fired during plugin activation
 *
 * @link       https://johanguse.dev
 * @since      1.0.0
 *
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 * @author     Johan Guse <johanguse@gmail.com>
 */
class MVUP_Books_Activator
{

  private $table;
  public function __construct($table_object)
  {
    $this->table = $table_object;
  }

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public function activate() {}
}
