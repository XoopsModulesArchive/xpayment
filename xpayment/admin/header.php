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
 * @since           2.5.5
 * @author          Simon Roberts <simon@chronolabs.com.au>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 * @version         $Id: permissions.php 11084 2013-02-23 15:44:20Z timgno $
 */
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';

if (!defined('_CHARSET'))
	define ("_CHARSET","UTF-8");
if (!defined('_CHARSET_ISO'))
	define ("_CHARSET_ISO","ISO-8859-1");
	
$GLOBALS['myts'] = MyTextSanitizer::getInstance();

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$GLOBALS['xpaymentModule'] = $module_handler->getByDirname('xpayment');
$GLOBALS['xpaymentModuleConfig'] = $config_handler->getConfigList($GLOBALS['xpaymentModule']->getVar('mid')); 
	
xoops_load('pagenav');	
xoops_load('xoopslists');
xoops_load('xoopsformloader');
xoops_load('xoopsmailer');

//include_once $GLOBALS['xoops']->path('class'.DS.'xoopsmailer.php');
include_once $GLOBALS['xoops']->path('class'.DS.'xoopstree.php');

if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
	include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
	//return true;
}else{
	echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	//return false;
}

$GLOBALS['xpaymentImageIcon'] = XOOPS_URL .'/'. $GLOBALS['xpaymentModule']->getInfo('icons16');
$GLOBALS['xpaymentImageAdmin'] = XOOPS_URL .'/'. $GLOBALS['xpaymentModule']->getInfo('icons32');

$pathIcon16      = '../' . $xoopsModule->getInfo('icons16');
$pathIcon32      = '../' . $xoopsModule->getInfo('icons32');
$pathModuleAdmin = $xoopsModule->getInfo('dirmoduleadmin');

if ($GLOBALS['xoopsUser']) {
	$moduleperm_handler =& xoops_gethandler('groupperm');
	if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['xpaymentModule']->getVar( 'mid' ), $GLOBALS['xoopsUser']->getGroups())) {
		redirect_header(XOOPS_URL, 1, _NOPERM);
		exit();
	}
} else {
	redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
	exit();
}

//
$myts =& MyTextSanitizer::getInstance();
if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}
//
$xoopsTpl->assign('pathIcon16', $pathIcon16);
$xoopsTpl->assign('pathIcon32', $pathIcon32);
// Locad admin menu class
if ( file_exists($GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php'))){
	include_once $GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php');
}else{
	redirect_header("../../../admin.php", 5, _AM_MODULEADMIN_MISSING, false);
}

$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['xpaymentImageIcon']);

include_once $GLOBALS['xoops']->path('/modules/xpayment/include/xpayment.functions.php');
include_once $GLOBALS['xoops']->path('/modules/xpayment/include/xpayment.objects.php');
include_once $GLOBALS['xoops']->path('/modules/xpayment/include/xpayment.forms.php');
xoops_cp_header();
$adminMenu = new ModuleAdmin();	