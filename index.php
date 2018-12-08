<?php
/**
 * The main template file
 *
 * @package Tiny
 */
?>

<?php get_header(); ?>

    <section id="content" class="content-container">
        <main id="main">

        <?php
        if ( have_posts() ) {

            while ( have_posts() ) { 
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">

                        <?php 
                        if ( has_post_thumbnail() ) :
                            if ( is_singular() ) : ?>

                            <figure class="post-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </figure><!-- .post-thumbnail -->

                        <?php else : ?>

                            <figure class="post-thumbnail">
                                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </figure>

                        <?php endif;
                        endif; // has post thumbnail?>

                        <?php the_title( '<h1>', '</h1>' ); ?>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    
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

<?php get_footer(); ?>