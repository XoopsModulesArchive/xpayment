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

	function xpayment_getFilterElement($filter, $field, $sort='created', $fct = 'invoice') {
		$components = xpayment_getFilterURLComponents($filter, $field, $sort);
		include_once('xpayment.objects.php');
        $ele = '';
		switch ($field) {
		    case 'mode':
				$ele = new XoopsFormSelectInvoiceMode('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'remittion':
				$ele = new XoopsFormSelectInvoiceRemittion('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'invoicenumber':
		    case 'drawfor':
		    case 'drawto':
		    case 'drawto_email':
		    case 'tax':	
		    case 'shipping':
		    case 'handling':
		    case 'amount':
		    case 'grand':
			case 'items':
			case 'weight':
			case 'weight_unit':
			case 'tax':
			case 'currency':
			case 'items':
			case 'transactionid':
			case 'reoccurence':
			case 'reoccurences':
			case 'reoccurence_period_days':
			case 'occurence':
			case 'previous':
			case 'occurence_grand':
			case 'occurence_amount':
			case 'occurence_tax':
			case 'occurence_shipping':
			case 'occurence_handling':
			case 'occurence_weight':
			case 'donation':
			case 'comment':
			case 'user_ip':
			case 'user_netaddy':
			case 'transactionid':
			case 'email':
			case 'code':
			case 'redeems':
			case 'redeemed':
			case 'discount':
			case 'rate':
			case 'interest':
				$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_'.$field.'', 3, 40, $components['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+$(\'#filter_'.$field.'\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;
		}
		return $ele;
	}

	function xpayment_getFilterURLComponents($filter, $field, $sort='created') {
		$parts = explode('|', $filter);
		$ret = array();
		$value = '';
        $ele_value = '';
        $operator = '';
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (count($var)>1) {
	    		if ($var[0]==$field) {
	    			$ele_value = $var[1];
	    			if (isset($var[2]))
	    				$operator = $var[2];
	    		} elseif ($var[0]!=1) {
	    			$ret[] = implode(',', $var);
	    		}
    		}
    	}
    	$pagenav = array();
    	$pagenav['op'] = isset($_REQUEST['op'])?$_REQUEST['op']:"shops";
		$pagenav['fct'] = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
		$pagenav['limit'] = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$pagenav['start'] = 0;
		$pagenav['order'] = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$pagenav['sort'] = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':$sort;
    	$retb = array();
		foreach($pagenav as $key=>$value) {
			$retb[] = "$key=$value";
		}
		return array('value'=>$ele_value, 'field'=>$field, 'operator'=>$operator, 'filter'=>implode('|', $ret), 'extra'=>implode('&', $retb));
	}
	
	function xpayment_install_gateway($class) {
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateways_options_handler =& xoops_getmodulehandler('gateways_options', 'xpayment');

		if ($gateways_handler->getCount(new Criteria('class', $class))==0) {
			include($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'.$class.'/gateway_info.php'));
			
			if (!empty($gateway)) {
				$gateways = $gateways_handler->create();
				$gateways->setVar('name', $gateway['name']);
				$gateways->setVar('testmode', $gateway['testmode']);
				$gateways->setVar('class', $class);
				$gateways->setVar('description', $gateway['description']);
				$gateways->setVar('author', $gateway['author']);
				$gateways->setVar('salt', $gateway['salt']);
				if ($gid = $gateways_handler->insert($gateways)) {
					foreach($gateway['options'] as $refereer => $data) {
						$option = $gateways_options_handler->create();
						$option->setVar('refereer', $refereer);
						$option->setVar('name', $data['name']);
						$option->setVar('value', $data['value']);
						$option->setVar('gid', $gid);
						$gateways_options_handler->insert($option);
					}
					return true;
				} else 
					return false;
			} else 
				return false;
		} else 
			return false;
	}

	function xpayment_update_gateway($class) {
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateways_options_handler =& xoops_getmodulehandler('gateways_options', 'xpayment');

		if ($gateways_handler->getCount(new Criteria('class', $class))==1) {
			include($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'.$class.'/gateway_info.php'));
			
			if (!empty($gateway)) {
				$gatewaysObjs = $gateways_handler->getObjects(new Criteria('class', $class));
				$gateways = $gatewaysObjs[0];
				$gateways->setVar('name', $gateway['name']);
				$gateways->setVar('testmode', $gateway['testmode']);
				$gateways->setVar('class', $class);
				$gateways->setVar('description', $gateway['description']);
				$gateways->setVar('author', $gateway['author']);
				$gateways->setVar('salt', $gateway['salt']);
				if ($gid = $gateways_handler->insert($gateways)) {
					foreach($gateway['options'] as $refereer => $data) {
						$criteria = new CriteriaCompo(new Criteria('gid', $gid));
						$criteria->add(new Criteria('refereer', $refereer));
						if ($gateways_options_handler->getCount($criteria)==0) {
							$option = $gateways_options_handler->create();
							$option->setVar('refereer', $refereer);
							$option->setVar('name', $data['name']);
							$option->setVar('value', $data['value']);
							$option->setVar('gid', $gid);
							$gateways_options_handler->insert($option);
						} else {
							$optionObjs = $gateways_options_handler->getObjects($criteria);
							$option = $optionObjs[0]; 
							$option->setVar('name', $data['name']);
							$gateways_options_handler->insert($option);
						}
					}
					return true;
				} else 
					return false;
			} else 
				return false;
		} else 
			return false;
	}
	
	if (!function_exists("getIPData")) {
		function getIPData($ip=false){
			$ret = array();
			if (is_object($GLOBALS['xoopsUser'])) {
				$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
				$ret['uname'] = $GLOBALS['xoopsUser']->getVar('uname');
			} else {
				$ret['uid'] = 0;
				$ret['uname'] = '';
			}
			if (!$ip) {
				if ($_SERVER["HTTP_X_FORWARDED_FOR"] != ""){ 
					$ip = (string)$_SERVER["HTTP_X_FORWARDED_FOR"]; 
					$ret['is_proxied'] = true;
					$proxy_ip = $_SERVER["REMOTE_ADDR"]; 
					$ret['network-addy'] = @gethostbyaddr($ip); 
					$ret['long'] = @ip2long($ip);
					if (is_ipv6($ip)) {
						$ret['ip6'] = $ip;
						$ret['proxy-ip6'] = $proxy_ip;
					} else {
						$ret['ip4'] = $ip;
						$ret['proxy-ip4'] = $proxy_ip;
					}
				}else{ 
					$ret['is_proxied'] = false;
					$ip = (string)$_SERVER["REMOTE_ADDR"]; 
					$ret['network-addy'] = @gethostbyaddr($ip); 
					$ret['long'] = @ip2long($ip);
					if (is_ipv6($ip)) {
						$ret['ip6'] = $ip;
					} else {
						$ret['ip4'] = $ip;
					}
				} 
			} else {
				$ret['is_proxied'] = false;
				$ret['network-addy'] = @gethostbyaddr($ip); 
				$ret['long'] = @ip2long($ip);
				if (is_ipv6($ip)) {
					$ret['ip6'] = $ip;
				} else {
					$ret['ip4'] = $ip;
				}
			}
			$ret['made'] = time();				
			return $ret;
		}
	}
	
	if (!function_exists("is_ipv6")) {
		function is_ipv6($ip = "") 
		{ 
			if ($ip == "") 
				return false;
				
			if (substr_count($ip,":") > 0){ 
				return true; 
			} else { 
				return false; 
			} 
		} 
	}
?>