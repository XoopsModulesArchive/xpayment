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
$module_handler =& xoops_gethandler('module');
$GLOBALS['xpaymentModule'] =& XoopsModule::getByDirname('xpayment');
$moduleInfo =& $module_handler->get($GLOBALS['xpaymentModule']->getVar('mid'));
$GLOBALS['xpaymentImageAdmin'] = $moduleInfo->getInfo('icons32');

global $adminmenu;
$adminmenu=array();
$adminmenu[0]['title'] = _XPY_ADMENU8;
$adminmenu[0]['icon'] = '../../'.$moduleInfo->getInfo('system_icons32').'/home.png';
$adminmenu[0]['image'] = '../../'.$moduleInfo->getInfo('system_icons32').'/home.png';
$adminmenu[0]['link'] = "admin/index.php?op=dashboard";
$adminmenu[1]['title'] = _XPY_ADMENU1;
$adminmenu[1]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.invoices.png';
$adminmenu[1]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.invoices.png';
$adminmenu[1]['link'] = "admin/index.php?op=invoices&fct=list";
$adminmenu[2]['title'] = _XPY_ADMENU2;
$adminmenu[2]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.transactions.png';
$adminmenu[2]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.transactions.png';
$adminmenu[2]['link'] = "admin/index.php?op=transactions&fct=list";
$adminmenu[3]['title'] = _XPY_ADMENU3;
$adminmenu[3]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.gateways.png';
$adminmenu[3]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.gateways.png';
$adminmenu[3]['link'] = "admin/index.php?op=gateways&fct=list";
$adminmenu[4]['title'] = _XPY_ADMENU4;
$adminmenu[4]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.permissions.png';
$adminmenu[4]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.permissions.png';
$adminmenu[4]['link'] = "admin/index.php?op=permissions&fct=email";
$adminmenu[5]['title'] = _XPY_ADMENU5;
$adminmenu[5]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.groups.png';
$adminmenu[5]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.groups.png';
$adminmenu[5]['link'] = "admin/index.php?op=groups&fct=brokers";
$adminmenu[6]['title'] = _XPY_ADMENU6;
$adminmenu[6]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.taxes.png';
$adminmenu[6]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.taxes.png';
$adminmenu[6]['link'] = "admin/index.php?op=tax&fct=list";
$adminmenu[7]['title'] = _XPY_ADMENU7;
$adminmenu[7]['icon'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.discounts.png';
$adminmenu[7]['image'] = '../../'.$GLOBALS['xpaymentImageAdmin'].'/xpayment.discounts.png';
$adminmenu[7]['link'] = "admin/index.php?op=discounts&fct=list";
$adminmenu[8]['title'] = _XPY_ADMENU9;
$adminmenu[8]['icon'] = '../../'.$moduleInfo->getInfo('system_icons32').'/about.png';
$adminmenu[8]['image'] = '../../'.$moduleInfo->getInfo('system_icons32').'/about.png';
$adminmenu[8]['link'] = "admin/index.php?op=about";

?>