<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$home = isset( $_SERVER['HOME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HOME'] ) ) : '';
require $home . '/Libraries/restian/restian.php';
require( dirname( dirname( __FILE__ ) ) . '/dmca-api-client.php' );

/**
 * This email has been registered and it's password set as below.
 */
define( "DMCA_ACCOUNT_EMAIL", "dmca-api-test@newclarity.net" );
define( "DMCA_ACCOUNT_PASSWORD", "abc123" );

/**
 * If WP_DIR is set in CLI environment then it will use the WordPress HTTP Agent.
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
if ( $wp_dir = getenv("WP_DIR") ) {
  chdir( $wp_dir );
  require( "{$wp_dir}/wp-load.php" );
}

/**
 * Class DMCA_API_ClientTest
 */
class DMCA_API_ClientTest extends PHPUnit_Framework_TestCase {
  /**
   * @var DMCA_API_Client
   */
  var $api;

  public function setup() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
      
      $this->api = new DMCA_API_Client();
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
   *
   */
  function testGetAnonymousBadges() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
      
      $badges = $this->api->get_anonymous_badges();
      $this->assertTrue( is_array( $badges ) );
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
   *
   */
  function testRegister() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
      
      $email = "dmca-api-tester-" . wp_rand( 1000000, 9999999 ) . '@newclarity.net';
      $response = $this->api->register( array(
        'first_name'    => 'DMCA API',
        'last_name'     => 'Tester',
        'company_name'  => 'NewClarity LLC',
        'email'         => $email,
      ));
      if ( $response->is_error() ) {
        $error = $response->get_error();
      } else {
        $result = "\nEmail: {$email} registered.";
      }
      $this->setResult( isset( $error ) ? $error : $result );
      $this->assertFalse( $response->is_error() );
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
   *
   */
  function testAuthenticate() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
      
      $response = $this->api->authenticate( array(
        "email"     => DMCA_ACCOUNT_EMAIL,
        "password"  => DMCA_ACCOUNT_PASSWORD
      ));
      $this->assertTrue( $response->authenticated );
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
}