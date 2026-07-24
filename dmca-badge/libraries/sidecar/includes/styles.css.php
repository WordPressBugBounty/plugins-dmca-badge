<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Designed to allow caching
 *
 * @author Mike Schinkel <mike@newclarity.net>
 *
 */
/**
 * @param string $css_dir
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
function output_css( $css_dir ) {

  $error_path = plugin_dir_url(__FILE__) ;
    try {

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $color_scheme = isset( $_GET['color'] ) && is_string( $_GET['color'] ) ? sanitize_key( wp_unslash( $_GET['color'] ) ) : '';

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $cache_seconds = isset( $_GET['cache'] ) && is_scalar( $_GET['cache'] ) ? absint( wp_unslash( $_GET['cache'] ) ) : 0;

    $files = headers(
      array(
        'css_dir'       => $css_dir,
        'color_scheme'  => $color_scheme,
        'cache_seconds' => $cache_seconds,
      )
    );
    
    body( $files );
  }
  catch (Exception $e) 
  {  
    echo esc_html('Exception Message: ' . $e->getMessage());
  
    if ($e->getSeverity() === E_ERROR) {
        echo esc_html("E_ERROR triggered." . PHP_EOL);
    } else if ($e->getSeverity() === E_WARNING) {
        echo esc_html("E_WARNING triggered." . PHP_EOL);
    }
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch (ErrorException  $er)
  {  
    echo esc_html('ErrorException Message: ' . $er->getMessage());
    
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch ( Throwable $th){
    echo esc_html('ErrorException Message: ' . $th->getMessage());

    echo wp_kses_post("<br> " . esc_url($error_path));
  }
}
/**
 * @param array $args
 *
 * @return array Files
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
function headers( $args ) {
  $error_path = plugin_dir_url(__FILE__) ;
    try {

    header( "Content-type: text/css" );

    if ( empty( $args['color_scheme'] ) )
      $args['color_scheme'] = 'grey';
    if ( empty( $args['cache_seconds'] ) )
      $args['cache_seconds'] = 3600;

    $files = array();
    $files[0] = "{$args['css_dir']}/styles.css";
    $files[1] = "{$args['css_dir']}/styles-{$args['color_scheme']}.css";

    $file_time = filemtime( __FILE__ );
    foreach( $files as $file )
      if ( $file_time < ( $new_file_time = filemtime( $file ) ) )
        $file_time = $new_file_time;

    $time_string = format_gmt_string( $file_time );
    $timeout = format_gmt_string( time() + (int)$args['cache_seconds'] );
    $etag = (string)$file_time;

    $modified = true;
    $matched = false;

    if ( ! empty( $_SERVER['HTTP_IF_NONE_MATCH'] ) ) {
      // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
      $matched = $etag == trim( $_SERVER['HTTP_IF_NONE_MATCH'], '"' );
    }

    if ( ! empty( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) )
      $modified = $time_string != $_SERVER['HTTP_IF_MODIFIED_SINCE'];

    if ( $matched || ! $modified ) {
      header('HTTP/1.1 304 Not Modified');
      exit();
    } else {
      header( "Cache-Control: public, max-age={$args['cache_seconds']}" );
      header( "Last-Modified: {$time_string}" );
      header( "ETag: \"{$file_time}\"" );
      header( "Expires: {$timeout}" );
      header( "Connection: close" );
    }
    return $files;
  }
  catch (Exception $e) 
  {  
    echo esc_html('Exception Message: ' . $e->getMessage());
  
    if ($e->getSeverity() === E_ERROR) {
        echo esc_html("E_ERROR triggered." . PHP_EOL);
    } else if ($e->getSeverity() === E_WARNING) {
        echo esc_html("E_WARNING triggered." . PHP_EOL);
    }
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch (ErrorException  $er)
  {  
    echo esc_html('ErrorException Message: ' . $er->getMessage());
    
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch ( Throwable $th){
    echo esc_html('ErrorException Message: ' . $th->getMessage());

    echo wp_kses_post("<br> " . esc_url($error_path));
  }
}
/**
 * Loads contents of CSS files and then echos them out.
 *
 * @param array $files
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
function body( $files ) {
  $error_path = plugin_dir_url(__FILE__) ;
    try {

    foreach( $files as $file ) {
      if ( file_exists( $file ) ) {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
        echo file_get_contents( $file );
      }
    }
  }
  catch (Exception $e) 
  {  
    echo esc_html('Exception Message: ' . $e->getMessage());
  
    if ($e->getSeverity() === E_ERROR) {
        echo esc_html("E_ERROR triggered." . PHP_EOL);
    } else if ($e->getSeverity() === E_WARNING) {
        echo esc_html("E_WARNING triggered." . PHP_EOL);
    }
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch (ErrorException  $er)
  {  
    echo esc_html('ErrorException Message: ' . $er->getMessage());
    
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch ( Throwable $th){
    echo esc_html('ErrorException Message: ' . $th->getMessage());

    echo wp_kses_post("<br> " . esc_url($error_path));
  }
}
/**
 * @param datetime $datetime
 * @return string
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
function format_gmt_string( $datetime ) {
  $error_path = plugin_dir_url(__FILE__) ;
    try {

    return gmdate( 'D, d M Y H:i:s ', $datetime ) . 'GMT';
  }
  catch (Exception $e) 
  {  
    echo esc_html('Exception Message: ' . $e->getMessage());
  
    if ($e->getSeverity() === E_ERROR) {
        echo esc_html("E_ERROR triggered." . PHP_EOL);
    } else if ($e->getSeverity() === E_WARNING) {
        echo esc_html("E_WARNING triggered." . PHP_EOL);
    }
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch (ErrorException  $er)
  {  
    echo esc_html('ErrorException Message: ' . $er->getMessage());
    
    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
  catch ( Throwable $th){
    echo esc_html('ErrorException Message: ' . $th->getMessage());

    echo wp_kses_post("<br> " . esc_url($error_path));
  }  
}