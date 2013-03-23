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
echo $adminMenu->addNavigation('tax.php');	
switch($_REQUEST['op']) 
{
	case "list":
	default:		
		$autotax_handler =& xoops_getmodulehandler('autotax', 'xpayment');
		
		$ttl = $autotax_handler->getCount(NULL);
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'ASC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'country';
					

		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
				
		$criteria = new Criteria('1','1');
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);
		
		$rates = $autotax_handler->getObjects($criteria, true);
		
		foreach($rates as $id => $rate) {
			$GLOBALS['xoopsTpl']->append('rates', $rate->toArray());
		}		
		
		
		foreach (array(	'country','code','rate') as $id => $key) {
				$GLOBALS['xoopsTpl']->assign($key.'_th', '<a href="'.$_SERVER['PHP_SELF'].'?'.'start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
		}
		
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_tax_list.html');
		break;
	case 'save':
		$autotax_handler =& xoops_getmodulehandler('autotax', 'xpayment');
		foreach($_POST['id'] as $key=>$id) {
			$tax = $autotax_handler->get($id);
			$tax->setVars($_POST[$id]);
			$autotax_handler->insert($tax, true);
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=tax&fct=list', 3, _XPY_MSG_TAX_SAVED);
		exit(0);
	break;
}
xoops_cp_footer();