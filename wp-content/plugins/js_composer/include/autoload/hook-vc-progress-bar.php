<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Progress_Bar' );

add_filter( 'vc_edit_form_fields_attributes_vc_progress_bar', array(
	'WPBakeryShortCode_VC_Progress_Bar',
	'convertAttributesToNewProgressBar',
) );
