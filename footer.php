<?php
/**
 * The template file for the footer
 *
 * @package Tiny
 */
?>

</div> <!-- main-container -->

<footer class="group">

    <?php
    for ( $i = 1; $i <= 3; $i++ ):
        
        $area_id = 'footerarea' . ( $i == 1 ? '' : sprintf('-%d', $i) );

        if ( is_active_sidebar( $area_id ) ): ?>
            <div class="footerarea-container silo">
                <ul id="<?php echo $area_id; ?>" class="footerarea">
                    <?php dynamic_sidebar( $area_id ) ; ?>
                </ul>
            </div>
    <?php endif; 
    endfor;?>
</footer>

<?php wp_footer(); ?>