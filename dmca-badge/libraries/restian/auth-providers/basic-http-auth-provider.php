<?php

class RESTian_Basic_Http_Auth_Provider extends RESTian_Auth_Provider_Base {

  /**
   * @return array
   */
  function get_new_credentials() {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      return array(
        'username' => '',
        'password' => '',
      );
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
   * @return array
   */
  function get_new_grant() {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      return array(
        'authenticated' => false,
      );
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
   * @param array $credentials
   * @return bool
   */
  function is_credentials( $credentials ) {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      return ! empty( $credentials['username'] ) && ( ! empty( $credentials['password'] ) );
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
   * @param array $grant
   * @return bool
   */
  function is_grant( $grant ) {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      return ! empty( $grant['authenticated'] );
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
   * @param RESTian_Request $request
   */
  function prepare_request( $request ) {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      $credentials = $request->get_credentials();
      $auth = base64_encode( "{$credentials['username']}:{$credentials['password']}" );
      $request->add_header( 'Authorization', "Basic {$auth}" );
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