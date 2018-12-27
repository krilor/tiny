<?php
/**
 * The main template file
 *
 * @package Tiny
 */
?>

<?php get_header(); ?>

    <section id="content" class="content-container silo">
        <main id="main">

        <?php
        if ( have_posts() ) {

            while ( have_posts() ) { 
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">

                        <?php if ( ! ( is_home() || is_archive() )):
                            tiny_breadcrumbs();
                        endif; ?>

                        <?php if ( is_singular() ):
                            the_title( '<h1>', '</h1>' );
                        else:
                            the_title( '<h2><a href="' . esc_url(get_permalink()) . '">', '</a></h2>' );
                        endif; ?>

                        <?php 
                        if ( has_post_thumbnail() ) :
                            if ( is_singular() ) : ?>

                            <figure class="post-thumbnail alignwide">
                                <?php the_post_thumbnail(); ?>
                            </figure><!-- .post-thumbnail -->

                        <?php else : ?>

                            <figure class="post-thumbnail alignwide">
                                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </figure>

                        <?php endif;
                        endif; // has post thumbnail?>

                    </header>
                    
                    <div class="entry-content group">
                        <?php the_content(); ?>
                    </div>
                    
                    <footer>
                        <?php edit_post_link(__('Edit','tiny')); ?>
                        <?php echo get_the_category_list(); ?>
                        <?php echo get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>'); ?>
                        <?php echo get_the_author(); ?>
                        <?php the_date(); echo ' - '; the_time(); ?>
                        
                        
                        <?php if ( get_the_modified_time() != get_the_time() ): // is modified ?>
                            <?php the_modified_date(); the_modified_time(); ?>
                        <?php endif; ?>
                    </footer>
                </article>
            <? }

            // TODO edit button
            // TODO twentynineteen_the_posts_navigation();
            // TODO comments

        } else {
            printf('<h1>%s</h1>',__('No content to display','tiny'));
        }
        ?>

        </main>
    </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>