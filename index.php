<?php
/**
 * The main template file
 *
 * @package Tiny
 */
?>

<?php get_header(); ?>

    <main id="content" class="content-container silo">
        <section id="main">

            <?php
            // Main header displays title on archive-like pages
            if ( is_home() ){
                $main_meta = get_bloginfo( 'description' );
                $main_meta = $main_meta ? $main_meta : __('This is a tiny webpage!','tiny');
                $main_title = get_bloginfo( 'name' );
            } elseif ( is_archive() ) {
                $main_meta = tiny_breadcrumbs();
                $main_title = get_the_archive_title();
            } elseif ( is_search() ) {
                $main_meta = tiny_breadcrumbs();
                $search_query = get_search_query();
                $main_title = $search_query ? __( 'Search results for: ','tiny' ) . '<i>' . $search_query . '</i>' : __('Search','tiny');
            }
            
            
            if ( isset( $main_title ) && isset( $main_meta ) ) : ?>
            
                <header class="main-header">
                    <div class="main-meta">
                        <?php echo $main_meta; ?>
                    </div>
                    <h1 class="main-title"><?php echo $main_title ?></h1>
                </header>

            <?php endif;

            // Display search form on search page
            if ( is_search() ): ?>
                <div class="main-search-form">
                    <?php get_search_form( true ); ?>
                </div>
            <?php endif; ?>

        <?php
        if ( have_posts() ) {

            while ( have_posts() ) { 
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">

                        <?php if ( ! ( is_home() || is_archive() || is_search() || tiny_is_template('blank') )):
                            echo tiny_breadcrumbs();
                        endif;

                        if (get_post_type() === 'post'): ?>
                        <div class="author-info inverse-link">
                            
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_date(); ?></a>
                                <?php _e(' by ','tiny');
                                the_author_link();
                            ?>
                        </div>
                        <?php endif;

                        if ( is_singular() ):
                            if ( !tiny_is_template('blank') ): 
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
                        <?php
                        if ( is_archive() || is_search() ){
                            the_excerpt();
                        } else {
                            the_content( __('Read more about it..','tiny') );
                        }
                        edit_post_link(__('Edit','tiny'));
                        ?>
                    </div>


                    <?php 
                    // Pagination of a single paginated post (  <!--nextpage--> )
                    if ( is_single() && tiny_is_paginated_post() ): ?>
                        <nav class="paginated-post-navigation">
                            <span class="page-links-label tiny-label"><?php _e('More pages in this post','tiny'); ?></span>
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
                        </nav>
                    <?php endif; ?>


                    <?php
                    $category_list = preg_replace('/(\>)\s*(\<)/m', '$1$2', get_the_category_list() ); // replace whitespace to ensure render alignment in Chrome
                    $tag_list = get_the_tag_list('<ul class="post-tags"><li>','</li><li>','</li></ul>');

                    if ( $tag_list || $category_list ): ?>

                    <footer class="post-meta inverse-link">
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

            // Pagination between single posts
            if ( is_single() ):
                $prev_post_link = get_previous_post_link('<span class="prev">%link</span>');
                $next_post_link = get_next_post_link('<span class="next">%link</span>');

                if ( $prev_post_link || $next_post_link ): ?>
                    <nav class="post-navigation group" role="navigation">
                        <h1 class="screen-reader-text section-heading"><?php _e( 'Post navigation', 'tiny' ); ?></h1>
                        <div>
                            <?php if ( $prev_post_link ): ?>
                            <span class="wrap-previous">
                                <span class="label-previous tiny-label"><?php _e('Previous','tiny'); ?></span>
                                <?php echo $prev_post_link; ?>
                            </span>
                            <?php endif; ?>
                            
                            <?php if ( $next_post_link ): ?>
                            <span class="wrap-next">
                                <span class="label-next tiny-label"><?php _e('Next','tiny'); ?></span>
                                <?php echo $next_post_link; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php
                endif;

            endif;
            
            // Pagination of post lists 
            $posts_pagination = str_replace(    'screen-reader-text',
                                                'posts-pagination-label tiny-label',
                                                get_the_posts_pagination(
                                                    array(
                                                        'mid_size' => 30,
                                                        'screen_reader_text' => __('More posts','tiny')
                                                    ) 
                                                )
                                            );
            if ( $posts_pagination ): ?>
                <nav class="posts-navigation">
                    <?php echo $posts_pagination; ?>
                </nav>
            <?php endif;

            comments_template();


        } else if ( is_search() ) {
            if ( get_search_query() ){
                printf('<h2>%s</h2>', __('Nothing found :(','tiny'));
            }
        } else {
            printf('<h1>%s</h1>', __('No content to display','tiny'));
        }
        ?>

        </section>
    </main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>