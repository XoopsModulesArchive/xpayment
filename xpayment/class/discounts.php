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
class XpaymentDiscounts extends XoopsObject
{
	var $_dHandler;
		
    function XpaymentDiscounts($id = null)
    {
        $this->initVar('did', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 48);
		$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('validtill', XOBJ_DTYPE_INT, null, false);
		$this->initVar('redeems', XOBJ_DTYPE_INT, null, false);
		$this->initVar('discount', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('redeemed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('iids', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('sent', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);

		$this->_dHandler = xoops_getmodulehandler('discounts', 'xpayment');
	}
	
	function toArray() {
		$ret = parent::toArray();
		if ($this->getVar('uid')>0) {
			$user_handler = xoops_gethandler('user');
			$user = $user_handler->get($this->getVar('uid'));
			if (strlen($user->getVar('name'))>0)
				$ret['user']['uid'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$this->getVar('uid').'">'.$user->getVar('name'). ' ('.$user->getVar('uname').')</a>';
			else 
				$ret['user']['uid'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$this->getVar('uid').'">'.$user->getVar('uname').'</a>';
		}
		if ($this->getVar('validtill')>0) {
			$ret['date']['validtill'] = date(_DATESTRING, $this->getVar('validtill'));
		} elseif ($this->getVar('validtill')==0) {
			xoops_loadLanguage('main', 'xpayment');
			$ret['date']['validtill'] = _XPY_MF_DISCOUNT_FOREVER;
		}
		if ($this->getVar('created')>0) {
			$ret['date']['created'] = date(_DATESTRING, $this->getVar('created'));
		}
		if ($this->getVar('updated')>0) {
			$ret['date']['updated'] = date(_DATESTRING, $this->getVar('updated'));
		}
		return $ret;
	}
	
	function sendReminderEmail() {
		xoops_load('xoopsmailer');
		xoops_loadLanguage('admin','xpayment');
		
		$xoopsMailer =& getMailer();
		$xoopsMailer->setHTML(true);
		$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
		$xoopsMailer->setTemplate('xpayment_discount_reminder.tpl');
		$xoopsMailer->setSubject(str_replace('%discount', floor($this->getVar('discount')), str_replace('%left', floor($this->getVar('redeems')-$this->getVar('redeemed')), constant('_XPY_EMAIL_DISCOUNT_REMINDER_SUBJECT'))));
		
		$xoopsMailer->assign('CODE', $this->getVar('code'));
		$xoopsMailer->assign('DISCOUNT', $this->getVar('discount'));
		$xoopsMailer->assign('REDEEMS', $this->getVar('redeems'));
		$xoopsMailer->assign('REDEEMED', $this->getVar('redeemed'));
		$xoopsMailer->assign('LEFT', $this->getVar('redeems')-$this->getVar('redeemed'));
		$xoopsMailer->assign('VALID', ($this->getVar('validtill')==0?_XPY_AM_DISCOUNT_FOREVER:date(_DATESTRING,$this->getVar('validtill'))));
		$xoopsMailer->assign('EMAIL', $this->getVar('email'));
		$xoopsMailer->assign("SITEURL", XOOPS_URL);
		$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
		
		$xoopsMailer->setToEmails($this->getVar('email'));
		if (time()-$this->getVar('sent')>$GLOBALS['xoopsModuleConfig']['reminder_resend_in']) {
			$xoopsMailer->send();	
			$this->setVar('sent', time());
			$this->_dHandler->insert($this, true);
			return true;
		}	
		return false;
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
class XpaymentDiscountsHandler extends XoopsPersistableObjectHandler
{
	var $_mHandler;
	var $_uHandler;
	var $_mod;
	var $_modConfig;
	
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'xpayment_discounts', 'XpaymentDiscounts', "did", "code");
        $this->_mHandler =& xoops_gethandler('member');
        $this->_uHandler =& xoops_gethandler('user');
        
        $module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$this->_mod = $module_handler->getByDirname('xpayment');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid'));
    }
    
	private function getCode($prefix, $length=42, $num = 6)
	{
		$code='';
		$code.=$prefix;
		$base = explode('|', $this->_modConfig['discount_base']);
		while(strlen($code)<48&&count($code)>0) {
			$code .= $base[mt_rand(0,sizeof($base)-1)];
		}
		return $this->getStripeCode($code, $length, $num);
	}
	
	private function getStripeCode($code, $length = 42, $num = 6)
	{
	    $uu = 0;
	    $strip = floor(strlen($code) / 6);
	    for ($i = 0; $i < strlen($code); $i++) {
	        if ($i < $length) {
	            $uu++;
	            if ($uu == $strip) {
	                $ret .= substr($code, $i, 1) . '-';
	                $uu = 0;
	            } else {
	                if (substr($code, $i, 1) != '-') {
	                    $ret .= substr($code, $i, 1);
	                } else {
	                    $uu--;
	                }
	            }
	        }
	    }
	    $ret = str_replace('--', '-', $ret);
	    if (substr($ret, 0, 1) == '-') {
	        $ret = substr($ret, 2, strlen($ret));
	    }
	    if (substr($ret, strlen($ret) - 1, 1) == '-') {
	        $ret = substr($ret, 0, strlen($ret) - 1);
	    }
	    return $ret;
	}
	
    function getUsersByGroup($group_id, $logged_in_since = 0, $registered_since = 0, $asobject = true)
    {        
    	$user_ids = $this->_mHandler->getUsersByGroup($group_id);
        if (!$asobject) {
            return $user_ids;
        } else {
            $ret = array();
            foreach ($user_ids as $u_id) {
                $user =& $this->_uHandler->get($u_id);
                if (is_object($user)) {
                	if (($logged_in_since>0&&$user->getVar('last_login')>$logged_in_since)&&($registered_since>0&&$user->getVar('user_regdate')>$registered_since)) {
                    	$ret[] = & $user;
                	} elseif (($logged_in_since>0&&$user->getVar('last_login')>$logged_in_since)&&($registered_since==0)) {
                		$ret[] = & $user;
                	} elseif (($logged_in_since==0)&&($registered_since>0&&$user->getVar('user_regdate')>$registered_since)) {
                    	$ret[] = & $user;
                    } elseif (($logged_in_since==0)&&($registered_since==0)) {
                    	$ret[] = & $user;
                    }
                }
                unset($user);
            }
            return $ret;
        }
    }
    
    function sendDiscountCode($email, $validtill, $redeems, $discount, $prefix, $uid = 0, $sendemail=true) {
    	$object = parent::create();
    	$object->setVar('email', $email);
    	$object->setVar('validtill', $validtill);
    	$object->setVar('redeems', $redeems);
    	$object->setVar('discount', $discount);
    	$object->setVar('code', $this->getCode($prefix));
    	if ($uid>0) {
    		$object->setVar('uid', $uid);
    	} else {
    		if (is_object($GLOBALS['xoopsUser'])) {
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    		}
    	}
    	if ($this->insert($object, true, $sendemail)) {
    		return $object->getVar('code');
    	} else {
    		return false;
    	}
    }

    function getByEmail($email) {
    	$sql = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('xpayment_discounts').' WHERE `email` = "'.$email.'" AND (`redeems` > `redeemed` AND (`validtill` > "'.time().'" OR `validtill` = "0"))';
    	if ($result = $GLOBALS['xoopsDB']->queryF($sql)) {
    		if ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    			$object = new XpaymentDiscounts();
    			$object->assignVars($row);
    			return $object;
    		}
  	   	}
    	return false;
    }
    
    function getByCode($code) {
    	$sql = 'SELECT * FROM '.$GLOBALS['xoopsDB']->prefix('xpayment_discounts').' WHERE `code` = "'.$code.'" AND (`redeems` > `redeemed` AND (`validtill` > "'.time().'" OR `validtill` = "0"))';
    	if ($result = $GLOBALS['xoopsDB']->queryF($sql)) {
    		if ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    			$object = new XpaymentDiscounts();
    			$object->assignVars($row);
    			return $object;
    		}
    	}
    	return false;
    }
    
    function insert($object, $force=true, $sendemail=true) {
    	
    	xoops_load('xoopsmailer');
		xoops_loadLanguage('admin','xpayment');
		
		// Do some cleaning
		$sql = 'DELETE FROM '.$GLOBALS['xoopsDB']->prefix('xpayment_discounts').' WHERE (`redeems` <= `redeemed` AND `validtill` < "'.time().'") OR (`validtill` = "0" AND `redeems` <= `redeemed`))';
		@$GLOBALS['xoopsDB']->queryF($sql);
		
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		$object->setVar('sent', time());
    		if ($object->getVar('redeems')>0&&$object->getVar('discount')>0) {
	    		if ($did = parent::insert($object, $force)) {
	    							
					$xoopsMailer =& getMailer();
					$xoopsMailer->setHTML(true);
					$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
					$xoopsMailer->setTemplate('xpayment_discount_new.tpl');
					$xoopsMailer->setSubject(str_replace('%discount', floor($object->getVar('discount')), str_replace('%left', ($object->getVar('validtill')==0?_XPY_AM_DISCOUNT_FOREVER:date(_DATESTRING,$object->getVar('validtill'))), constant('_XPY_EMAIL_DISCOUNT_SUBJECT'))));
					
					$xoopsMailer->assign('CODE', $object->getVar('code'));
					$xoopsMailer->assign('DISCOUNT', $object->getVar('discount'));
					$xoopsMailer->assign('REDEEMS', $object->getVar('redeems'));
					$xoopsMailer->assign('VALID', ($object->getVar('validtill')==0?_XPY_MF_DISCOUNT_FOREVER:date(_DATESTRING,$object->getVar('validtill'))));
					$xoopsMailer->assign('EMAIL', $object->getVar('email'));
					$xoopsMailer->assign("SITEURL", XOOPS_URL);
					$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
					
					$xoopsMailer->setToEmails($object->getVar('email'));
					
					if ($sendemail) {
						if (!$xoopsMailer->send()) {
							parent::deleteAll(new Criteria('did', $did), true);
							return false;
						} else 
							return $did;
					} else 
						return $did;
	    		} else {
    				return false;
    			}
    		} else {
    			return false;
    		}
    	} else {
    		if ($object->vars['redeemed']['changed']==true&&$object->getVar('redeems')>$object->getVar('redeemed')) {
    			$xoopsMailer =& getMailer();
				$xoopsMailer->setHTML(true);
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
				$xoopsMailer->setTemplate('xpayment_discount_more.tpl');
				$xoopsMailer->setSubject(str_replace('%discount', floor($object->getVar('discount')), str_replace('%left', floor($this->getVar('redeems')-$this->getVar('redeemed')), constant('_XPY_EMAIL_DISCOUNT_MORE_REDEEMS_SUBJECT'))));
				
				$xoopsMailer->assign('CODE', $object->getVar('code'));
				$xoopsMailer->assign('DISCOUNT', $object->getVar('discount'));
				$xoopsMailer->assign('REDEEMS', $object->getVar('redeems'));
				$xoopsMailer->assign('REDEEMED', $object->getVar('redeemed'));
				$xoopsMailer->assign('LEFT', $object->getVar('redeems')-$object->getVar('redeemed'));
				$xoopsMailer->assign('VALID', ($object->getVar('validtill')==0?_XPY_MF_DISCOUNT_FOREVER:date(_DATESTRING,$object->getVar('validtill'))));
				$xoopsMailer->assign('EMAIL', $object->getVar('email'));
				$xoopsMailer->assign("SITEURL", XOOPS_URL);
				$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);

				$xoopsMailer->setToEmails($object->getVar('email'));
				if (time()-$this->getVar('sent')>$GLOBALS['xoopsModuleConfig']['reminder_resend_in']) {
					if ($sendemail) { 
						$xoopsMailer->send();	
						$object->setVar('sent', time());
					}
				}
    		}
    		$object->setVar('updated', time());
    	}
    	return parent::insert($object, $force);
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
}

?>