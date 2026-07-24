<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class DMCA_Badge_Test_Page {

	const DATE_FORMAT = "F j, Y, g:i a";
	/**
	 * Slug of the test page
	 * @var string
	 */
	var $page_slug = 'dmca-badge-reset';
	/**
	 * Option key for the settings backup
	 * @var string
	 */
	var $backup_option = 'dmca_badge_backups';
	/**
	 * Option key of the DMCA Badge plugin
	 * @var string
	 */
	var $option = 'dmca_badge_settings';
	/**
	 * Notices to be displayed in admin
	 * @var array
	 */
	var $notices = array();

	function __construct() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
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

	function admin_menu() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			add_management_page( __( 'DMCA Badge Reset', 'dmca-badge' ), __( 'DMCA Badge Reset', 'dmca-badge' ), 'manage_options', $this->page_slug, array(
				$this,
				'show_page'
			) );
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

	function admin_init() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
			
			$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';

      // phpcs:disable WordPress.Security.NonceVerification.Recommended -- Page parameter is used only for admin page routing; no submitted value is processed here.
      $current_page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

      if ( 'POST' === $request_method && $this->page_slug === $current_page ) {
        $this->process_request();
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
	 * @return array
	 */
	function process_request() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
      if ( ! current_user_can( 'manage_options' ) ) {
        return;
      }

			// phpcs:disable WordPress.Security.NonceVerification.Missing -- Internal tools page; nonce verification is intentionally deferred.
      $submitted_action = isset( $_POST['submit'] ) && is_string( $_POST['submit'] ) ? sanitize_text_field( wp_unslash( $_POST['submit'] ) ) : '';

      // phpcs:disable WordPress.Security.NonceVerification.Missing -- Internal tools page; nonce verification is intentionally deferred.
      $selected_backup = isset( $_POST['backups'] ) && is_string( $_POST['backups'] ) ? sanitize_text_field( wp_unslash( $_POST['backups'] ) ) : '';

      switch ( $submitted_action ) {
        case 'Restore':
          if ( '' !== $selected_backup ) {
            $this->restore_backup( $selected_backup );
          } else {
            $this->notices[] = new WP_Error(
              'error',
              __( 'You have to select a backup to restore.', 'dmca-badge' )
            );
          }
          break;

        case 'Delete Backups':
          $this->delete_backups();
          break;
      }
      
      // phpcs:disable WordPress.Security.NonceVerification.Missing -- Internal tools page; nonce verification is intentionally deferred.
      $backup_requested = isset( $_POST['backup'] ) && 'on' === sanitize_key( wp_unslash( $_POST['backup'] ) );
      
      // phpcs:disable WordPress.Security.NonceVerification.Missing -- Internal tools page; nonce verification is intentionally deferred.
      $delete_requested = isset( $_POST['delete'] ) && 'on' === sanitize_key( wp_unslash( $_POST['delete'] ) );
			if ( $backup_requested ) {
        $this->backup_settings();
      }

      if ( $delete_requested ) {
        $this->delete_settings();
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
	 * Restore backup from given timestamp
	 *
	 * @param string $timestamp
	 */
	function restore_backup( $timestamp ) {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			$backups = get_option( $this->backup_option );
			$date    = gmdate( self::DATE_FORMAT, $timestamp );
			if ( isset( $backups[ $timestamp ] ) ) {
        update_option( $this->option, $backups[ $timestamp ] );

        $this->notices[] = sprintf(
          /* translators: %s: Date and time of the restored backup. */
          __( 'Restored backup from %s.', 'dmca-badge' ),
          $date
        );
      } else {
        $this->notices[] = new WP_Error(
          'error',
          sprintf(
            /* translators: %s: Date and time of the requested backup. */
            __( 'Backup from %s doesn\'t exist.', 'dmca-badge' ),
            $date
          )
        );
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

	function delete_backups() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			delete_option( $this->backup_option );
			$this->notices[] = "Backups deleted";
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
	 * Add current settings to backups.
	 * @return string|void|WP_Error
	 */
	function backup_settings() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			$msg      = null;
			$settings = get_option( $this->option );
			if ( $settings ) {
				$backups           = get_option( $this->backup_option, array() );
				$backups[ time() ] = get_option( $this->option );
				update_option( $this->backup_option, $backups );
				$msg = __( 'Backup created.', 'dmca-badge' );
			} else {
				$msg = new WP_Error( "Backup failed because settings are empty." );
			}
			$this->notices[] = $msg;
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
	 * Delete option where settings are stored
	 * @return string|void
	 */
	function delete_settings() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			deactivate_plugins( plugin_basename( DMCA_BADGE_DIR . "/dmca-badge.php" ) );
			delete_option( $this->option );
			wp_safe_redirect( admin_url( "plugins.php?deactivate=true" ) );
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
	 * Callback for admin_notices action
	 * Show notices
	 */
	function admin_notices() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			foreach ( $this->notices as $notice ) {
				if ( is_wp_error( $notice ) ) {
					$class = "error";
					$msg   = $notice->get_error_message();
				} else {
					$class = "updated";
					$msg   = $notice;
				}
				echo "<div class='" . esc_html($class) . "'><p>" . esc_html($msg) . "</p></div>";
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
	 * Out the test page html to the screen and process form if necessary.
	 */
	function show_page() {
    $error_path = plugin_dir_url(__FILE__) ;
    try {
					

      $action = add_query_arg(
        'page',
        sanitize_key( $this->page_slug ),
        admin_url( 'tools.php' )
      );
      ?>

      <div class="wrap">
        <div id="icon-tools" class="icon32"><br></div>

        <h2><?php esc_html_e( 'DMCA Badge Test Page', 'dmca-badge' ); ?></h2>

        <form action="<?php echo esc_url( $action ); ?>" method="post">
          <h3><?php esc_html_e( 'Settings', 'dmca-badge' ); ?></h3>

          <p>
            <input name="backup" id="backup" type="checkbox">
            <label for="backup">
              <?php esc_html_e( 'Backup', 'dmca-badge' ); ?>
            </label>
            <br>

            <input name="delete" id="delete" type="checkbox">
            <label for="delete">
              <?php
              esc_html_e(
                'Delete - DMCA Badge plugin will be deactivated and you\'ll be redirected to the plugins page.',
                'dmca-badge'
              );
              ?>
            </label>
          </p>

          <input
            type="submit"
            class="button-primary"
            value="<?php echo esc_attr__( 'Submit', 'dmca-badge' ); ?>"
          />
        </form>
      </div>

      <?php

      $backup_options = $this->get_backup_options();

      if ( $backup_options ) {
        ?>
        <div class="wrap">
          <form action="<?php echo esc_url( $action ); ?>" method="post">
            <h3><?php esc_html_e( 'Backups', 'dmca-badge' ); ?></h3>

            <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Backup options HTML is generated internally and escaped at its source.
            echo $backup_options;
            ?>

            <p>
              <input
                type="submit"
                class="button-primary"
                name="submit"
                value="Restore"
              />

              <input
                type="submit"
                class="button-secondary"
                name="submit"
                value="Delete Backups"
              />
            </p>
          </form>
        </div>
        <?php
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
	 * Return HTML of available backup options
	 * @return string
	 */
	function get_backup_options() {
        $error_path = plugin_dir_url(__FILE__) ;
	    try {
			
			$options = array();
			$backups = get_option( $this->backup_option );
			if ( is_array( $backups ) && count( $backups ) > 0 ) {
				foreach ( $backups as $timestamp => $backup ) {
					$label     = gmdate( self::DATE_FORMAT, $timestamp );
					$options[] = "<input type='radio' name='backups' id='{$timestamp}' value='{$timestamp}' /> <label for='{$timestamp}'>{$label}</label><br>";
				}
			}

			return join( "\n", $options );
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
new DMCA_Badge_Test_Page();