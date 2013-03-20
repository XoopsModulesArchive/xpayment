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
	$gateway=array();
	
	xoops_loadLanguage('google', 'xpayment');
	
	$gateway['name'] = '_XPY_GI_GOOGLE_NAME';
	$gateway['author'] = '_XPY_GI_GOOGLE_AUTHOR';
	$gateway['description'] = '_XPY_GI_GOOGLE_DESC';
	
	$gateway['testmode'] = false;
	$gateway['class'] = basename(dirname(__FILE__));
	
	srand((((float)('0' . substr(microtime(), strpos(microtime(), ' ') + 1, strlen(microtime()) - strpos(microtime(), ' ') + 1))) * mt_rand(30, 99999)));
	srand((((float)('0' . substr(microtime(), strpos(microtime(), ' ') + 1, strlen(microtime()) - strpos(microtime(), ' ') + 1))) * mt_rand(30, 99999)));
	$gateway['salt'] = ((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'').((mt_rand(0,1)==true)?chr(mt_rand(33,122)):'');
	
	$gateway['options']['pmerchantid']['name'] = '_XPY_GI_GOOGLE_NAME_PMERCHANTID';
	$gateway['options']['pmerchantid']['value'] = _XPY_GI_GOOGLE_VALUE_PMERCHANTID;

	$gateway['options']['pmerchantkey']['name'] = '_XPY_GI_GOOGLE_NAME_PMERCHANTKEY';
	$gateway['options']['pmerchantkey']['value'] = _XPY_GI_GOOGLE_VALUE_PMERCHANTKEY;

	$gateway['options']['smerchantid']['name'] = '_XPY_GI_GOOGLE_NAME_SMERCHANTID';
	$gateway['options']['smerchantid']['value'] = _XPY_GI_GOOGLE_VALUE_SMERCHANTID;
	
	$gateway['options']['smerchantkey']['name'] = '_XPY_GI_GOOGLE_NAME_SMERCHANTKEY';
	$gateway['options']['smerchantkey']['value'] = _XPY_GI_GOOGLE_VALUE_SMERCHANTKEY;
	
	$gateway['options']['sandbox']['name'] = '_XPY_GI_GOOGLE_NAME_SANDBOX';
	$gateway['options']['sandbox']['value'] = _XPY_GI_GOOGLE_VALUE_SANDBOX;
	
	$gateway['options']['url']['name'] = '_XPY_GI_GOOGLE_NAME_URL';
	$gateway['options']['url']['value'] = _XPY_GI_GOOGLE_VALUE_URL;

	$gateway['options']['cassl']['name'] = '_XPY_GI_GOOGLE_NAME_CASSL';
	$gateway['options']['cassl']['value'] = _XPY_GI_GOOGLE_VALUE_CASSL;
	
	$gateway['options']['paywith']['name'] = '_XPY_GI_GOOGLE_NAME_PAYWITH';
	$gateway['options']['paywith']['value'] = _XPY_GI_GOOGLE_VALUE_PAYWITH;
	
	
	
?>