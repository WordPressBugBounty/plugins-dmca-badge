<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * This code is run after Imperative validates
 * the required libraries are available and loaded.
 */
define( 'DMCA_BADGE_DIR', dirname( __FILE__ ) );
define( 'DMCA_BADGE_VER', '2.3.1' );
define( 'DMCA_BADGE_MIN_PHP', '8.0' );
define( 'DMCA_BADGE_MIN_WP', '6.6' );

require( DMCA_BADGE_DIR . '/classes/class-list-pages.php');
require( DMCA_BADGE_DIR . '/classes/class-plugin.php');
require( DMCA_BADGE_DIR . '/classes/class-widget.php');
if ( WP_DEBUG ) {
  require( DMCA_BADGE_DIR . '/classes/class-test-page.php' );
}