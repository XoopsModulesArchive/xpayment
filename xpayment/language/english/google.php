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
	define("_XPY_GI_GOOGLE_NAME","Google checkout Gateway");
	define("_XPY_GI_GOOGLE_DESC","This gateway for google checkout allows for multiple items to be posted to paypal for payment.");
	define("_XPY_GI_GOOGLE_AUTHOR","Simon Roberts (simon@chronolabs.com.au)");
	define("_XPY_GI_GOOGLE_NAME_SMERCHANTID","Google Checkout Merchant ID (S_MERCHANT_ID)");
	define("_XPY_GI_GOOGLE_NAME_PMERCHANTID","Google Checkout Merchant ID (P_MERCHANT_ID)");
	define("_XPY_GI_GOOGLE_NAME_SMERCHANTKEY","Google Checkout Merchant Key (S_MERCHANT_KEY)");
	define("_XPY_GI_GOOGLE_NAME_PMERCHANTKEY","Google Checkout Merchant Key (P_MERCHANT_KEY)");
	define("_XPY_GI_GOOGLE_NAME_SANDBOX","Google checkout Sandbox URL");
	define("_XPY_GI_GOOGLE_NAME_URL","Google checkout Form URL");
	define("_XPY_GI_GOOGLE_NAME_IMAGE","150x50-pixel image displayed as your logo in the upper left corner of PayPal’s pages.");
	define("_XPY_GI_GOOGLE_NAME_PAYWITH","Payment Button Caption");
	define("_XPY_GI_GOOGLE_VALUE_SMERCHANTID","000000");	
	define("_XPY_GI_GOOGLE_VALUE_PMERCHANTID","000000");
	define("_XPY_GI_GOOGLE_VALUE_SMERCHANTKEY","000000");	
	define("_XPY_GI_GOOGLE_VALUE_PMERCHANTKEY","000000");
	define("_XPY_GI_GOOGLE_NAME_CASSL","Your CA SSL Path");
	define("_XPY_GI_GOOGLE_VALUE_CASSL",XOOPS_ROOT_PATH);
	define("_XPY_GI_GOOGLE_VALUE_SANDBOX","https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/%s");
	define("_XPY_GI_GOOGLE_VALUE_URL","https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/%s");
	define("_XPY_GI_GOOGLE_VALUE_PAYWITH","Pay with Google checkout");
?>