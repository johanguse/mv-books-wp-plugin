<?php

class MVUP_Books_Shortcode
{
  private $version;

  /**
   * Constructor
   */
  public function __construct($version)
  {
    $this->version = $version;
  }

  /**
   * Register the shortcode
   */
  public function register_shortcode()
  {
    add_shortcode('recent_books', array($this, 'recent_books_shortcode'));
  }

  /**
   * Shortcode callback function
   */
  public function recent_books_shortcode($atts)
  {
    $args = array(
      'post_type' => 'book',
      'posts_per_page' => 5,
      'orderby' => 'meta_value',
      'meta_key' => '_book_publication_date',
      'order' => 'DESC',
    );

    $recent_books = new WP_Query($args);

    ob_start();

    if ($recent_books->have_posts()) {
      echo '<ul class="recent-books">';
      while ($recent_books->have_posts()) {
        $recent_books->the_post();
        $author = get_post_meta(get_the_ID(), '_book_author', true);
        $publication_date = get_post_meta(get_the_ID(), '_book_publication_date', true);

        echo '<li class="book-item">';
        echo '<h3 class="book-title">' . get_the_title() . '</h3>';
        echo '<p class="book-author"><strong>' . __('Author:', 'mvup-books') . '</strong> ' . esc_html($author) . '</p>';
        echo '<p class="book-publication-date"><strong>' . __('Publication Date:', 'mvup-books') . '</strong> ' . esc_html($publication_date) . '</p>';
        echo '</li>';
      }
      echo '</ul>';
    } else {
      echo '<p>' . __('No recent books found.', 'mvup-books') . '</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
  }
}
