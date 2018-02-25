<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

function vc_page_settings_render() {
	$page = vc_get_param( 'page' );
	do_action( 'vc_page_settings_render-' . $page );
	vc_settings()->renderTab( $page );
}

function vc_page_settings_build() {
	if ( ! vc_user_access()->wpAny( 'manage_options' )->get() ) {
		return;
	}
	$tabs = vc_settings()->getTabs();
	foreach ( $tabs as $slug => $title ) {
		if ( vc_user_access()
			->part( 'settings' )
			->can( $slug . '-tab' )
			->get()
		) {
			$page = add_submenu_page( VC_PAGE_MAIN_SLUG, $title, $title, 'manage_options', $slug, 'vc_page_settings_render' );
			add_action( 'load-' . $page, array(
				vc_settings(),
				'adminLoad',
			) );
		}
	}
	do_action( 'vc_page_settings_build' );
}

function vc_page_settings_admin_init() {
	vc_settings()->initAdmin(); // @todo fix_roles, this actions is needed for simple user, but inside have extra hooks that should be checked
}

add_action( 'vc_menu_page_build', 'vc_page_settings_build' );
add_action( 'vc_network_menu_page_build', 'vc_page_settings_build' );
add_action( 'admin_init', 'vc_page_settings_admin_init' );
add_action( 'vc_page_settings_build', 'vc_settings_enqueue_js' );

function vc_settings_enqueue_js() {
	wp_enqueue_script( 'vc_accordion_script' );
}


