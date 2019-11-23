<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('TimeZone', ossn_route()->com . 'TimeZone/');
function time_zone_init(){
		ossn_add_hook('user', 'default:fields', 'time_zone_only_loggedin');
		if(ossn_isLoggedin()){
			$user = ossn_loggedin_user();
			if(isset($user->timezone)){
					date_default_timezone_set($user->timezone);	
			}
		}
}
/**
 * Time Zone File
 *
 * @params string $hook Name of hook is user
 * @params string $type Type of hook is signup fields
 * @params array  $fields A list of signup fields
 *
 * @return array
 */
function time_zone_only_loggedin($hook, $type, $fields){
		$component = new OssnComponents();
		if($component->isActive('CustomFields')) {
			$label = true;
			$placeholder = ossn_print('timezone:select');
		} else {
			$label = ossn_print('timezone:select');
			$placeholder = '';
		}
		$zonel = timezone_identifiers_list();
		$zones = array_combine($zonel, $zonel);
		$extrafield = 	array(
			'name' => 'timezone',
			'label' => $label,
			'placeholder' => $placeholder,
			'display_on_about_page' => false,
			'options' => $zones,
		);
		$fields['required']['dropdown'][] = $extrafield;
		return $fields;
}
ossn_register_callback('ossn', 'init', 'time_zone_init');
