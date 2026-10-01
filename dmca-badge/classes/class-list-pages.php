<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * List pages class
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class DMCA_Pages_list_table extends WP_List_Table {

	/**
	 * DMCA_Pages_list_table constructor.
	 */
	public function __construct() {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			
			parent::__construct( array(
				'singular' => 'dmca_page',
				'plural'   => 'dmca_pages',
				'ajax'     => false,
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


	/**
	 * Render single item
	 *
	 * @param object $item
	 */
	public function single_row( $item ) {		
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			echo '<tr class="dmca-status-row single-row single-row-' . esc_attr( $item->ID ) . ' dmca-status-' . esc_attr( get_dmca_submission_status_raw( $item->ID ) ) . '" data-row-id="' . esc_attr( $item->ID ) . '">';
			$this->single_row_columns( $item );
			echo '</tr>';
			
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
	 * Prepare Items
	 */
	public function prepare_items() {
				
		$error_path = plugin_dir_url(__FILE__) ;
			try {

			$per_page   = $this->get_items_per_page( 'dmca_items_per_page' );
			$settings   = dmca_get_option( 'dmca_badge_settings' );
			$post_types = array();

			foreach ( get_post_types( array( 'public' => true ) ) as $post_type => $label ) {

				if ( isset( $settings->values['theme'][ 'dmca_post_type_' . $post_type ] ) && $settings->values['theme'][ 'dmca_post_type_' . $post_type ] ) {
					$post_types[] = $post_type;
				}
			}

			$args = array(
				'post_type'      => $post_types,
				'posts_per_page' => $per_page,
				'offset'         => ( $this->get_pagenum() - 1 ) * $per_page,
			);
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only admin filter.
			if ( isset( $_GET['ds'] ) ) { $ds = sanitize_text_field( wp_unslash( $_GET['ds'] ) );

				if ( 'sent' === $ds ) {
					$args['meta_query'][] = array(
						'key'     => 'dmca_submission_status',
						'value'   => $ds,
						'compare' => '=',
					);
				} elseif ( 'not_sent' === $ds ) {
					$args['meta_query'][] = array(
						'key'     => 'dmca_submission_status',
						'compare' => 'NOT EXISTS',
					);
				}
			}

			$q           = new WP_Query();
			$this->items = $q->query( $args );

			$total_items = $q->found_posts;
			$total_pages = ceil( $total_items / $per_page );

			$this->set_pagination_args( array(
				'total_items' => $total_items,
				'total_pages' => $total_pages,
				'per_page'    => $per_page,
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


	/**
	 * Add filter box by page status
	 *
	 * @param string $which
	 */
	public function extra_tablenav( $which ) {		
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			if ( $which != 'top' ) {
				return;
			}

			echo '<div class="alignleft actions filter-by-form" style="display:flex;">';
			echo '<form method="get">';
            echo '<input type="hidden" name="page" value="dmca-badge-settings" />';
            echo '<input type="hidden" name="tab" value="pages" />';
			echo "<select name='ds' id='ds'>";
			printf( "<option value=''>%s</option>", esc_html(__( 'Select Submission Status', 'dmca-badge' )) );
			printf( "<option value='sent'>%s</option>", esc_html(__( 'Protected', 'dmca-badge' )) );
			printf( "<option value='not_sent'>%s</option>", esc_html(__( 'Not Protected', 'dmca-badge' )) );
			echo "</select>";

			submit_button( esc_html(__( 'Filter pages', 'dmca-badge' )), '', '', false, array( 'id' => 'filter-submit' ) );
			echo '</form>';

			printf( '<div class="add-all-pages" data-token="%s" data-ajaxurl="%s">%s</div>',
				esc_html( dmca_get_login_token() ), esc_html( admin_url( 'admin-ajax.php' ) ), esc_html__( 'Submit all Pages', 'dmca-badge' )
			);

			echo "</div>";
			
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
	 * Column dmca date
	 *
	 * @param WP_Post $item
	 *
	 * @return string
	 */
	public function column_dmca_date( WP_Post $item ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			$human_time_diff = human_time_diff( get_the_time( 'U', $item ), current_time( 'timestamp' ) ) . __( ' ago', 'dmca-badge' );

			ob_start();

			printf( '<span>%s</span>', esc_html( get_the_time( 'F j, Y g:i A', $item ) ) );
			printf( '<div class="row-actions"><span class="timeago-view">%s</span></div>', esc_html($human_time_diff) );

			return ob_get_clean();
			
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
	 * Column protection status
	 *
	 * @param WP_Post $item
	 *
	 * @return string
	 */
	public function column_dmca_status( WP_Post $item ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			return sprintf( '<span class="dmca-status %s">%s</span>', get_dmca_submission_status_raw( $item->ID ), get_dmca_submission_status( $item->ID ) );
			
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
	 * Column Title
	 *
	 * @param WP_Post $item
	 *
	 * @return false|string
	 */
	public function column_title( \WP_Post $item ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			$edit_link = add_query_arg( array( 'post' => $item->ID, 'action' => 'edit' ), admin_url( 'post.php', false ) );

			ob_start();

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
			printf( '<strong><span>%3$s</span> <span class="dashicons dashicons-minus"></span> <a target="_blank" class="row-title" href="%1$s">%2$s</a></strong>',
				esc_url( $edit_link ),
				esc_html( get_the_title( $item->ID ) ),
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal trusted HTML.
				ucfirst( $item->post_type )
			);
			printf( '<div class="row-actions">' );
			printf( '<span class="edit"><a target="_blank" href="%1$s">%2$s</a></span>  | ', esc_html( $edit_link ), esc_html( __( 'Edit', 'dmca-badge' ) ) );
			printf( '<span class="view"><a target="_blank" href="%1$s">%2$s</a></span> | ', esc_html( get_the_permalink( $item->ID ) ), esc_html( __( 'View', 'dmca-badge' ) ) );
			printf( '<span class="add">%s</span>', esc_html( __( 'Submit for Protection', 'dmca-badge' ) ) );
			printf( '</div>' );

			return ob_get_clean();
			
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
	 * Column CB
	 *
	 * @param $item
	 *
	 * @return string|void
	 */
	public function column_check_status( $item ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			return sprintf( '<a target="_blank" href="%s">%s</a>',
				dmca_badge_get_status_url( array( 'refurl' => get_the_permalink( $item->ID ) ) ), esc_html__( 'Test Status', 'dmca-badge' )
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
	 * Column Default
	 *
	 * @param object $item
	 * @param string $column_name
	 *
	 * @return string|void
	 */
	protected function column_default( $item, $column_name ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			return '';
			
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
	 * Return columns for this screen
	 *
	 * @return array
	 */
	public function get_columns() {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {
			return get_column_headers( get_current_screen() );
			
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
	 * Define columns
	 *
	 * @return array
	 */
	public static function define_columns() {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			return array(
				'title'        => __( 'Page Title', 'dmca-badge' ),
				'dmca_status'  => __( 'Submission Status', 'dmca-badge' ),
				'check_status' => __( 'Check Status', 'dmca-badge' ),
				'dmca_date'    => __( 'Published Date', 'dmca-badge' ),
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
	 * Return Post Meta Value
	 *
	 * @param bool $meta_key
	 * @param bool $post_id
	 * @param string $default
	 *
	 * @return mixed|string|void
	 */
	public function get_meta( $meta_key = false, $post_id = false, $default = '' ) {
				
		$error_path = plugin_dir_url(__FILE__) ;
		try {

			if ( ! $meta_key ) {
				return '';
			}

			$post_id    = ! $post_id ? get_the_ID() : $post_id;
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			$meta_value = empty( $meta_value ) ? $default : $meta_value;

			return apply_filters( 'dmca_filters_get_meta', $meta_value, $meta_key, $post_id, $default );
			
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