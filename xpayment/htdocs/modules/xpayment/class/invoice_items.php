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

/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class XpaymentInvoice_items extends XoopsObject
{
	
    function XpaymentInvoice_items($id = null)
    {
        $this->initVar('iiid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('iid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('cat', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('amount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('quantity', XOBJ_DTYPE_DECIMAL, 0, false);
		$this->initVar('shipping', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('handling', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('weight', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('tax', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 5000);
		$this->initVar('mode', XOBJ_DTYPE_ENUM, 'PURCHASED', false, false, false, array('PURCHASED', 'REFUNDED', 'UNDELIVERED', 'DAMAGED', 'EXPRESS'));
		$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);
		
    }
   
    function toArray($apply_discount=true) {
		$ret = parent::toArray();
		foreach($this->getTotalsArray($apply_discount) as $field => $value) {
			if ($field=='weight')
				$ret['totals'][$field] = number_format($value, 4);
			else 
				$ret['totals'][$field] = number_format($value, 2);
		}
		$ret['created_datetime'] = date(_DATESTRING, $this->getVar('created'));
		$ret['updated_datetime'] = date(_DATESTRING, $this->getVar('updated'));
		$ret['actioned_datetime'] = date(_DATESTRING, $this->getVar('actioned'));
		return $ret;
	}

	function getDiscountShipping($apply_discount=true) {
		static $invoice = NULL;
		if (!isset($invoice)||@$invoice->getVar('iid')!=$this->getVar('iid')) {
			$invoice_handler = xoops_getmodulehandler('invoice', 'xpayment');
			$invoice = $invoice_handler->get($this->getVar('iid'));
		}
		return doubleval(str_replace(',' ,'', number_format(($apply_discount==false?0:($this->getVar('shipping')*$this->getVar('quantity'))*($invoice->getVar('discount')/100)),2)));
	}
	
	function getDiscountHandling($apply_discount=true) {
		static $invoice = NULL;
		if (!isset($invoice)||@$invoice->getVar('iid')!=$this->getVar('iid')) {
			$invoice_handler = xoops_getmodulehandler('invoice', 'xpayment');
			$invoice = $invoice_handler->get($this->getVar('iid'));
		}
		return doubleval(str_replace(',' ,'', number_format(($apply_discount==false?0:($this->getVar('handling')*$this->getVar('quantity'))*($invoice->getVar('discount')/100)),2)));
	}
	
	function getDiscountAmount($apply_discount=true) {
		static $invoice = NULL;
		if (!isset($invoice)||@$invoice->getVar('iid')!=$this->getVar('iid')) {
			$invoice_handler = xoops_getmodulehandler('invoice', 'xpayment');
			$invoice = $invoice_handler->get($this->getVar('iid'));
		}
		return doubleval(str_replace(',' ,'', number_format(($apply_discount==false?0:($this->getVar('amount')*$this->getVar('quantity'))*($invoice->getVar('discount')/100)),2)));
	}
	
	function getTotalShipping($apply_discount=true) {
		return doubleval(str_replace(',' ,'', number_format(($this->getVar('shipping')*$this->getVar('quantity'))-$this->getDiscountShipping($apply_discount), 2)));
	}
	
	function getTotalHandling($apply_discount=true) {
		return doubleval(str_replace(',' ,'', number_format(($this->getVar('handling')*$this->getVar('quantity'))-$this->getDiscountHandling($apply_discount), 2)));
	}
	
	function getTotalWeight() {
		return doubleval(str_replace(',' ,'', number_format(($this->getVar('weight')*$this->getVar('quantity')), 4)));
	}

	function getTotalAmount($apply_discount=true) {
		return doubleval(str_replace(',' ,'', number_format(($this->getVar('amount')*$this->getVar('quantity'))-$this->getDiscountAmount($apply_discount), 2)));
	}
	
	function getTotalTax($apply_discount=true) {
		if ($this->getVar('tax')>0) 
			return doubleval(str_replace(',' ,'', number_format(($this->getTotalAmount(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_amount']==true))+$this->getTotalShipping(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_shipping']==true))+$this->getTotalHandling(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_handling']==true)))*($this->getVar('tax')/100),2)));					
		return 0;
	}

	function getTotalsArray($apply_discount=true) {
		return array (	'amount'			=>			$this->getTotalAmount(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_amount']==true)),
						'handling'			=>			$this->getTotalHandling(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_handling']==true)),
						'weight'			=>			$this->getTotalWeight(),
						'shipping'			=>			$this->getTotalShipping(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_shipping']==true)),
						'tax'				=>			$this->getTotalTax($apply_discount),
						'grand'				=>			$this->getTotalTax($apply_discount)+$this->getTotalShipping(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_shipping']==true))+$this->getTotalHandling(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_handling']==true))+$this->getTotalAmount(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_amount']==true)),
						'discount_amount'	=>			$this->getDiscountAmount(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_amount']==true)),
						'discount_handling'	=>			$this->getDiscountHandling(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_handling']==true)),
						'discount_shipping'	=>			$this->getDiscountShipping(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_shipping']==true)),
						'discount_grand'	=>			$this->getDiscountShipping(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_shipping']==true))+$this->getDiscountHandling(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_handling']==true))+$this->getDiscountAmount(($apply_discount==true&&$GLOBALS['xoopsModuleConfig']['discount_amount']==true)));
	}
	
	function runPlugin() {
		
		if (is_object($this->_invoice)) {
			include_once($GLOBALS['xoops']->path('/modules/xpayment/plugin/'.$this->_invoice->getVar('plugin').'.php'));
			
			switch ($this->getVar('mode')) {
				case 'PURCHASED':
				case 'REFUNDED';
				case 'UNDELIVERED':
				case 'DAMAGED':
				case 'EXPRESS':
					$func = ucfirst($this->getVar('mode')).ucfirst($this->_invoice->getVar('mode')).ucfirst($this->_invoice->getVar('plugin')).'ItemHook';
					break;
				default:
					return false;
					break;
			}
			
			if (function_exists($func))  {
				@$func($this, $invoice);
			}
		}

		return true;
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
class XpaymentInvoice_itemsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'xpayment_invoice_items', 'XpaymentInvoice_items', "iiid", "name");
    }
	
    function getDiscount(&$invoice) {
    	if (is_a($invoice, 'XpaymentInvoice')) {
	    	foreach(parent::getObjects(new Criteria('iid', $invoice->getVar('iid')), true) as $iiid => $item) {
	    		if (is_a($item, 'XpaymentInvoice_items')) {
					$totals = $item->getTotalsArray(true);
					$amount = $amount + $totals['amount'];
					$shipping = $shipping + $totals['shipping'];
					$handling = $handling + $totals['handling'];
					$tax = $tax + $totals['tax'];	
					$discount_amount = $discount_amount + $totals['discount_amount'];
					$discount_handling = $discount_handling + $totals['discount_handling'];
					$discount_shipping = $discount_shipping + $totals['discount_shipping'];
					$discount_grand = $discount_grand + $totals['discount_grand'];
	    		}
			}
			return array(	'amount' 				=>		$amount,
							'shipping' 				=>		$shipping,
							'handling' 				=>		$handling,
							'tax' 					=>		$tax,
							'grand' 				=>		$tax+$handling+$shipping+$amount,
							'discount_amount' 		=>		$discount_amount,
							'discount_handling' 	=>		$discount_handling,
							'discount_shipping' 	=>		$discount_shipping,
							'discount_grand' 		=>		$discount_grand);
    	}
    }
	function insert($obj, $force = true) {
		static $rates;
		
		if (!isset($obj->_invoice)&&$obj->getVar('iid')>0) {
			$obj->_invoice = $obj;
		}
		
		if ($GLOBALS['xoopsModuleConfig']['autotax']==true) {
			if ($obj->getVar('iid')>0) {
				$autotax_handler = xoops_getmodulehandler('autotax', 'xpayment');
				$obj->setVar('tax', $autotax_handler->getTaxRate($obj->_invoice->getVar('user_ipdb_country_code')));
			}
		}
		
		if ($obj->isNew())
			$obj->setVar('created', time());
		else
			$obj->setVar('updated', time());
		
		if ($obj->vars['mode']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
		
		$iiid = parent::insert($obj, $force);
		if ($run_plugin==true)
			$obj->runPlugin();
		return $iiid;
	}
}

?>