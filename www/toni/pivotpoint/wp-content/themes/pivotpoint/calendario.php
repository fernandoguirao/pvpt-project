<?php
/*
Template Name: calendario
*/
?>
<?php get_header(); ?>

				<div id="cuerpo" class="calendario">
					<div class="sombra hidden-desktop">
					</div>
					<div class="mini-header imgbarra">
						<div class="container">
							<div class="captionimg">
								<h2>
									Calendario 2012-2013
								</h2>
							</div>
						</div> 
						<div class="imagen-main">
						</div>
					</div>
					<div id="contenido" class="container">
					
    					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    					    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        					    <?php if ( is_front_page() ) { ?>
        					    <h2 class="entry-title"><?php the_title(); ?></h2>
        					    <?php } else { ?>
        					    <h1 class="entry-title"><?php the_title(); ?></h1>
        					    <?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

				<?php //comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

					
					</div>
				</div>

<?php get_footer(); ?>