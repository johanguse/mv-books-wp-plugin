<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://johanguse.dev/
 * @since      1.0.0
 *
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    MVUP_Books
 * @subpackage MVUP_Books/includes
 * @author     Johan Guse <johanguse@gmail.com>
 */
class MVUP_Books
{

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      MVUP_Books_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct()
  {
    $this->plugin_name = 'mvup-books';
    $this->version = '1.0.0';
    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - MVUP_Books_Loader. Orchestrates the hooks of the plugin.
   * - MVUP_Books_i18n. Defines internationalization functionality.
   * - MVUP_Books_Admin. Defines all hooks for the admin area.
   * - MVUP_Books_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies()
  {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mvup-books-loader.php';

    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mvup-books-i18n.php';

    /**
     * Load and create Custom Post Types
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mvup-books-cpt.php';

    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-mvup-books-public.php';

    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mvup-books-shortcode.php';

    $this->loader = new MVUP_Books_Loader();
  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the MVUP_Books_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale()
  {
    $plugin_i18n = new MVUP_Books_i18n();
    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since     1.0.0
   * @access    private
   */
  private function define_admin_hooks()
  {

    $plugin_cpt = new MVUP_Books_CPT();

    $this->loader->add_action('init', $plugin_cpt, 'register_books_cpt');
    $this->loader->add_action('init', $plugin_cpt, 'register_genre_taxonomy');
    $this->loader->add_filter('enter_title_here', $plugin_cpt, 'change_default_title');
    $this->loader->add_action('add_meta_boxes', $plugin_cpt, 'add_book_meta_boxes');
    $this->loader->add_action('save_post', $plugin_cpt, 'save_book_details');
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks()
  {

    $plugin_public = new MVUP_Books_Public($this->get_plugin_name(), $this->get_version());
    $plugin_shortcode = new MVUP_Books_Shortcode($this->get_plugin_name(), $this->get_version());

    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');

    // Custom front Page loader
    $this->loader->add_filter('page_template', $plugin_public, 'mvup_books_create_page_template');
    add_shortcode("mvup_books", array($plugin_public, "mvup_books_frontend_page_call"));

    $this->loader->add_action('init', $plugin_shortcode, 'register_shortcode');
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run()
  {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @since     1.0.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name()
  {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.0
   * @return    MVUP_Books_Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader()
  {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.0
   * @return    string    The version number of the plugin.
   */
  public function get_version()
  {
    return $this->version;
  }
}
