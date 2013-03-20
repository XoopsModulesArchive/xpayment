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
function profile_checkpasskey($key) {

	$minseed = strtotime(date('Y-m-d h:i'));
	$diff = intval((120/2)*60);
	for($step=($minseed-$diff);$step<($minseed+$diff);$step++)
		if ($key==md5(XOOPS_LICENSE_KEY.date('Ymdhi', $step)))
			return true;
	return false;

}

include('../../mainfile.php');
$GLOBALS['xoopsLogger']->activated = false;

xoops_load('XoopsUserUtility');
$myts =& MyTextSanitizer::getInstance();

foreach($_GET as $id => $val)
	${$id} = $val;

if (!function_exists('json_encode')) {
	include $GLOBALS['xoops']->path('/modules/xpayment/include/JSON.php');
	$json = new services_JSON();
}
set_time_limit(120);


if (!profile_checkpasskey($passkey)) { 
	$values['innerhtml']['gateway_html'] = _XPY_VALIDATE_PASSKEYFAILED;
	if (!function_exists('json_encode'))
		print $json->encode($values);
	else
		print json_encode($values);
	exit(0);
}

$invoice_handler = xoops_getmodulehandler('invoice', 'xpayment');
$gateways_handler = xoops_getmodulehandler('gateways', 'xpayment');
if (isset($iid)&&$GLOBALS['xoopsModuleConfig']['id_protect']==false) {
	$invoice =& $invoice_handler->get($iid);
} else {
	$criteria = new Criteria('offline', time(), '>=');
	$criteria->setSort('iid');
	$criteria->setOrder('DESC');
	$count = $invoice_handler->getCount($criteria);
	$invoices = $invoice_handler->getObjects($criteria, true);
	foreach($invoices as $iiid => $inv) {
		if ($iid==md5($inv->getVar('iid').XOOPS_LICENSE_KEY)) {
			$invoice = $inv;
		}
	}
}

$gateway = $gateways_handler->get($gid);
$gateway->loadGateway($invoice);
$invoice->setGateway($gateway);
$values['innerhtml']['gateway_html'] = $invoice->getPaymentHtml();
if ($invoice->getVar('topayment')>time()) {
	$values['submit']['gateway'] = $gateway->getVar('name'); 
} 
if (!function_exists('json_encode'))
	print $json->encode($values);
else
	print json_encode($values);
?>