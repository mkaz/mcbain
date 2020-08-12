<?php

/* CUSTOMIZER SETTINGS
------------------------------------------------ */

if ( ! class_exists( 'McBain_Customize' ) ) :
	class McBain_Customize {

		public static function register( $wp_customize ) {

			// Add our Customizer section
			$wp_customize->add_section( 'mcbain_options', array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'Customize the theme settings for McBain.', 'mcbain' ),
				'title' 		=> __( 'Theme Options', 'mcbain' ),
				'priority' 		=> 35,
			) );

			// Custom accent color
			$wp_customize->add_setting( 'mcbain_accent_color', array(
				'default' 			=> '#121212',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mcbain_accent_color', array(
				'description' 	=> __( 'Set the background color used for the sidebar on desktop, and the header on tablet and mobile.', 'mcbain' ),
				'label' 		=> __( 'Sidebar background', 'mcbain' ),
				'section' 		=> 'colors',
				'settings' 		=> 'mcbain_accent_color',
				'priority' 		=> 10,
			) ) );

			// Dark sidebar text
			$wp_customize->add_setting( 'mcbain_dark_sidebar_text', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'mcbain_sanitize_checkbox',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'mcbain_dark_sidebar_text', array(
				'description' 	=> __( 'Check this if you have set a light background color for the sidebar/mobile header.', 'mcbain' ),
				'label' 		=> __( 'Dark text in sidebar', 'mcbain' ),
				'section' 		=> 'colors',
				'type' 			=> 'checkbox',
				'priority' 		=> 15,
			) );

			// Set the home page title
			$wp_customize->add_setting( 'mcbain_home_title', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'mcbain_home_title', array(
				'description' 	=> __( 'The title you want shown on the page that displays your latest posts.', 'mcbain' ),
				'label' 		=> __( 'Front Page Title', 'mcbain' ),
				'type' 			=> 'textarea',
				'section' 		=> 'mcbain_options',
			) );

			// Hide social
			$wp_customize->add_setting( 'mcbain_hide_social', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'mcbain_sanitize_checkbox',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'mcbain_hide_social', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'mcbain_options',
				'label' 		=> __( 'Hide Social Buttons', 'mcbain' ),
				'description' 	=> __( 'Whether to hide the social buttons and the search overlay button.', 'mcbain' ),
			) );

			// Hide related posts
			$wp_customize->add_setting( 'mcbain_hide_related_posts', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'mcbain_sanitize_checkbox',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'mcbain_hide_related_posts', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'mcbain_options',
				'label' 		=> __( 'Hide Related Posts', 'mcbain' ),
				'description' 	=> __( 'Whether to hide the related posts section on single posts.', 'mcbain' ),
			) );

			// Decide order of month + day in post previews
			$wp_customize->add_setting( 'mcbain_preview_date_format', array(
				'capability' 		=> 'edit_theme_options',
				'default' 			=> 'month-day',
				'sanitize_callback' => 'mcbain_sanitize_radio',
			) );

			$wp_customize->add_control( 'mcbain_preview_date_format', array(
				'type' 			=> 'radio',
				'section' 		=> 'mcbain_options',
				'label' 		=> __( 'Archive Date Format', 'mcbain' ),
				'description' 	=> __( 'Choose whether post previews should display the date with month or day of month first.', 'mcbain' ),
				'choices' 		=> array(
					'month-day' 	=> __( 'Month first (Jan 1)', 'mcbain' ),
					'day-month' 	=> __( 'Day of month first (1 Jan)', 'mcbain' ),
				),
			) );

			// Lowercase calendar month
			$wp_customize->add_setting( 'mcbain_preview_date_lowercase', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'mcbain_sanitize_checkbox',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'mcbain_preview_date_lowercase', array(
				'label' 		=> __( 'Show the month name in lowercase', 'mcbain' ),
				'section' 		=> 'mcbain_options',
				'type' 			=> 'checkbox',
				'priority' 		=> 15,
			) );

			// Make built-in controls use live JS preview
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

			// SANITATION

			// Sanitize boolean for checkbox
			function mcbain_sanitize_checkbox( $checked ) {
				return ( ( isset( $checked ) && true == $checked ) ? true : false );
			}

			// Sanitize radio buttons
			function mcbain_sanitize_radio( $input, $setting ) {

				// Ensure input is a slug.
				$input = sanitize_key( $input );

				// Get list of choices from the control associated with the setting.
				$choices = $setting->manager->get_control( $setting->id )->choices;

				// If the input is a valid key, return it; otherwise, return the default.
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
			}

		}

		// Output custom CSS in the header
		public static function header_output() {
			?>

			<!-- Customizer CSS -->

			<style type="text/css">

				<?php

				self::generate_css( 'body .site-header', 'background-color', 'mcbain_accent_color' );
				self::generate_css( '.social-menu.desktop', 'background-color', 'mcbain_accent_color' );
				self::generate_css( '.social-menu a:hover', 'color', 'mcbain_accent_color' );
				self::generate_css( '.social-menu a.active', 'color', 'mcbain_accent_color' );
				self::generate_css( '.mobile-menu-wrapper', 'background-color', 'mcbain_accent_color' );
				self::generate_css( '.social-menu.mobile', 'background-color', 'mcbain_accent_color' );
				self::generate_css( '.mobile-search.active', 'background-color', 'mcbain_accent_color' );

				?>

			</style>

			<!-- /Customizer CSS -->

			<?php
		}

		// Function for generating the custom CSS
		public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
			$return = '';
			$mod = esc_attr( get_theme_mod( $mod_name ) );
			if ( ! empty( $mod ) ) {
				$return = sprintf( '%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix );
				echo $return;
			}
			return $return;
		}

		// Initiate the live preview JS
		public static function live_preview() {
			wp_enqueue_script( 'mcbain-themecustomizer', get_template_directory_uri() . '/assets/js/theme-customizer.js', array( 'jquery', 'customize-preview' ), '', true );
		}

	}

	// Output custom CSS to live site
	add_action( 'wp_head' , array( 'McBain_Customize', 'header_output' ) );

	// Setup the Theme Customizer settings and controls
	add_action( 'customize_register', array( 'McBain_Customize', 'register' ) );

	// Enqueue live preview javascript in Theme Customizer admin screen
	add_action( 'customize_preview_init', array( 'McBain_Customize', 'live_preview' ) );

endif;
