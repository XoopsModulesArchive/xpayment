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
	include('../header.php');
	
	$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');

	$criteria = new CriteriaCompo(new Criteria('due', time(), '<'));
	$criteria->add(new Criteria('mode', 'UNPAID'));
	$criteria->add(new Criteria('remittion', "('NONE', 'NOTICE')", 'IN'));
	$invoices = $invoice_handler->getObjects($criteria, true);
	 
	foreach($invoices as $iid => $obj) {
		switch ($obj->getVar('remittion')){
			case "NONE":
				$obj->setVar('remittion', 'NOTICE');
				break;
			case "NOTICE":
				if ($obj->getVar('collect')<time()) {
					$obj->setVar('remittion', 'COLLECT');
					break;
				}
			
		}
		$invoice_handler->insert($obj, true);
	}
	
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$xoMod = $module_handler->getByDirname('xpayment');
	if (is_object($xoMod)) {
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));	
		
		$criteria = new CriteriaCompo(new Criteria('reoccurence', 0, '>'));
		$criteria->add(new Criteria('mode', 'PAID'));
		$criteria->add(new Criteria('occurence', time(), '<'));
		$criteria->add(new Criteria('remittion', "('NONE', 'NOTICE')", 'IN'));
		$invoices = $invoice_handler->getObjects($criteria, true);
		 
		foreach($invoices as $iid => $obj) {
			if (($obj->getVar('reoccurence')>$obj->getVar('reoccurences'))) {
				$obj->setVar('reoccurences', $obj->getVar('reoccurences')+1);
				$obj->setVar('previous', $obj->getVar('occurence'));
				$obj->setVar('occurence', time()+($obj->getVar('reoccurence_period_days')*(60*60*24)));
				$obj->setVar('due', time()+$xoConfig['due']);
				$obj->setVar('collect', time()+$xoConfig['due']+$xoConfig['collect']);
				$obj->setVar('wait', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']);
				$obj->setVar('offline', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']+$xoConfig['offline']);
				$obj->setVar('mode', 'UNPAID');
				$obj->setVar('remittion', 'NONE');
				$obj->setVar('remitted', 0);
				$obj->setVar('paid', '0.00');
				$invoice_handler->insert($obj, true);
			}
		}
		
		$criteria = new CriteriaCompo(new Criteria('reoccurence', -1, '='));
		$criteria->add(new Criteria('mode', 'PAID'));
		$criteria->add(new Criteria('occurence', time(), '<'));
		$criteria->add(new Criteria('remittion', "('NONE', 'NOTICE')", 'IN'));
		$invoices = $invoice_handler->getObjects($criteria, true);
		 
		foreach($invoices as $iid => $obj) {
			$obj->setVar('reoccurences', $obj->getVar('reoccurences')+1);
			$obj->setVar('previous', $obj->getVar('occurence'));
			$obj->setVar('occurence', time()+($obj->getVar('reoccurence_period_days')*(60*60*24)));
			$obj->setVar('due', time()+$xoConfig['due']);
			$obj->setVar('collect', time()+$xoConfig['due']+$xoConfig['collect']);
			$obj->setVar('wait', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']);
			$obj->setVar('offline', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']+$xoConfig['offline']);
			$obj->setVar('mode', 'UNPAID');
			$obj->setVar('remittion', 'NONE');
			$obj->setVar('remitted', 0);
			$obj->setVar('paid', '0.00');
			$invoice_handler->insert($obj, true);
		}
	}
		
	$criteria = new CriteriaCompo(new Criteria('mode', 'UNPAID'));
	$criteria->add(new Criteria('wait', time(), '<'));
	$criteria->add(new Criteria('remittion', "('COLLECT', 'NOTICE', 'SETTLED')", 'IN'));
	$invoices = $invoice_handler->getObjects($criteria, true);
	foreach($invoices as $iid => $obj) {
		$obj->setVar('mode', 'CANCEL');	
		$invoice_handler->insert($obj, true);
	}
	
?>