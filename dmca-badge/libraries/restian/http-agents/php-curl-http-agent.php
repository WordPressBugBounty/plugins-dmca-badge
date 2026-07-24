<?php
// @todo Need to support POST, PUT, DELETE
/**
 * An HTTP Agent for RESTian that uses PHP's CURL to make HTTP requests.
 */
class RESTian_Php_Curl_Http_Agent extends RESTian_Http_Agent_Base {
  /**
   * Makes an HTTP request using PHP's CURL
   *
   * @param RESTian_Request $request
   * @param RESTian_Response $response
   * @return RESTian_Response
   */
  function make_request( $request, $response ) {
    $error_path = plugin_dir_url(__FILE__) ;
	  try {
      
      // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_init -- cURL is intentionally used by this HTTP client.
      $ch = curl_init();

      // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt_array -- cURL is intentionally used by this HTTP client.
      curl_setopt_array(
        $ch, array(
          CURLOPT_URL => $request->get_url(),
          CURLOPT_USERAGENT => $request->client->get_user_agent(),
          CURLOPT_HTTPHEADER => $request->get_curl_headers(),
          CURLOPT_POST => false,
          CURLOPT_HEADER => false,
          CURLOPT_TIMEOUT => '30',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => $request->sslverify,
          CURLOPT_SSL_VERIFYHOST => ( true === $request->sslverify ) ? 2 : false,
      ));
      if ( ! $request->omit_body ) {
        // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec -- cURL is intentionally used by this HTTP client.
        $response->body = trim( curl_exec( $ch ) );
      }

      // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_getinfo -- cURL is intentionally used by this HTTP client.
      $info = curl_getinfo($ch);
      $response->status_code = $info['http_code'];

      // phpcs:disable WordPress.WP.AlternativeFunctions.curl_curl_errno,WordPress.WP.AlternativeFunctions.curl_curl_error
      if ( 0 != curl_errno( $ch ) ) {
        $response->set_http_error( curl_errno( $ch ), curl_error( $ch ) );
      }
      // phpcs:enable

      if ( ! $request->omit_result ) {
        $response->result = (object)array(
          'info' => $info,
          'version' => curl_version(),
          // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_error -- cURL is intentionally used by this HTTP client.
          'error' => curl_error( $ch ),
          // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_errno -- cURL is intentionally used by this HTTP client.
          'errno' => curl_errno( $ch ),
        );
      }

      return $response;
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
// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump -- Debug output.
var_dump($er);    
      echo wp_kses_post("<br> " . esc_url($error_path));
    }  
    catch ( Throwable $th){
      echo esc_html('ErrorException Message: ' . $th->getMessage());
// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump -- Debug output.
var_dump($th);
      echo wp_kses_post("<br> " . esc_url($error_path));
    }
  }
}

