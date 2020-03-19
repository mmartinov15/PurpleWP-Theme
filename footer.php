    </div>

<?php wp_footer(); ?>

<div class="container footer">
<!-- 	<div class="row"> -->
	
	
	<div class="disclamer mx-auto">
		<div id="logo-footer">
			
				<?php if ( get_theme_mod( 'purpleWP_logo' ) ) : ?>

		        <a class="blog-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>' rel='home'>
		        	<img src='<?php echo esc_url( get_theme_mod( 'purpleWP_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>'>
		        </a>

			<?php elseif ( get_bloginfo( 'description' ) || get_bloginfo( 'title' ) ) :

				// h1 on singular, h2 elsewhere
				$title_type = is_singular() ? 'h2' : 'h1'; ?>

				<<?php echo $title_type; ?> class="blog-title foot">
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></a>
				</<?php echo $title_type; ?>>

			<?php endif; ?>

         </div>
		</div>
			
		<div class="text mx-auto">
			<p>
			
Copyright © movies-site All Rights Reserved

Disclaimer: This site does not store any files on its server. All contents are provided by non-affiliated third parties.


		</p>
		</div>
		
		
	</div>
	
	
		<div class="credits">

  <p>&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.</p>
  <p><?php _e( 'By', 'purpleWP' ); ?> <a href="purple.makos.top">Marina Martinov</a>.</p>

<!-- </div> -->
	</div>
</div>




</body>
</html>
