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



if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

require_once('ip2locationlite.class.php');

/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class XpaymentInvoice extends XoopsObject
{

	var $_invoice_h = '';
	var $_discounts_h = '';
	var $_gateway_h = '';
	var $_gateway = '';
	
    function XpaymentInvoice($id = null)
    {
        $this->initVar('iid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mode', XOBJ_DTYPE_ENUM, 'UNPAID', false, false, false, array('PAID', 'CANCEL', 'UNPAID'));
		$this->initVar('plugin', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('return', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('cancel', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('ipn', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('invoicenumber', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('drawfor', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('drawto', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('drawto_email', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('paid', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('amount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('grand', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('shipping', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('handling', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('weight', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('weight_unit', XOBJ_DTYPE_ENUM, null, false, false, false, array('lbs', 'kgs'));
		$this->initVar('tax', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('discount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('discount_amount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('currency', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('items', XOBJ_DTYPE_DECIMAL, 0, false);
		$this->initVar('key', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('transactionid', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('gateway', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('plugin', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('reoccurrence', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('reoccurrence_period_days', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('reoccurrences', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('occurrence', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('previous', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('occurrence_grand', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('occurrence_amount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('occurrence_tax', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('occurrence_shipping', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('occurrence_handling', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('occurrence_weight', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('remittion', XOBJ_DTYPE_ENUM, 'NONE', false, false, false, array('NONE','PENDING','NOTICE','COLLECT','FRAUD','SETTLED','DISCOUNTED'));
		$this->initVar('remittion_settled', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('donation', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('comment', XOBJ_DTYPE_TXTBOX, null, false, 5000);
		$this->initVar('user_ip', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_netaddy', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('user_uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('user_uids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('accounts_uids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('officer_uids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('remitted', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('due', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('collect', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('wait', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('offline', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('user_ipdb_country_code', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('user_ipdb_country_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_region_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_city_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_postcode', XOBJ_DTYPE_TXTBOX, null, false, 15);
		$this->initVar('user_ipdb_latitude', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('user_ipdb_longitude', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('user_ipdb_time_zone', XOBJ_DTYPE_TXTBOX, null, false, 6);
		$this->initVar('fraud_ipdb_errors', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_warnings', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_messages', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_districtcity', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipcountrycode', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('fraud_ipdb_ipcountry', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipregioncode', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('fraud_ipdb_ipregion', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipcity', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_score', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('fraud_ipdb_accuracyscore', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('fraud_ipdb_scoredetails', XOBJ_DTYPE_OTHER, null, false);
  		$this->initVar('topayment', XOBJ_DTYPE_INT, 0, false);
  		$this->initVar('annum', XOBJ_DTYPE_INT, 0, false);
  		$this->initVar('interest', XOBJ_DTYPE_DECIMAL, 0, false);
  		$this->initVar('rate', XOBJ_DTYPE_INT, $GLOBALS['xpaymentModuleConfig']['interest_rate'], false);
  		
    	$this->_gateway_h =& xoops_getmodulehandler('gateways', 'xpayment');
    	$this->_discounts_h =& xoops_getmodulehandler('discounts', 'xpayment');
    	$this->_invoice_h =& xoops_getmodulehandler('invoice', 'xpayment');
    }
	
    function sendDiscountCode($email, $validtill, $redeems, $discount, $prefix) {
    	return $this->_discounts_h->sendDiscountCode($email, $validtill, $redeems, $discount, $prefix);
    }
    
    function applyDiscountCode($code='') {
    	$discount = $this->_discounts_h->getByCode($code);
    	if (is_object($discount)) {
    		if ($discount->getVar('redeems')>$discount->getVar('redeemed')) {
    			if (!in_array($this->getVar('iid'), $discount->getVar('iids'))) {
	    			$discount->setVar('redeemed', $discount->getVar('redeemed')+1);
	    			$discount->setVar('iids', array_merge($discount->getVar('iids'), array($this->getVar('iid')=>$this->getVar('iid'))));
	    			$this->_discounts_h->insert($discount, true);
	    			$this->setVar('did', $discount->getVar('did'));
	    			$this->setVar('discount', $discount->getVar('discount'));
	    			@$this->_invoice_h->insert($this, true);
	    			$invoice_items_handler = xoops_getmodulehandler('invoice_items', 'xpayment');
	    			$totals = $invoice_items_handler->getDiscount($this);
	    			$this->setVar('shipping', $totals['shipping']);
					$this->setVar('handling', $totals['handling']);
					$this->setVar('tax', $totals['tax']);
					$this->setVar('amount', $totals['amount']);
					$this->setVar('grand', $totals['grand']);
					$this->setVar('discount_amount', $totals['discount_grand']);
					$this->setVar('remittion', 'DISCOUNTED');
					@$this->_invoice_h->insert($this, true);
					return true;
    			} else {
	    			return false;
	    		}		
    		} else {
    			return false;
    		}
    	}
    	return false;
    }
    
	function toArray() {
		$ret = array();
		foreach(parent::toArray() as $field => $value) {
			if ($this->vars[$field]['data_type']==XOBJ_DTYPE_DECIMAL) {
				if ($field=='weight')
					$ret[$field] = number_format($value, 4);
				else 
					$ret[$field] = number_format($value, 2);
			} else {
				$ret[$field] = $value;
			}
		}
		$ret['invurl'] = $this->getURL();
		$ret['pdfurl'] = $this->getPDFURL();
		$ret['created_datetime'] = date(_DATESTRING, $this->getVar('created'));
		$ret['updated_datetime'] = date(_DATESTRING, $this->getVar('updated'));
		$ret['actioned_datetime'] = date(_DATESTRING, $this->getVar('actioned'));
		$ret['occurance_datetime'] = date(_DATESTRING, $this->getVar('occurance'));
		$ret['previous_datetime'] = date(_DATESTRING, $this->getVar('previous'));
		$ret['remitted_datetime'] = date(_DATESTRING, $this->getVar('remitted'));
		$ret['due_datetime'] = date(_DATESTRING, $this->getVar('due'));
		$ret['collect_datetime'] = date(_DATESTRING, $this->getVar('collect'));
		$ret['wait_datetime'] = date(_DATESTRING, $this->getVar('wait'));
		$ret['offline_datetime'] = date(_DATESTRING, $this->getVar('offline'));
		$ret['annum_datetime'] = date(_DATESTRING, $this->getVar('annum'));
		foreach($this->getOccurencesPaidArray() as $field => $value) {
			if (is_numeric($value))
				$ret['occurrence_paid'][$field] = number_format($value, 2);
			else 
			 	$ret['occurrence_paid'][$field] = $value;
		}
		foreach($this->getOccurencesLeftArray() as $field => $value) {
			if (is_numeric($value))
				$ret['occurrence_left'][$field] = number_format($value, 2);
			else 
			 	$ret['occurrence_left'][$field] = $value;
		}
		foreach($this->getOccurencesTotalsArray() as $field => $value) {
			if (is_numeric($value))
				$ret['occurrence_totals'][$field] = number_format($value, 2);
			else 
			 	$ret['occurrence_totals'][$field] = $value;
		}
		$ret['donation'] = ($ret['donation']==true?_YES:_NO);
		
		$ret['url'] = $this->getURL();
		$ret['pdfurl'] = $this->getPDFURL();
		
		return $ret;
	}
	
	function getURL() {
		$module_handler = xoops_gethandler('module');
        $config_handler = xoops_gethandler('config');
        $xoModule = $module_handler->getByDirname('xpayment');
        $xoConfig = $config_handler->getConfigList($xoModule->getVar('mid')); 
        if ($xoConfig['id_protect']==true)
            $scape = md5($this->getVar('iid').XOOPS_LICENSE_KEY);
        else 
            $scape = $this->getVar('iid');
        
        if ($xoConfig['htaccess']==true)
            return XOOPS_URL.'/'.$xoConfig['baseurl'].'/'.$scape.$xoConfig['endofurl'];
        else
            return XOOPS_URL.'/modules/xpayment/?iid='.$scape;
    }
    
    function getPDFURL() {
        $module_handler = xoops_gethandler('module');
        $config_handler = xoops_gethandler('config');
        $xoModule = $module_handler->getByDirname('xpayment');
        $xoConfig = $config_handler->getConfigList($xoModule->getVar('mid')); 
                
        if ($xoConfig['id_protect']==true)
            $scape = md5($this->getVar('iid').XOOPS_LICENSE_KEY);
        else 
            $scape = $this->getVar('iid');
        
        if ($xoConfig['htaccess']==true)
            return XOOPS_URL.'/'.$xoConfig['baseurl'].'/pdf,'.$scape.$xoConfig['endofurl_pdf'];
        else        
            return XOOPS_URL.'/modules/xpayment/pdf.php?iid='.$scape;
    }
	
	function setGateway($gateway) {
		if (is_a($gateway, 'XpaymentGateways')) {
			$this->_gateway = $gateway; 
		} elseif (strlen($this->getVar('gateway'))==0) {
			$this->_gateway = $this->_gateway_h->getGateway($GLOBALS['xoopsModuleConfig']['gateway'], $this);
		} else {
			$this->_gateway = $this->_gateway_h->getGateway($this->getVar('gateway'), $this);
		}
		$this->setVar('gateway', $this->_gateway->getVar('class'));
		$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
		return $invoice_handler->insert($this, true);
	}

	function getPaymentHtml()
	{
		if (is_a($this->_gateway, 'XpaymentGateways'))
			return $this->_gateway->getPaymentHTML();
	}
	
	function getAdminPaymentHtml() {
		return xpayment_adminpayment($this);	
	}

	function getAdminSettleHtml() {
		return xpayment_adminsettle($this);	
	}
	function runPlugin($iid=0) {
		
		include_once($GLOBALS['xoops']->path('/modules/xpayment/plugin/'.$this->getVar('plugin').'.php'));
		
		switch ($this->getVar('mode')) {
			case 'PAID':
			case 'CANCEL';
			case 'UNPAID':
				$func = ucfirst($this->getVar('mode')).ucfirst($this->getVar('plugin')).'Hook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			@$func($this, $iid);
		}
		return true;
	}
	
	function runRemittencePlugin($iid=0) {
		
		include_once($GLOBALS['xoops']->path('/modules/xpayment/plugin/'.$this->getVar('plugin').'.php'));
	
		switch ($this->getVar('mode')) {
			case 'PAID':
			case 'CANCEL';
			case 'UNPAID':
				switch ($this->getVar('remittion')) {
					case 'DISCOUNTED':
					case 'NONE':
					case 'PENDING';
					case 'NOTICE';
					case 'COLLECT':
					case 'FRAUD';
					case 'SETTLED':											
						$func = ucfirst($this->getVar('remittion')).ucfirst($this->getVar('mode')).ucfirst($this->getVar('plugin')).'Hook';
						break;
					default:
						return false;
						break;						
				}
			default:
				return false;
				break;
		}
				
		if (function_exists($func))  {
			@$func($this, $iid);
		}
		return true;
	}	

	function getOccurencesPaidGrand(){
		return $this->getVar('occurrence_grand');
	}

	function getOccurencesPaidAmount(){
		return $this->getVar('occurrence_amount');
	}
	
	function getOccurencesPaidShipping(){
		return $this->getVar('occurrence_shipping');
	}
	
	function getOccurencesPaidHandling(){
		return $this->getVar('occurrence_handling');
	}
	
	function getOccurencesPaidTax(){
		return $this->getVar('occurrence_tax');
	}	

	function getOccurencesPaidWeight(){
		return $this->getVar('weight')*$this->getVar('reoccurances');
	}
	
	function getOccurencesPaidArray() {
		return array (	'amount'		=>			$this->getOccurencesPaidAmount(),
						'handling'		=>			$this->getOccurencesPaidHandling(),
						'weight'		=>			$this->getOccurencesPaidWeight(),
						'shipping'		=>			$this->getOccurencesPaidShipping(),
						'tax'		=>				$this->getOccurencesPaidTax(),
						'grand'		=>				$this->getOccurencesPaidTax()+$this->getOccurencesPaidShipping()+$this->getOccurencesPaidHandling()+$this->getOccurencesPaidAmount());
	}
	
	function getOccurencesLeftGrand(){
		return $this->getOccurencesTotalGrand()-$this->getOccurencesPaidGrand();
	}

	function getOccurencesLeftAmount(){
		return $this->getOccurencesTotalAmount()-$this->getOccurencesPaidAmount();
	}
	
	function getOccurencesLeftShipping(){
		return $this->getOccurencesTotalShipping()-$this->getOccurencesPaidShipping();
	}
	
	function getOccurencesLeftHandling(){
		return $this->getOccurencesTotalHandling()-$this->getOccurencesPaidHandling();
	}
	
	function getOccurencesLeftTax(){
		return $this->getOccurencesTotalTax()-$this->getOccurencesPaidTax();
	}	

	function getOccurencesLeftWeight(){
		return $this->getOccurencesTotalWeight()-$this->getOccurencesPaidWeight();
	}
	
	function getOccurencesLeftArray() {
		return array (	'amount'		=>			$this->getOccurencesLeftAmount(),
						'handling'		=>			$this->getOccurencesLeftHandling(),
						'weight'		=>			$this->getOccurencesLeftWeight(),
						'shipping'		=>			$this->getOccurencesLeftShipping(),
						'tax'			=>			$this->getOccurencesLeftTax(),
						'grand'			=>			$this->getOccurencesLeftTax()+$this->getOccurencesLeftShipping()+$this->getOccurencesLeftHandling()+$this->getOccurencesLeftAmount());
	}
	
	function getOccurencesTotalInterest(){
		return ($this->getVar('interest'));
	}
	
	function getOccurencesTotalGrand(){
		return ($this->getVar('reoccurance')*$this->getVar('grand'));
	}

	function getOccurencesTotalAmount(){
		return ($this->getVar('reoccurance')*$this->getVar('amount'));
	}
	
	function getOccurencesTotalShipping(){
		return ($this->getVar('reoccurance')*$this->getVar('shipping'));
	}
	
	function getOccurencesTotalHandling(){
		return ($this->getVar('reoccurance')*$this->getVar('handling'));
	}

	function getOccurencesTotalWeight(){
		return ($this->getVar('reoccurance')*$this->getVar('weight'));
	}
	
	function getOccurencesTotalTax(){
		return ($this->getVar('reoccurance')*$this->getVar('tax'));
	}
	
	function getOccurencesTotalsArray() {
		return array (	'amount'		=>			$this->getOccurencesTotalAmount(),
						'handling'		=>			$this->getOccurencesTotalHandling(),
						'weight'		=>			$this->getOccurencesTotalWeight(),
						'shipping'		=>			$this->getOccurencesTotalShipping(),
						'tax'		=>				$this->getOccurencesTotalTax(),
						'grand'		=>				$this->getOccurencesTotalTax()+$this->getOccurencesTotalShipping()+$this->getOccurencesTotalHandling()+$this->getOccurencesTotalAmount()+$this->getOccurencesTotalInterest());
	}
		
}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XpaymentInvoiceHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'xpayment_invoice', 'XpaymentInvoice', "iid", "name");
    }
	
	function get($iid = 0) {
		$gateways_handler  =& xoops_getmodulehandler('gateways', 'xpayment');
		if (isset($iid)&&$GLOBALS['xoopsModuleConfig']['id_protect']==false||is_numeric($iid)) {
			$obj = parent::get($iid);
		} else {
			$criteria = new Criteria('offline', time(), '>=');
			$criteria->setSort('iid');
			$criteria->setOrder('DESC');
			$count = $this->getCount($criteria);
			$invoices = $this->getObjects($criteria, true);
			foreach($invoices as $iiid => $inv) {
				if ($iid==md5($iiid.XOOPS_LICENSE_KEY)) {
					$obj = $inv;
				}
			}
		}
		if (is_object($obj)) {
			$criteria = new Criteria('class', $obj->getVar('gateway'));
			$gateways = $gateways_handler->getObjects($criteria);
			if (is_a($gateways[0], 'XpaymentGateways')) {
				$gateways[0]->loadGateway($obj);
				$obj->setGateway($gateways[0]);
			} 
		}
		while ($obj->getVar('annum')<time()&&$obj->getVar('mode')=='UNPAID') {
			$obj->setVar('annum', $obj->getVar('annum')+$GLOBALS['xpaymentModuleConfig']['annum']);
			$obj->setVar('interest', $obj->getVar('interest')+((($obj->getVar('interest')+$obj->getVar('grand'))*($obj->getVar('rate')/100))));
			$obj->setVar('grand', $obj->getVar('grand')+((($obj->getVar('interest')+$obj->getVar('grand'))*($obj->getVar('rate')/100))));
			$this->insert($obj);
		}
		return $obj;
	}
	
    function insert($obj, $force = true) {
    	$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xpMod = $module_handler->getByDirname('xpayment');
		$xoConfig = $config_handler->getConfigList($xpMod->getVar('mid'));
        $run_plugin='';
        $run_plugin_remittence='';
		
		if ($obj->isNew()) {
			$obj->setVar('created', time());
			$obj->setVar('annum', time()+$GLOBALS['xpaymentModuleConfig']['annum']);
			$obj->setVar('occurrence', time()+($obj->getVar('reoccurrence_period_days')*(60*60*24)));
			$obj->setVar('reoccurrences', 0);
			$obj->setVar('previous', time());
			$obj->setVar('due', time()+$xoConfig['due']);
			$obj->setVar('collect', time()+$xoConfig['due']+$xoConfig['collect']);
			$obj->setVar('wait', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']);
			$obj->setVar('offline', time()+$xoConfig['due']+$xoConfig['collect']+$xoConfig['wait']+$xoConfig['offline']);
		} else {
			$obj->setVar('updated', time());
		}
		
    	if ($obj->vars['user_ip']['changed']==true) {	
    		if (strlen($xoConfig['ipdb_apikey'])>0) {
    			set_time_limit(120);
	    		$ipLite = new ip2location_lite;
				$ipLite->setKey($xoConfig['ipdb_apikey']);
	 			//Get errors and locations
				$locations = $ipLite->getCity($obj->getVar('user_ip'));
	    		$obj->setVar('user_ipdb_country_code', strtoupper($locations['countryCode']));
	    		$obj->setVar('user_ipdb_country_name', ucfirst($locations['countryName']));
	    		$obj->setVar('user_ipdb_region_name', ucfirst($locations['regionName']));
	    		$obj->setVar('user_ipdb_city_name', ucfirst($locations['cityName']));
	    		$obj->setVar('user_ipdb_postcode', $locations['zipCode']);
	    		$obj->setVar('user_ipdb_latitude', $locations['latitude']);
	    		$obj->setVar('user_ipdb_longitude', $locations['longitude']);
	    		$obj->setVar('user_ipdb_time_zone', $locations['timeZone']);
	    		
	    		try {
		    		$mail = explode('@', $obj->getVar('drawto_email'));
		    		$fraud = fraudQuery($obj->getVar('user_ip'), $xoConfig['countrycode'], $xoConfig['district'], $xoConfig['city'], '', $mail[1], $xoConfig['ipdb_apikey']);
		    		$obj->setVars($fraud);
		    		
		    		if (floor($fraud['fraud_ipdb_score']/$fraud['fraud_ipdb_accuracyscore']*100)<$xoConfig['ipdb_fraud_knockoff']) {
		    			$obj->setVar('remittion', 'FRAUD');
		    			if ($xoConfig['ipdb_fraud_kill'])
		    				$obj->setVar('mode', 'CANCEL');
		    		}
	    		}
    			catch(Exception $e){
					trigger_error($e, E_NOTICE);
				}
    		}
    	}
		
		if ($obj->vars['mode']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
			if ($obj->getVar('mode')=='PAID') {
				$totalinvoices = $this->getCount(new Criteria('drawto_email', $obj->getVar('drawto_email')));
				$issue_discount=false; 
				if (($totalinvoices % $GLOBALS['xoopsModuleConfig']['issue_discount_every'])&&$GLOBALS['xoopsModuleConfig']['issue_discount']) {
					$issue_discount=true;
				}
				$mtr = mt_rand($GLOBALS['xoopsModuleConfig']['odds_range_lower'], $GLOBALS['xoopsModuleConfig']['odds_range_higher']);
				if (($mtr<=$GLOBALS['xoopsModuleConfig']['odds_minimum']||$mtr>=$GLOBALS['xoopsModuleConfig']['odds_maximum'])&&$GLOBALS['xoopsModuleConfig']['issue_random_discount']) {
					$issue_discount=true;
				}
				if ($issue_discount==true) {
					$obj->sendDiscountCode($obj->getVar('drawto_email'), ($GLOBALS['xoopsModuleConfig']['discount_validtill']==0?0:time()+$GLOBALS['xoopsModuleConfig']['discount_validtill']), $GLOBALS['xoopsModuleConfig']['discount_redeems'], $GLOBALS['xoopsModuleConfig']['discount_percentage'], $GLOBALS['xoopsModuleConfig']['discount_prefix']);	
				}
			}
		}
		
		if ($obj->vars['remittion']['changed']==true) {	
			if ($obj->getVar('remittion')=='NONE')
				$obj->setVar('remitted', 0);
			else 
				$obj->setVar('remitted', time());
			$run_plugin_remittence=true;
		}
		
		if (strlen($obj->getVar('gateway'))==0)
			$obj->setVar('gateway', $GLOBALS['xoopsModuleConfig']['gateway']);
		
		$iid = parent::insert($obj, $force);

		if ($run_plugin==true)
			$obj->runPlugin($iid);
		
		if ($run_plugin_remittence==true)
			$obj->runRemittencePlugin($iid);
		
		return $iid;
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
        
	function getFilterForm($filter, $field, $sort='created', $fct = '') {
    	$ele = xpayment_getFilterElement($filter, $field, $sort, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }

    function getCurrenciesUsed($range, $operator = "AND") {
    	$sql = "SELECT DISTINCT `currency` FROM " . $GLOBALS['xoopsDB']->prefix('xpayment_invoice');
    	if (count($range)) {
    		$where = array();
    		foreach($range as $field => $comparison) {
    			$where[$field] = "$field ".(isset($comparison['operator'])?$comparison['operator']:'=')." ".$GLOBALS['xoopsDB']->quote($comparison['value']);
    		}
    		$sql .= ' WHERE '.implode(" ".$operator." ", $where);
    	}
    	$ret = array();
    	$result = $GLOBALS['xoopsDB']->queryF($sql);
    	while($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    		$ret[$row['currency']] = $row['currency'];	
    	}
    	return $ret;
    }
    
	function getSumByField($opfield, $field, $value, $range, $operator = "AND") {
    	$sql = "SELECT sum($opfield) as result FROM " . $GLOBALS['xoopsDB']->prefix('xpayment_invoice');
    	$sql .= " WHERE $field = ".$GLOBALS['xoopsDB']->quote($value);
    	if (count($range)) {
    		$where = array();
    		foreach($range as $field => $comparison) {
    			$where[$field] = "$field ".(isset($comparison['operator'])?$comparison['operator']:'=')." ".$GLOBALS['xoopsDB']->quote($comparison['value']);
    		}
    		$sql .= " $operator ".implode(" ".$operator." ", $where);
    	}
    	$result = $GLOBALS['xoopsDB']->queryF($sql);
    	list($ret) = $GLOBALS['xoopsDB']->fetchRow($result);
    	return (!empty($ret)?number_format($ret, 2):'0.00');
    }
    
	function getAverageByField($opfield, $field, $value, $range, $operator = "AND") {
    	$sql = "SELECT avg($opfield) as result FROM " . $GLOBALS['xoopsDB']->prefix('xpayment_invoice');
    	$sql .= " WHERE $field = ".$GLOBALS['xoopsDB']->quote($value);
    	if (count($range)) {
    		$where = array();
    		foreach($range as $field => $comparison) {
    			$where[$field] = "$field ".(isset($comparison['operator'])?$comparison['operator']:'=')." ".$GLOBALS['xoopsDB']->quote($comparison['value']);
    		}
    		$sql .= " $operator ".implode(" ".$operator." ", $where);
    	}
    	$result = $GLOBALS['xoopsDB']->queryF($sql);
    	list($ret) = $GLOBALS['xoopsDB']->fetchRow($result);
    	return (!empty($ret)?number_format($ret, 2):'0.00');
    }

    function getMaximumByField($opfield, $field, $value, $range, $operator = "AND") {
    	$sql = "SELECT max($opfield) as result FROM " . $GLOBALS['xoopsDB']->prefix('xpayment_invoice');
    	$sql .= " WHERE $field = ".$GLOBALS['xoopsDB']->quote($value);
    	if (count($range)) {
    		$where = array();
    		foreach($range as $field => $comparison) {
    			$where[$field] = "$field ".(isset($comparison['operator'])?$comparison['operator']:'=')." ".$GLOBALS['xoopsDB']->quote($comparison['value']);
    		}
    		$sql .= " $operator ".implode(" ".$operator." ", $where);
    	}
    	$result = $GLOBALS['xoopsDB']->queryF($sql);
    	list($ret) = $GLOBALS['xoopsDB']->fetchRow($result);
    	return (!empty($ret)?number_format($ret, 2):'0.00');
    }

    function getCountByField($opfield, $field, $value, $range, $operator = "AND") {
    	$sql = "SELECT count($opfield) as result FROM " . $GLOBALS['xoopsDB']->prefix('xpayment_invoice');
    	$sql .= " WHERE $field = ".$GLOBALS['xoopsDB']->quote($value);
    	if (count($range)) {
    		$where = array();
    		foreach($range as $field => $comparison) {
    			$where[$field] = "$field ".(isset($comparison['operator'])?$comparison['operator']:'=')." ".$GLOBALS['xoopsDB']->quote($comparison['value']);
    		}
    		$sql .= " $operator ".implode(" ".$operator." ", $where);
    	}
    	$result = $GLOBALS['xoopsDB']->queryF($sql);
    	list($ret) = $GLOBALS['xoopsDB']->fetchRow($result);
    	return (!empty($ret)?number_format($ret, 0):'0');
    }
    
}

?>