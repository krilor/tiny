<?php
/**
 * The template file for the sidebar
 *
 * @package Tiny
 */
if ( is_active_sidebar( 'sidebar-1' ) ): ?>
    <div id="sidebar-container" class="main-sidebar silo">
        <ul id="sidebar">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </ul>
    </div>
<?php endif; ?>