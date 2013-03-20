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
class XpaymentGroups extends XoopsObject
{
	
    function XpaymentGroups($id = null)
    {
        $this->initVar('rid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mode', XOBJ_DTYPE_ENUM, null, false, false, false, array('BROKERS','ACCOUNTS','OFFICERS'));
		$this->initVar('plugin', XOBJ_DTYPE_TXTBOX, '*', false, 128);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('minimum', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('maximum', XOBJ_DTYPE_DECIMAL, null, false);
		
	}
	
	function toArray() {
		$ret = parent::toArray();
		$user_handler =& xoops_gethandler('user');
		$user = $user_handler->get($this->getVar('uid'));
		$ret['user'] = $user->toArray();
		return $ret;
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
class XpaymentGroupsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'xpayment_groups', 'XpaymentGroups', "rid", "plugin");
    }
    	
    function getUids($mode, $plugin, $grand) {
    	
    	$ret = array();
    	
    	$criteria = new CriteriaCompo(new Criteria('`mode`', $mode));
    	$criteria->add(new Criteria('`plugin`', '*'));
    	$criteria->add(new Criteria('`limit`', '0'));
    	$objs = $this->getObjects($criteria);
    	foreach($objs as $rid=>$obj)
    		$ret[$obj->getVar('uid')]=$obj->getVar('uid');
    	
    	$criteria = new CriteriaCompo(new Criteria('`mode`', $mode));
    	$criteria->add(new Criteria('`plugin`', $plugin));
    	$criteria->add(new Criteria('`limit`', '0'));
    	$objs = $this->getObjects($criteria);
    	foreach($objs as $rid=>$obj)
    		$ret[$obj->getVar('uid')]=$obj->getVar('uid');

        $criteria = new CriteriaCompo(new Criteria('`mode`', $mode));
    	$criteria->add(new Criteria('`plugin`', '*'));
    	$criteria->add(new Criteria('`limit`', '1'));
    	$criteria->add(new Criteria('`minimum`', $grand, '>='));
    	$criteria->add(new Criteria('`maximum`', $grand, '<='));
    	$objs = $this->getObjects($criteria);
    	foreach($objs as $rid=>$obj)
    		$ret[$obj->getVar('uid')]=$obj->getVar('uid');
    	
    	$criteria = new CriteriaCompo(new Criteria('`mode`', $mode));
    	$criteria->add(new Criteria('`plugin`', $plugin));
    	$criteria->add(new Criteria('`limit`', '1'));
    	$criteria->add(new Criteria('`minimum`', $grand, '>='));
    	$criteria->add(new Criteria('`maximum`', $grand, '<='));
    	$objs = $this->getObjects($criteria);
    	foreach($objs as $rid=>$obj)
    		$ret[$obj->getVar('uid')]=$obj->getVar('uid');

    	return $ret;
    }
}

?>