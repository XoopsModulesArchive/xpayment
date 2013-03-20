<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */
function xoops_module_pre_install_xpayment(&$module) {

	xoops_loadLanguage('modinfo', 'xpayment');
	
	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_BROKER);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_BROKER);
		$group->setVar('description', _XPY_MI_GROUP_DESC_BROKER);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_BROKER);
		$groups_handler->insert($group, true);
	}

	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_ACCOUNTS);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_ACCOUNTS);
		$group->setVar('description', _XPY_MI_GROUP_DESC_ACCOUNTS);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_ACCOUNTS);
		$groups_handler->insert($group, true);
	}

	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_OFFICER);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_OFFICER);
		$group->setVar('description', _XPY_MI_GROUP_DESC_OFFICER);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_OFFICER);
		$groups_handler->insert($group, true);
	}
	
	return true;
}
	
function xoops_module_install_xpayment(&$module) {
	
	include_once $GLOBALS['xoops']->path('/modules/xpayment/include/xpayment.functions.php');
	return xpayment_install_gateway('paypal');
}

?>