<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
define('__GroupUsername__', ossn_route()->com . 'GroupUsername/');
function group_username_init() {
		ossn_extend_view('forms/OssnGroups/edit', 'group_username/js');
		ossn_extend_view('groups/pages/profile', 'group_username/profile');
		
		ossn_register_page('g', function ($pages) {
				if(empty($pages)){
					ossn_error_page();
				}
				$group = ossn_get_group_by_username($pages[0]);
				if($group) {
						redirect("group/{$group->guid}");
				} else {
						ossn_error_page();
				}
		});
		if(ossn_isLoggedin()) {
				ossn_register_callback('action', 'load', function ($c, $t, $p) {
						if($p['action'] == 'group/edit') {
								$group = ossn_get_group_by_guid(input('group'));
								if($group->owner_guid !== ossn_loggedin_user()->guid && !ossn_isAdminLoggedin()) {
										ossn_trigger_message(ossn_print('group:update:fail'), 'error');
										redirect(REF);
								}

								if($group && !isset($group->group_username)) {
										$username = input('group_username');
										if(!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $username)) {
												ossn_trigger_message(ossn_print('groupusername:startswithalphabet'), 'error');
												redirect(REF);
										}
										$exists = ossn_get_group_by_username($username);
										if($exists) {
												ossn_trigger_message(ossn_print('groupusername:username:exists'), 'error');
												redirect(REF);
										}
										if(!$exists) {
												$group->data->group_username = $username;
												$group->save();
										}
								}
						}
				});
		}
}
function ossn_get_group_by_username($username) {
		if(empty($username)){
			return false;
		}
		$group  = new OssnGroup();
		$search = $group->searchObject(array(
				'subtype'        => 'ossngroup',
				'limit'          => 1,
				'page_limit'     => 1,
				'entities_pairs' => array(
						array(
								'name'  => 'group_username',
								'value' => trim($username),
						),
				),
		));
		if($search) {
				return $search[0];
		}
		return false;
}
ossn_register_callback('ossn', 'init', 'group_username_init');