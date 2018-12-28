<?php
/**
 * The template file for the sidebar
 *
 * @package Tiny
 */
if ( is_active_sidebar( 'sidebar-1' ) ): ?>
    <div class="sidebar-container widget-area silo">
        <ul id="sidebar-1" class="sidebar">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </ul>
    </div>
<?php endif; ?>