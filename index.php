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
            $description = $description ? $description : __('This is a tiny webpage!','tiny'); // TODO change dummy text
            ?>
            <div class="archive-header">
                <p id="site-description" class="header-text">
                    <?php echo $description; ?>
                </p>
                <h1 class="main-title header-text"><?php bloginfo( 'name' ); ?></h1>
            </div>

        <?php elseif ( is_archive() ):
            echo '<div class="archive-header">';
            tiny_breadcrumbs();
            the_archive_title('<h1 class="main-title">','</h1>');
            echo '</div>';
        
        elseif ( is_search() ): ?>

            <div class="archive-header">
            <?php tiny_breadcrumbs(); ?>
            <h1 class="main-title"><?php _e('Search','tiny');?></h1>
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

                        <?php if ( ! ( is_home() || is_archive() || is_search() || tiny_is_template_blank() )):
                            tiny_breadcrumbs();
                        endif;

                        if (get_post_type() === 'post'): ?>
                        <div class="author-info">
                            
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_date(); ?></a>
                                <?php _e(' by ','tiny');
                                the_author_link();
                            ?>
                        </div>
                        <?php endif;

                        if ( is_singular() ):
                            if ( !tiny_is_template_blank() ): 
                                the_title( '<h1 class="main-title post-title">', '</h1>' );
                            endif;
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
                            <span class="page-links-label"><?php _e('More pages in this post','tiny'); ?></span>
                            <?php wp_link_pages( array(
                                    'before'           => '<ul class="page-links num-'. $numpages  . '"><li class="page-link">',
                                    'after'            => '</li></ul>',
                                    'link_before'      => '<span>',
                                    'link_after'       => '</span>',
                                    'next_or_number'   => 'number',
                                    'separator'        => '</li><li class="page-link">',
                                    'pagelink'         => '%',
                                    'echo'             => 1
                            )); ?>
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

                    <?php if ( is_sticky() && is_home() && ! is_paged() ): // display a sticky sticker if sticky ?>
                        <div class="sticker"><span><?php _e( 'Sticky', 'tiny'); ?></div>
                    <?php endif; ?>

 
                </article>
            <?php }
            
            if ( is_single() ):
                $prev_post_link = get_previous_post_link('<span class="nav-previous">%link</span>');
                $next_post_link = get_next_post_link('<span class="nav-next">%link</span>');

                if ( $prev_post_link || $next_post_link ): ?>
                    <nav class="post-navigation group" role="navigation">
                        <h1 class="screen-reader-text section-heading"><?php _e( 'Post navigation', 'tiny' ); ?></h1>
                        <div>
                            <?php if ( $prev_post_link ): ?>
                            <span class="wrap-previous">
                                <span class="label-previous"><?php _e('Previous','tiny'); ?></span>
                                <?php echo $prev_post_link; ?>
                            </span>
                            <?php endif; ?>
                            
                            <?php if ( $next_post_link ): ?>
                            <span class="wrap-next">
                                <span class="label-next"><?php _e('Next','tiny'); ?></span>
                                <?php echo $next_post_link; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php
                endif;

            endif;
            
            $posts_pagination = str_replace(    'screen-reader-text',
                                                'pagination-label',
                                                get_the_posts_pagination(
                                                    array(
                                                        'mid_size' => 30,
                                                        'screen_reader_text' => __('More posts','tiny')
                                                    ) 
                                                )
                                            );
            if ( $posts_pagination ): ?>
                <div class="posts-navigation">
                    <?php echo $posts_pagination; ?>
                </div>
            <?php endif;

            comments_template();


        } else {
            printf('<h1>%s</h1>', __('No content to display','tiny'));
        }
        ?>

        </main>
    </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>