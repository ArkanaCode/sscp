<?php
/* Template Name: E-Škola */

get_header(); 

// Get all categories for the 'lekcije' post type
$categories = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => true, // only show categories that have posts
) );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
    foreach ( $categories as $category ) :
        // Get all lekcije posts under this category
        $lekcije_query = new WP_Query( array(
            'post_type' => 'lekcije',
            'posts_per_page' => -1,  // Get all posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'id',
                    'terms'    => $category->term_id,
                    'operator' => 'IN',
                ),
            ),
        ) );
        ?>

        <div class="category-toggle">
            <button class="category-btn"><?php echo esc_html( $category->name ); ?></button>
            <div class="category-content" style="display: none;">
                <?php
                // Check if there are any posts in this category
                if ( $lekcije_query->have_posts() ) :
                    while ( $lekcije_query->have_posts() ) : $lekcije_query->the_post();
                        ?>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <br>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No Lekcije found in this category.</p>';
                endif;
                ?>
            </div>
        </div>

        <?php
    endforeach;
else :
    echo '<p>No categories found.</p>';
endif;

get_footer();
?>
