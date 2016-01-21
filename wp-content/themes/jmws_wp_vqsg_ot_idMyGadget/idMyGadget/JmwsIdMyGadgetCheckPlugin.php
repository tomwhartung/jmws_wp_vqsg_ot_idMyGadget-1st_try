<?php
/**
 * Class to contain a generic (theme-independent) check for the module being installed and activated.
 *
 * @package Jmws
 * @subpackage Twenty_Thirteen_idMyGadget
 * @since Twenty Thirteen IdMyGadget 1.0
 */

class JmwsIdMyGadgetCheckPlugin
{
	public function __construct()
	{
	}

	/**
	 * Checks for a valid idMyGadget object; if one is not present:
	 *   Diagnose the problem,
	 *   Create a "no detection" object to keep us from whitescreening, and
	 *   Set an appropriate error message in the object
	 */
	public function checkPlugin()
	{
		global $jmwsIdMyGadget;
		global $all_plugins;
		global $jmws_idMyGadget_for_wordpress_is_installed;
		global $jmws_idMyGadget_for_wordpress_is_active;
		$jmws_idMyGadget_for_wordpress_is_installed= TRUE;
		$jmws_idMyGadget_for_wordpress_is_active = TRUE;
	
		if ( isset($jmwsIdMyGadget) )
		{
			if ( $jmwsIdMyGadget->isInstalled() )
			{
				unset( $jmwsIdMyGadget->errorMessage );
			}
			else
			{
				$linkToReadmeOnGithub =
					'<a href="' . $jmwsIdMyGadget->getLinkToReadme() . '" class="idmygadget-error" target="_blank">' .
					'the appropriate README.md file on github.</a>';
				$jmwsIdMyGadget->errorMessage = IDMYGADGET_DETECTOR_NOT_INSTALLED_OPENING .
				$linkToReadmeOnGithub . IDMYGADGET_DETECTOR_NOT_INSTALLED_CLOSING;
			}
		}
		else
		{
			require_once 'JmwsIdMyGadgetMissingPlugin.php';
			$jmwsIdMyGadget = new JmwsIdMyGadgetMissingPlugin();
			$rootedPluginFileName =  WP_PLUGIN_DIR . '/' . JmwsIdMyGadgetMissingPlugin::IDMYGADGET_PLUGIN_FILE;
			$jmwsIdMyGadget->errorMessage = IDMYGADGET_UNKNOWN_ERROR;
			if ( file_exists($rootedPluginFileName) )  // it's installed but probably not active
			{
				if ( ! function_exists( 'get_plugins' ) )
				{
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				$all_plugins = get_plugins();
				if ( ! is_plugin_active(JmwsIdMyGadgetMissingPlugin::IDMYGADGET_PLUGIN_FILE) )
				{
					$jmws_idMyGadget_for_wordpress_is_active = FALSE;
					$jmwsIdMyGadget->errorMessage = IDMYGADGET_NOT_ACTIVE;
				}
			}
			else
			{
				$jmws_idMyGadget_for_wordpress_is_active = FALSE;
				$jmws_idMyGadget_for_wordpress_is_installed = FALSE;
				$jmwsIdMyGadget->errorMessage = IDMYGADGET_NOT_INSTALLED;
			}
		}
	}

}
