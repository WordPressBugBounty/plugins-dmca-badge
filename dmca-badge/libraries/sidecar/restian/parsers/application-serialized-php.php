<?php

/**
 * TODO: Need to test this one first.
 */
class RESTian_Application_Serialized_Php_Parser extends RESTian_Parser_Base {
  /**
   * Returns an object or array of stdClass objects from a string containing valid Serialized PHP
   *
   * @param string $body
   * @return array|object|void A(n array of) stdClass object(s) with structure dictated by the passed Serialized PHP string.
   */
  function parse( $body ) {
    $error_path = plugin_dir_url(__FILE__) ;
    try {


    return unserialize( $body );
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