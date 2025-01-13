<?php get_header(); ?>

<main id="main-content">
    <header class="archive-header">
        <h1><?php post_type_archive_title(); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="lesson-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="lesson-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php echo paginate_links(); ?>
        </div>

    <?php else : ?>
        <p><?php _e( 'No lessons found.', 'your-theme-textdomain' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
