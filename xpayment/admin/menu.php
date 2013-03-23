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
$xoopsModule =& XoopsModule::getByDirname('TDMCreate');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon32 = $moduleInfo->getInfo('icons32');
$adminmenu = array();
$adminmenu[0]['title'] = _XPY_ADMENU8;
$adminmenu[0]['icon'] = $pathIcon32.'/home.png';
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[1]['title'] = _XPY_ADMENU1;
$adminmenu[1]['icon'] = 'images/icons/32/xpayment.invoices.png';
$adminmenu[1]['link'] = "admin/invoices.php";
$adminmenu[2]['title'] = _XPY_ADMENU2;
$adminmenu[2]['icon'] = 'images/icons/32/xpayment.transactions.png';
$adminmenu[2]['link'] = "admin/transactions.php";
$adminmenu[3]['title'] = _XPY_ADMENU3;
$adminmenu[3]['icon'] = 'images/icons/32/xpayment.gateways.png';
$adminmenu[3]['link'] = "admin/gateways.php";
$adminmenu[4]['title'] = _XPY_ADMENU4;
$adminmenu[4]['icon'] = 'images/icons/32/xpayment.permissions.png';
$adminmenu[4]['link'] = "admin/permissions.php";
$adminmenu[5]['title'] = _XPY_ADMENU5;
$adminmenu[5]['icon'] = 'images/icons/32/xpayment.groups.png';
$adminmenu[5]['link'] = "admin/groups.php";
$adminmenu[6]['title'] = _XPY_ADMENU6;
$adminmenu[6]['icon'] = 'images/icons/32/xpayment.taxes.png';
$adminmenu[6]['link'] = "admin/tax.php";
$adminmenu[7]['title'] = _XPY_ADMENU7;
$adminmenu[7]['icon'] = 'images/icons/32/xpayment.discounts.png';
$adminmenu[7]['link'] = "admin/discounts.php";
$adminmenu[8]['title'] = _XPY_ADMENU9;
$adminmenu[8]['icon'] = $pathIcon32.'/about.png';
$adminmenu[8]['link'] = "admin/about.php";