<?php
/**
 * Plugin Name: WooCommerce_Brandbassador
 * Plugin URI: https://www.brandbassador.com/
 * Description: Plugin integration Brandbassador pixel
 * Author: Brandbassador
 * Author URI: https://www.brandbassador.com/
 * Version: 1.0.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

if ( ! class_exists( 'WC_Integration_Brandbassador' ) ) :

class WC_Integration_Brandbassador {

	/**
	* Construct the plugin.
	*/
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	* Initialize the plugin.
	*/
	public function init() {

		// Checks if WooCommerce is installed.
		if ( class_exists( 'WC_Integration' ) ) {
			// Include our integration class.
			include_once 'includes/class-wc-integration-brandbassador-integration.php';

			// Register the integration.
			add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
		} else {
			// throw an admin error if you like
		}
	}

	/**
	 * Add a new integration to WooCommerce.
	 */
	public function add_integration( $integrations ) {
		$integrations[] = 'WC_Integration_Brandbassador_Integration';
		return $integrations;
	}

}

$WC_Integration_Brandbassador = new WC_Integration_Brandbassador( __FILE__ );

endif;
