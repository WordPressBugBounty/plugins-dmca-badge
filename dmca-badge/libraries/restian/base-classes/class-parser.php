<?php

abstract class RESTian_Parser_Base {
  var $request;
  var $response;

  /**
   * @param RESTian_Request $request
   * @param RESTian_Response $response
   */
  function __construct( $request, $response ) {
    
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      $this->request = $request;
      $this->response = $response;
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
   * Used to throw an exception when not properly subclassed.
   *
   * @param string $body
   * @return array|object
   * @throws Exception
   */
  function parse( $body ) {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      if (1)  // This logic here only to get PhpStorm to stop highlighting the return as an error.
        throw new Exception( 'Class ' . get_class($this) . ' [subclass of ' . __CLASS__ . '] must define a parse() method.' );
      return array();
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
