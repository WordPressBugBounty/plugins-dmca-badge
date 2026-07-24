<?php

/**
 *
 */
class Sidecar_Field {

	/**
	 * @var Sidecar_Plugin_Base
	 */
	var $plugin;

	/**
	 * @var Sidecar_Form
	 */
	var $form;

	/**
	 * @var array
	 */
	var $section;

	/**
	 * @var string
	 */
	var $field_name;

	/**
	 * @var string
	 */
	var $field_slug;

	/**
	 * @var string
	 */
	var $field_label;

	/**
	 * @var string
	 */
	var $field_type;

	/**
	 * @var string
	 */
	var $field_help;

	/**
	 * @var int
	 */
	var $field_size;

	/**
	 * @var int|array
	 */
	var $field_validator;

	/**
	 * @var string
	 */
	var $field_default;

	/**
	 * @var array
	 */
	var $field_options;

	/**
	 * @var bool
	 */
	var $field_required = false;

	/**
	 * @var bool|callable
	 */
	var $field_handler = false;

	/**
	 * Indicates this field value if used for an API.
	 * Defaults to $this->field_name, can be see to another name
	 * (i.e. field_name = 'content_type', api_var = 'type'
	 * but if set to false it will cause the API to ignore this field.
	 * @var null|bool|string
	 */
	var $api_var;

	/**
	 * @var array
	 */
	var $_extra = array();

	/**
	 * @var array
	 */
	var $field_allow_html = false;

