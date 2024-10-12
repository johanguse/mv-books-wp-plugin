<?php

class MVUP_Books_CPT
{
  /**
   * Change Title Placeholder Books Page
   */
  public function change_default_title($title)
  {
    $screen = get_current_screen();
    if ($screen->post_type == 'book') {
      return __("Enter book title", "mvup-books");
    }
    return $title;
  }

  /**
   * Register Book Custom Post Type
   */
  public function register_books_cpt()
  {
    $labels = array(
      "name" => __("Books", "mvup-books"),
      "singular_name" => __("Book", "mvup-books"),
      "menu_name" => __("Books", "mvup-books"),
      "all_items" => __("All Books", "mvup-books"),
      "add_new" => __("Add New", "mvup-books"),
      "add_new_item" => __("Add New Book", "mvup-books"),
      "edit_item" => __("Edit Book", "mvup-books"),
      "new_item" => __("New Book", "mvup-books"),
      "view_item" => __("View Book", "mvup-books"),
      "view_items" => __("View Books", "mvup-books"),
      "search_items" => __("Search Books", "mvup-books"),
      "not_found" => __("No books found", "mvup-books"),
      "not_found_in_trash" => __("No books found in trash", "mvup-books"),
      "featured_image" => __("Book Cover Image", "mvup-books"),
      "set_featured_image" => __("Set book cover image", "mvup-books"),
      "remove_featured_image" => __("Remove book cover image", "mvup-books"),
    );

    $args = array(
      "label" => __("Books", "mvup-books"),
      "labels" => $labels,
      "description" => __("Custom post type for books", "mvup-books"),
      "public" => true,
      "publicly_queryable" => true,
      "show_ui" => true,
      "show_in_rest" => true,
      "rest_base" => "",
      "show_in_menu" => true,
      "menu_position" => 5,
      "menu_icon" => "dashicons-book-alt",
      "supports" => array("title"),
      "taxonomies" => array("genre"),
      "hierarchical" => false,
      "rewrite" => array("slug" => "book", "with_front" => false),
      "query_var" => true,
      "can_export" => true,
    );

    register_post_type("book", $args);
  }

  /**
   * Register Genre Taxonomy
   */
  public function register_genre_taxonomy()
  {
    $labels = array(
      "name" => __("Genres", "mvup-books"),
      "singular_name" => __("Genre", "mvup-books"),
      "menu_name" => __("Genres", "mvup-books"),
      "all_items" => __("All Genres", "mvup-books"),
      "edit_item" => __("Edit Genre", "mvup-books"),
      "view_item" => __("View Genre", "mvup-books"),
      "update_item" => __("Update Genre", "mvup-books"),
      "add_new_item" => __("Add New Genre", "mvup-books"),
      "new_item_name" => __("New Genre Name", "mvup-books"),
      "search_items" => __("Search Genres", "mvup-books"),
    );

    $args = array(
      "labels" => $labels,
      "public" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_admin_column" => true,
      "show_in_nav_menus" => true,
      "show_tagcloud" => true,
      "show_in_rest" => true,
    );

    register_taxonomy("genre", array("book"), $args);
  }

  /**
   * Add custom meta boxes for Book post type
   */
  public function add_book_meta_boxes()
  {
    add_meta_box(
      'book_details',
      __('Book Details', 'mvup-books'),
      array($this, 'render_book_details_meta_box'),
      'book',
      'normal',
      'default'
    );
  }

  /**
   * Render Book Details meta box
   */
  public function render_book_details_meta_box($post)
  {
    wp_nonce_field('book_details_nonce', 'book_details_nonce');
    $author = get_post_meta($post->ID, '_book_author', true);
    $publication_date = get_post_meta($post->ID, '_book_publication_date', true);
    $isbn = get_post_meta($post->ID, '_book_isbn', true);

    echo '<p><label for="book_author">' . __('Author:', 'mvup-books') . '</label>';
    echo '<input type="text" id="book_author" name="book_author" value="' . esc_attr($author) . '" size="25" /></p>';

    echo '<p><label for="book_publication_date">' . __('Publication Date:', 'mvup-books') . '</label>';
    echo '<input type="date" id="book_publication_date" name="book_publication_date" value="' . esc_attr($publication_date) . '" /></p>';

    echo '<p><label for="book_isbn">' . __('ISBN:', 'mvup-books') . '</label>';
    echo '<input type="text" id="book_isbn" name="book_isbn" value="' . esc_attr($isbn) . '" size="25" /></p>';
  }

  /**
   * Save Book Details meta box data
   */
  public function save_book_details($post_id)
  {
    if (!isset($_POST['book_details_nonce']) || !wp_verify_nonce($_POST['book_details_nonce'], 'book_details_nonce')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    $fields = array('book_author', 'book_publication_date', 'book_isbn');

    foreach ($fields as $field) {
      if (isset($_POST[$field])) {
        update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
      }
    }
  }
}
