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
 * @copyright       Chronolabs Co-Op http://www.chronolabs.com.au/
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
include('header.php');
	
$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
xoops_loadLanguage('admin', 'xpayment');
echo $adminMenu->addNavigation('permissions.php');	

$opform = new XoopsSimpleForm(_XPY_AM_PERM_FCT, 'actionform', 'index.php', "get");
$op_select = new XoopsFormSelect("", 'fct', $_REQUEST['fct']);
$op_select->setExtra('onchange="document.forms.actionform.submit()"');
$op_select->addOptionArray(array(
	"email"=>_XPY_AM_PERM_EMAIL, 
	"gateways"=>_XPY_AM_PERM_GATEWAYS, 
	));
$opform->addElement($op_select);
$opform->addElement(new XoopsFormHidden('op', 'permissions'));
$opform->display();
		

switch ($_REQUEST['op'])
{
	default:
	case "email":
		
		$base=array();
		$base[_XPY_ENUM_MODE_PAID] = _XPY_AM_MODE_DESC_PAID;
		$base[_XPY_ENUM_MODE_UNPAID] = _XPY_AM_MODE_DESC_UNPAID;
		$base[_XPY_ENUM_MODE_CANCEL] = _XPY_AM_MODE_DESC_CANCEL;
		
		$sub=array();
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_PAID_NONE;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_UNPAID_NONE;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_CANCEL_NONE;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_PAID_PENDING;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_UNPAID_PENDING;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_CANCEL_PENDING;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_PAID_NOTICE;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_UNPAID_NOTICE;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_CANCEL_NOTICE;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_PAID_COLLECT;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_UNPAID_COLLECT;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_CANCEL_COLLECT;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_PAID_FRAUD;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_UNPAID_FRAUD;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_CANCEL_FRAUD;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_PAID_SETTLED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_UNPAID_SETTLED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_CANCEL_SETTLED;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_PAID_DISCOUNTED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_UNPAID_DISCOUNTED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_CANCEL_DISCOUNTED;			
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_PAID_ITEM_PURCHASED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_PURCHASED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_PURCHASED;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_PAID_ITEM_REFUNDED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_REFUNDED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_REFUNDED;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_PAID_ITEM_UNDELIVERED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_UNDELIVERED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_UNDELIVERED;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_PAID_ITEM_DAMAGED;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_DAMAGED;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_DAMAGED;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_PAID_ITEM_PENDING;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_UNPAID_ITEM_PENDING;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_CANCEL_ITEM_PENDING;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_PAID_ITEM_EXPRESS;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_UNPAID_ITEM_EXPRESS;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_CANCEL_ITEM_EXPRESS;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_PAYMENT;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PAYMENT;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PAYMENT;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_REFUND;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_REFUND;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_REFUND;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_PENDING;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PENDING;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PENDING;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_NOTICE;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_NOTICE;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_NOTICE;
		$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_OTHER;
		$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_OTHER;
		$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_OTHER;

		
		$perm_title = _XPY_AM_PERM_TITLE_EMAIL;
		$perm_name = _XPY_AM_PERM_NAME_EMAIL;
		$perm_desc = _XPY_AM_PERM_DESC_EMAIL;
		$anonymous = true;
		break;
	case "gateways":
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateways = $gateways_handler->getObjects(NULL, true);
		$base=array();
		foreach($gateways as $gid => $gateway) {
			xoops_loadLanguage($gateway->getVar('class'), 'xpayment');	
			$base[$gid] = (defined($gateway->getVar('name'))?constant($gateway->getVar('name')):$gateway->getVar('name'));
			
		} 
		$perm_title = _XPY_AM_PERM_TITLE_GATEWAY;
		$perm_name = _XPY_AM_PERM_NAME_GATEWAY;
		$perm_desc = _XPY_AM_PERM_DESC_GATEWAY;
		$anonymous = true;
	break;
}
		
$module_handler =& xoops_gethandler('module');
$module = $module_handler->getByDirname('xpayment');
$form = new XpaymentGroupPermForm($perm_title, $module->getVar('mid'), $perm_name, $perm_desc, 'admin/index.php?op=permissions&fct='.$_REQUEST['fct'], $anonymous);

foreach (array_keys($base) as $c) {
	if (isset($sub[$c])&&is_array($sub[$c])) {
		$form->addItem($c, "<strong>".$base[$c]."</strong>");
		foreach(array_keys($sub[$c]) as $f){
			$form->addItem($c+$f, "<em>".$sub[$c][$f]."</em>");
		}
	} else {
		$form->addItem($c, "".$base[$c]."");
	}
}
$form->display();
xoops_cp_footer();