	/**
	 * @param string $field_name
	 * @param array $args
	 */
	function __construct( $field_name, $args = array() ) {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			$this->field_name = $field_name;
			/**
			 * Copy properties in from $args, if they exist.
			 */
			foreach ( $args as $property => $value ) {
				if ( property_exists( $this, $property ) ) {
					$this->$property = $value;
				} else if ( property_exists( $this, $property = "field_{$property}" ) ) {
					$this->$property = $value;
				} else {
					$this->_extra[ $property ] = $value;
				}
			}
			if ( ! $this->field_type ) {
				$this->field_type = 'password' == $this->field_name ? 'password' : 'text';
			}

			if ( 'hidden' == $this->field_type ) {
				$this->field_label = false;
			} else if ( ! $this->field_label ) {
				$this->field_label = ucwords( $this->field_name );
			}

			if ( ! $this->field_size ) {
				$this->field_size = preg_match( '#(text|password)#', $this->field_type ) ? 40 : false;
			}

			if ( ! $this->field_slug ) {
				$this->field_slug = str_replace( array( '_', ' ' ), '-', $this->field_name );
			}

			if ( is_null( $this->api_var ) ) {
				$this->api_var = $this->field_name;
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
	 * @return string
	 */
	function get_input_name() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			return "{$this->plugin->option_name}[{$this->form->form_name}][{$this->field_name}]";
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
	 * Sets HTML id like the following:
	 *
	 * @return string
	 * @example
	 *  HTML name = my_plugin_settings[_form-name}[field-name]
	 *  HTML id =>  my-plugin-settings--form-name-field-name
	 *
	 */
	function get_input_id() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			$input_name = $this->get_input_name();
			$input_id   = str_replace( array( '[_', '_', '][', '[', ']' ), array( '--', '-', '-', '-', '' ), $input_name );

			return $input_id;
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
	 * @return string
	 */
	function get_input_size_html() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			return $this->field_size ? " size=\"{$this->field_size}\"" : '';
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
	 * @return string
	 */
	function get_input_help_html() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			return $this->field_help ? "\n<br />\n<p class=\"{$this->plugin->css_base}-field-help\">{$this->field_help}</p>" : false;
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
	 * @return string
	 */
	function get_html() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
					
					/**
					 * @todo: Get options with all expected elements initialized
					 */
					$form       = $this->form;
					$value      = $form->get_setting( $this->field_name );
					$input_name = $this->get_input_name();
					$input_id   = $this->get_input_id();
					$size_html  = $this->get_input_size_html();
					$css_base   = $this->plugin->css_base;
					$help_html  = $this->get_input_help_html();

					if ( 'radio' == $this->field_type ) {
						$html = array( "<ul id=\"{$input_id}-radio-field-options\" class=\"radio-field-options\">" );
						foreach ( $this->field_options as $option_value => $option_label ) {
							$checked      = ( ! empty( $value ) && $option_value == $value ) ? 'checked="checked" ' : false;
							$selected     = ( ! empty( $value ) && $option_value == $value ) ? 'selected' : '';
							$option_value = esc_attr( $option_value );
							$html[] = sprintf(
								'<li><label for="%1$s-%2$s" class="%3$s"><input type="radio" id="%1$s-%2$s" class="%4$s-field" name="%5$s" value="%2$s" %6$s/> %7$s</label></li>',
								$input_id,
								$option_value,
								$selected,
								$css_base,
								$input_name,
								$checked,
								$option_label
							);
						}
						$html = implode( "\n", $html ) . "</ul>{$help_html}";
					} else if ( 'select' == $this->field_type ) {
						$html = array( "<select id=\"{$input_id}-select-field-options\" name=\"{$input_name}\" class=\"select-field-options\">" );
						foreach ( $this->field_options as $option_value => $option_label ) {
							$selected     = ( ! empty( $value ) && $option_value == $value ) ? ' selected="selected"' : false;
							$option_value = esc_attr( $option_value );
							$html[] = sprintf(
								'<option value="%1$s"%2$s>%3$s</option>',
								$option_value,
								$selected,
								$option_label
							);
						}
						$html = implode( "\n", $html ) . "</select>{$help_html}";
					} else if ( 'checkbox' == $this->field_type ) {
						$checked = ! empty( $value ) ? 'checked="checked" ' : false;
						$html = sprintf(
							'<input type="checkbox" id="%1$s" class="%2$s-field" name="%3$s" value="1" %4$s/>
							<label for="%1$s">%5$s</label>',
							$input_id,
							$css_base,
							$input_name,
							$checked,
							$this->field_label
						);
					} else if ( 'hidden' == $this->field_type ) {
						$html = sprintf(
							'<input type="hidden" id="%1$s" name="%2$s" value="%3$s" />',
							$input_id,
							$input_name,
							$value
						);
					} else if ( 'textarea' == $this->field_type ) {
			//      $value = htmlentities( $value );
						if ( $rows = $this->get_extra( 'rows' ) ) {
							$rows = " rows=\"{$rows}\"";
						}
						if ( $cols = $this->get_extra( 'cols' ) ) {
							$cols = " cols=\"{$cols}\"";
						}
						$html = sprintf(
							'<textarea id="%1$s" name="%2$s"%3$s%4$s>%5$s</textarea>%6$s',
							$input_id,
							$input_name,
							$rows,
							$cols,
							$value,
							$help_html
						);
					} else {
						$html = sprintf(
							'<input type="%1$s" id="%2$s" name="%3$s" value="%4$s" class="%5$s-field"%6$s/>%7$s',
							$this->field_type,
							$input_id,
							$input_name,
							$value,
							$css_base,
							$size_html,
							$help_html
						);
					}
					$field_wrapper_id = $this->get_wrapper_id();
					$html = sprintf(
						'<div id="%1$s" class="%2$s">%3$s</div>',
						$field_wrapper_id,
						$this->field_type,
						$html
					);

					return apply_filters( 'dmca_filters_get_form_field_html', $html, $this->field_name, $this );
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
	 * @param string|$property_name
	 *
	 * @return null|int|string
	 */
	function get_extra( $property_name ) {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			$value = null;
			if ( isset( $this->_extra[ $prefixed_name = "field_{$property_name}" ] ) ) {
				$value = $this->_extra[ $prefixed_name ];
			} else if ( isset( $this->_extra[ $property_name ] ) ) {
				$value = $this->_extra[ $property_name ];
			}

			return $value;
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
	 * @return string
	 */
	function get_wrapper_id() {
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			return "field-{$this->field_slug}-input";
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