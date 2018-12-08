<?php
/**
 * The template file for the header
 *
 * @package Tiny
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tiny' ); ?></a>

    <header class="site-header">
        <?php
        $logo = get_custom_logo();
        if ( $logo ) : ?>
            <div id="site-logo"><?php echo $logo; ?></div>
        <?php endif; ?>

        <!-- TODO: If home then <p>? -->
        <h1 id="site-title" class="header-text"><?php bloginfo( 'name' ); ?></h1>


        <?php $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : // so that the edit button will allways show when using the customizer
        ?>
            <p id="site-description" class="header-text">
                <?php echo $description; ?>
            </p>
        <?php endif; ?>
    </header>


    <aside class="navigation">
        <nav id="site-navigation" class="main-navigation">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-top',
                    'menu_id'        => 'primary-menu',
                ) );
            ?>
        </nav>
    </aside>