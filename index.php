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

        <?php if ( is_home() ):
                    $description = get_bloginfo( 'description' );
                    $description = $description ? $description : __('Site titles are for weak people','tiny'); // TODO change dummy text
                ?>
                    <div class="archive-header">
                        <p id="site-description" class="header-text">
                            <?php echo $description; ?>
                        </p>
                        <h1 class="site-title header-text"><?php bloginfo( 'name' ); ?></h1>
                    </div>

                <?php elseif ( is_archive() ):
                    echo '<div class="archive-header">';
                    tiny_breadcrumbs();
                    the_archive_title('<h1 class="site-title">','</h1>');
                    echo '</div>';
                
                elseif ( is_search() ): ?>

                    <div class="archive-header">
                    <?php tiny_breadcrumbs(); ?>
                    <h1 class="site-title"><?php _e('Search','tiny');?></h1>
                    </div>
                    <div>
                    <?php get_search_form( true ); ?>
                    </div>

                <?php endif; // is_home ?>

        <?php
        if ( have_posts() ) {

            while ( have_posts() ) { 
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">

                        <?php if ( ! ( is_home() || is_archive() || is_search() )):
                            tiny_breadcrumbs();
                        endif;

                        if (get_post_type() === 'post'): ?>
                        <div class="author-info">
                            <?php 
                                the_date();
                                _e(' by ','tiny');
                                echo get_the_author();
                            ?>
                        </div>
                        <?php endif;

                        if ( is_singular() ):
                            the_title( '<h1 class="site-title post-title">', '</h1>' );
                        else:
                            the_title( '<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>' );
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
                        <?php edit_post_link(__('Edit','tiny')); ?>
                    </div>

                    <?php if ( is_single() && tiny_is_paginated_post() ): // Do pagination withing same page for the <!--nextpage--> quicktag) ?>
                        <div class="paginated-post-links">
                            <?php wp_link_pages(); ?>
                        </div>
                    <?php endif; ?>

                    <?php

                    $category_list = preg_replace('/(\>)\s*(\<)/m', '$1$2', get_the_category_list() ); // replace whitespace to ensure render alignment in Chrome
                    $tag_list = get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>');

                    if ( $tag_list || $category_list ): ?>

                    <footer class="post-meta">
                        <?php if ( $category_list ): ?>
                        <div>
                            <span class="screen-reader-text"><?php _e('Categories', 'tiny'); ?></span>
                            <?php echo $category_list; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ( $tag_list ): ?>

                        <div>
                            <span class="screen-reader-text"><?php _e('Tags', 'tiny'); ?></span>
                            <?php echo  $tag_list; ?>
                        </div>

                        <?php endif; ?>

                    </footer>

                    <?php endif; ?>

                    <?php if ( is_sticky() ): // display a sticky sticker if sticky ?>
                        <div class="sticker"><span><?php _e( 'Sticky', 'tiny'); ?></div>
                    <?php endif; ?>

 
                </article>
            <?php }
            
            if ( is_single() ):
                $prev_post_link = get_previous_post_link('<span class="nav-previous">%link</span>');
                $next_post_link = get_next_post_link('<span class="nav-next">%link</span>');

                if ( $prev_post_link || $next_post_link ): ?>
                    <nav class="post-navigation" role="navigation">
                        <h1 class="screen-reader-text section-heading"><?php _e( 'Post navigation', 'tiny' ); ?></h1>
                        <div>
                            <?php echo $prev_post_link; ?>
                            <?php echo $next_post_link; ?>
                        </div>
                    <nav>
                <?php
                endif;

            endif;
            
            the_posts_pagination();

            comments_template();


        } else {
            printf('<h1>%s</h1>', __('No content to display','tiny'));
        }
        ?>

        </main>
    </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>