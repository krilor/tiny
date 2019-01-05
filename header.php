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
        <header class="site-header silo">
        
            <div class="site-branding group">
                <?php
                $logo = get_custom_logo();
                if ( $logo ) : ?>
                    <div id="site-logo-container"><?php echo $logo; ?></div>
                <?php else: ?>
                    <div id="site-title-container"><a class="site-title" href="<?php echo site_url(); ?>"><?php bloginfo( 'name' ); ?></a></div>
                <?php endif; ?>

            </div>

            <nav id="site-navigation" class="main-navigation">
                <button id="primary-menu-toggle" class="nav-toggle button" tiny-toggle="primary-menu"><?php _e('Menu', 'tiny'); ?></button>
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary-menu',
                        'menu_class'     => 'menu primary-menu',
                        'menu_id'        => 'primary-menu',
                    ) );
                ?>
            </nav>

        </header>