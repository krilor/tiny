<?php
/**
 * The template file for the header
 *
 * @package Tiny
 */
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tiny' ); ?></a>



    <div class="main-container group">
        <div class="silo">
            
            <header class="site-header group">
        
                <?php
                $logo = get_custom_logo(); // TODO display a default "logo" if custom logo is not there
                if ( $logo ) : ?>
                    <div id="site-logo"><?php echo $logo; ?></div>
                <?php endif; 

                if ( is_home() ):
                    $description = get_bloginfo( 'description' );
                    $description = $description ? $description : __('Site titles are for weak people','tiny'); // TODO change dummy text
                ?>

                    <p id="site-description" class="header-text">
                        <?php echo $description; ?>
                    </p>
                    <h1 id="site-title" class="header-text"><?php bloginfo( 'name' ); ?></h1>

                <?php elseif ( is_archive() ):
                    
                    tiny_breadcrumbs();
                    the_archive_title('<h1 id="site-title">','</h1>');

                

                endif; // is_home ?>

                
            </header>

            <nav id="site-navigation" class="main-navigation">
                <button id="primary-menu-toggle" class="nav-toggle-button"><?php _e('Menu', 'tiny'); ?></button>
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-top',
                        'menu_class'     => 'menu-top',
                        'menu_id'        => 'primary-menu',
                    ) );
                ?>
            </nav>
        </div>