<?php
/**
 * Functions and other WP code that helps make this theme what it is and do what it does.
 * Adding code to support device detction
 *
 * @author Tom W. Hartung, using the Visual Quick Start Guide's "our-theme" as a starting point
 * @package jmws_wp_vqsg_fs_idMyGadget
 * @since 1.0
 */
add_action( 'widgets_init', 'my_sidebar' );

function my_sidebar() {

/* Register the 'primary' sidebar */
	register_sidebar(
		array(
			'id' => 'primary',
			'name' => __( 'Primary' ),
			'description' => __( 'This is the primary sidebar.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

}

//
// ---------------------------------------------------
// Begin changes added for integration with IdMyGadget
// ---------------------------------------------------
//
/**
 * Add in the scripts and stylesheets we need for integration with IdMyGadget
 */
function enqueue_idmygadget_css()
{
	$css_file = get_template_directory_uri() . "/idMyGadget/idMyGadget.css";
	wp_enqueue_style( 'idMyGadget-css', $css_file );
}

add_action( 'wp_enqueue_scripts', 'enqueue_idmygadget_css' );

/**
 * Checks for a valid idMyGadget object; if one is not present:
 *   Diagnose the problem,
 *   Create a "no detection" object to keep us from whitescreening, and
 *   Set an appropriate error message in the object
 */
function check_idMyGadget_install()
{
	require_once 'idMyGadget/JmwsIdMyGadgetCheckPlugin.php';
	$jmwsIdMyGadgetCheckPlugin = new JmwsIdMyGadgetCheckPlugin();
	$jmwsIdMyGadgetCheckPlugin->checkPlugin();
}

/**
 * Use the $logoTitleDescription to generate the html for the header
 */
function getHeaderHtml()
{
	global $jmwsIdMyGadget;
	$logoTitleDescription = '';

	if ( $jmwsIdMyGadget->isInstalled() )
	{
		$logoTitleDescription = $jmwsIdMyGadget->getLogoTitleDescriptionHtml();
	}
	else
	{
		$logoTitleDescription = getLogoTitleDescriptionHtml();
	}

	$headerHtml  = '';
	$headerHtml  .= '<header id="header" ' . $jmwsIdMyGadget->jqmDataRole['header'] . ' ';
	$headerHtml  .= $jmwsIdMyGadget->jqmDataThemeAttribute . '>';
	$headerHtml  .= $logoTitleDescription;
	$headerHtml  .= '</header> <!-- #header -->';
	return $headerHtml;
}
/**
 * If the idMyGadget module is not available we will use this,
 * which is the original code downloaded in Sept. 2015
 */
function getLogoTitleDescriptionHtml()
{
	$logoTitleDescription = '<h1>' .
			'<a href="' . esc_url( home_url('/') ) . '" ' .
			'title="' . esc_attr( get_bloginfo('name','display') ) . '" ' .
			'rel="home">' . $site_name . '</a></h1>';
	$logoTitleDescription .= '<h4>' . get_bloginfo('description') . '</h4>';
	return $logoTitleDescription;
}
