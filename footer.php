
		</main>

		<footer class="site-footer">
			<p class="copyright">&copy; 1997-<?php echo date_i18n( __( 'Y', 'mcbain' ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></p>
		</footer>

		<?php wp_footer(); ?>

		<script>
			/* toggle for menu */
			const toggle = document.getElementById('nav-toggle');
			toggle.addEventListener( "click", function() {
				const widgets = document.getElementById('widgets');
				widgets.classList.toggle("visible");
			} );
		</script>

	</body>
</html>
