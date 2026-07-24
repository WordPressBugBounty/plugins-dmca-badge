<?php

class DMCA_Badge_Widget extends WP_Widget {
    
    function __construct() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
            
            
            parent::__construct( 
                'dmca_widget_badge', 
                __('DMCA Website Protection Badge', 'dmca-badge'), 
                array( 
                    'description' => __( 'Display your chosen DMCA Website Protection Badge in any widget area of your site.', 'dmca-badge' ), 
                ) 
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

	function widget( $args, $instance ){
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
            
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
            echo $args['before_widget'];

            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
            echo DMCA_Badge_Plugin::this()->get_badge_html();

            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
            echo $args['after_widget'];
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