<?php
/**
 * WPBlocks settings page.
 *
 * @package    WPBlocks
 * @author     Hristina Zlateska
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018
*/
class WPBlocks_Settings {

	/**
	 * WPBlocks Settings
	 *
	 * @since 1.0.0
	 */
	var $settings;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Add settings to menu
		add_action( 'admin_menu', array( $this, 'register_menus' ) );

		// Add settings to menu
		add_action( 'init', array( $this, 'initialize_settings' ), 10 );
		add_action( 'init', array( $this, 'update_settings' ), 5 );
	}

	/**
	 * Register settings submenu.
	 *
	 * @since 1.0.0
	 */
	public function register_menus() {

		// Settings
		add_options_page(
			__( 'WPBlocks Settings', 'wpblocks' ),
			__( 'WPBlocks', 'wpblocks' ),
			apply_filters( 'wpblocks_manage_cap', 'manage_options' ),
			'wpblocks-settings',
			array( $this, 'render' )
		);
	}

	/**
	 * Settings array with descriptions, defaults etc.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function settings_config() {

		$settings = array(
			'wpblocks-infobox'	=> array(
				'id'		=> 'wpblocks-infobox',
				'type'		=> 'checkbox',
				'default'	=> true,
				'name'		=> __( 'Info Box', 'wpblocks' ),
				'desc'		=> __( 'Enable Info Box block', 'wpblocks' )
			),
			'wpblocks-empty-space'	=> array(
				'id'		=> 'wpblocks-empty-space',
				'type'		=> 'checkbox',
				'default'	=> true,
				'name'		=> __( 'Empty Space', 'wpblocks' ),
				'desc'		=> __( 'Enable Empty Space block', 'wpblocks' )
			),
			'wpblocks-social-icons'	=> array(
				'id'		=> 'wpblocks-social-icons',
				'type'		=> 'checkbox',
				'default'	=> true,
				'name'		=> __( 'Social Icons', 'wpblocks' ),
				'desc'		=> __( 'Enable Social Icons block', 'wpblocks' )
			),
		);

		$settings = apply_filters( 'wpblocks_settings_config', $settings );

		return $settings;
	}

	/**
	 * Initialize the settings array to default values if the settings do not exist in the database
	 *
	 * @since 1.0.0
	 * @param array $settings
	 */
	public function initialize_settings() {

		$config = $this->settings_config();

		// Stop if settings are not defined
		if ( ! is_array( $config ) ) {
			return;
		}

		$this->settings = $this->get_settings( new ArrayIterator( $config ) );

		update_option( WPBLOCKS_SETTINGS, $this->settings );
	}

	/**
	 * Update Settings
	 *
	 * @since 1.0.0
	 * @param array $settings
	 */
	public function update_settings() {

		if ( ! isset( $_POST['wpblocks_page'] ) || 'update_settings' !== $_POST['wpblocks_page'] ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'wpblocks-settings' ) ) {
			return;
		}

		if ( ! current_user_can( apply_filters( 'wpblocks_manage_cap', 'manage_options' ) ) ) {
			return;
		}

		$saved 	= get_option( WPBLOCKS_SETTINGS );
		$config = $this->settings_config();

		unset( $_POST['_wpnonce'], $_POST['wpblocks_page'], $_POST['_wp_http_referer'], $_POST['submit'] );

		if ( is_array( $config ) && ! empty( $config ) ) {
			foreach ( $config as $setting ) {

				if ( ! isset( $setting['default'] ) ) {
					$setting['default'] = '';
				}

				if ( isset( $saved[ $setting['id'] ] ) ) {
					$setting['default'] = $saved[ $setting['id'] ];
				}

				if ( 'checkbox' === $setting['type'] ) {
					$saved[ $setting['id'] ] = isset( $_POST[ $setting['id'] ] ) ? true : false;
				} else {
					$saved[ $setting['id'] ] = isset( $_POST[ $setting['id'] ] ) ? sanitize_text_field( $_POST[ $setting['id'] ] ) : $setting['default'];
				}
			}
		}

		update_option( WPBLOCKS_SETTINGS, $saved );
	}

	/**
	 * Generate array of settings with default values.
	 *
	 * @since 1.0.0
	 * @param ArrayIterator $iterator
	 */
	public function get_settings( $iterator ) {

		$result = array();

		$saved = get_option( WPBLOCKS_SETTINGS );
		$saved = $saved ? $saved : array();

		while ( $iterator->valid() ) {

			$current = $iterator->current();

			if ( isset( $current['type'] ) ) {

				$current['default'] = isset( $current['default'] ) ? $current['default'] : '';

				$result[ $current['id'] ] = isset( $saved[ $current['id'] ] ) ? $saved[ $current['id'] ] : $current['default'];
			}

			$iterator->next();
		}

		return $result;
	}

	/**
	 * Render Settings Page
	 *
	 * @since 1.0.0
	 */
	public function render() {

		$output 	= '';
		$settings 	= $this->settings_config();

		$output .= '<div class="wrap">';
		$output .= '<h1>' . __( 'WPBlocks Settings', 'wpblocks' ) . '</h1>';
		$output .= '<p class="wpblock-page-description">' . __( 'WPBlocks adds additional blocks to the WordPress Gutenberg editor.<br/>Here you can manage which blocks are added:', 'wpblocks' ) . '<p>';

		$output .= '<form method="post" action="' . add_query_arg( array( 'page' => 'wpblocks-settings' ), admin_url( 'options-general.php' ) ) . '">';

		$output .= '<input type="hidden" name="wpblocks_page" value="update_settings">';

		$output .= wp_nonce_field( 'wpblocks-settings', '_wpnonce', true, false );

		if ( is_array( $settings ) && ! empty( $settings ) ) {

			$output .= '<table class="form-table" style="margin-top:20px">';

			foreach ( $settings as $setting ) {

				// Field ID and Type are required
				if ( ! isset( $setting['id'] ) || ! isset( $setting['type'] ) ) {
					continue;
				}

				$setting = $this->sanitize_field_data( $setting );
				$output .= $this->render_field( $setting );
			}

			$output .= '</table>';
		}

		$output .= '<input type="submit" name="submit" id="submit" class="button button-primary" style="margin-top:20px" value="' . __( 'Save Changes', 'wpblocks' ) . '">';

		$output .= '</form>';
		$output .= '</div>';

		echo $output;
	}

	/**
	 * Field Wrapper
	 *
	 * @since 1.0.0
	 */
	private function field_wrapper( $field ) {

		return $field;
	}

	/**
	 * Generate Field HTML Markup
	 *
	 * @since 1.0.0
	 */
	private function render_field( $field ) {

		if ( ! isset( $field['type'] ) ) {
			return;
		}

		if ( ! method_exists( $this, 'render_field_' . $field['type'] ) ) {
			return;
		}

		$output = call_user_func( array( $this, 'render_field_' . $field['type'] ), $field );
		$output = $this->field_wrapper( $output );

		return $output;
	}

	/**
	 * Checkbox field markup
	 *
	 * @since 1.0.0
	 */
	private function render_field_checkbox( $field ) { 
		
		ob_start();
		?>
		<tr>
			<th scope="row" style="padding: 0"><?php echo $field['name']; ?></th>
			<td style="padding: 0">
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $field['name']; ?></span></legend>
					<label for="<?php echo $field['id']; ?>">
						<input name="<?php echo $field['id']; ?>" type="checkbox" id="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" <?php checked( true, $field['value'], true ); ?>>
						<?php echo $field['desc']; ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * Sanitize field, make sure that every field has correct data.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function sanitize_field_data( $field ) {

		$defaults = array(
			'default'	=> '',
			'name'		=> '',
			'desc'		=> '',
		);

		$field = wp_parse_args( $field, $defaults );

		$field['value'] = isset( $this->settings[ $field['id'] ] ) ? $this->settings[ $field['id'] ] : $field['default'];

		return wp_parse_args( $field, $defaults );
	}
}
new WPBlocks_Settings;