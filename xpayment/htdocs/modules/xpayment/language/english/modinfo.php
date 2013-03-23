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
	// XOOPS version
	define("_MI_XPY_DESC","Xpayment is an Invoice Payment Gateway with Modular Plugins");
	define("_MI_XPY_CREDITS","Simon Roberts (simon@chronolabs.coop), Erol Konik (aphex@aphexthemes.com)");
	// PREFERENCES - 1.30
	define("_XPY_MI_FEECOMPHENSATE","Comphensate Value with Fee");
	define("_XPY_MI_FEECOMPHENSATE_DESC","This will add the fee to the invoice charged by the gateway to comphensate the invoice for fees taken by the gateway.");
	define("_XPY_MI_DEPOSITCOMPHENSATE","Compensate Value with Security Deposit");
	define("_XPY_MI_DEPOSITCOMPHENSATE_DESC","This will add the security deposit to the invoice charged by the gateway to compensate the invoice for security deposit taken by the gateway.");
	// PREFERENCES - 1.29 and earlier
	define("_XPY_MI_GATEWAY","Default Gateway to Use");
	define("_XPY_MI_GATEWAY_DESC","It must be installed to work correctly!");
	define("_XPY_MI_DUE","Invoice Due");
	define("_XPY_MI_DUE_DESC","This is the period from the creatation date when the invoice is due to be paid!");
	define("_XPY_MI_COLLECT","Invoice Collected");
	define("_XPY_MI_COLLECT_DESC","This is the period after the due point where remittence is place on the invoice!");
	define("_XPY_MI_WAIT","Invoice Collection Wait");
	define("_XPY_MI_WAIT_DESC","This is the period of time to wait on collection before the invoice is canceled!");
	define("_XPY_MI_OFFLINE","Invoice Offline");
	define("_XPY_MI_OFFLINE_DESC","This is the period after the collection date when the invoice goes offline!");
	define("_XPY_MI_PERIOD","Default Reoccuring Billing Period");
	define("_XPY_MI_PERIOD_DESC","This is the default period for a reoccuring bill!");
	define("_XPY_MI_PAUSE","Action Pause Time");
	define("_XPY_MI_PAUSE_DESC","This is how many seconds an invoice is paused for after it is actioned!");
	define("_XPY_MI_BROKERS","Broker Group");
	define("_XPY_MI_BROKERS_DESC","This is the group brokers belong to!");
	define("_XPY_MI_ACCOUNTS","Accounts Group");
	define("_XPY_MI_ACCOUNTS_DESC","This is the group accounts people belong to!");
	define("_XPY_MI_OFFICERS","Officers Groups");
	define("_XPY_MI_OFFICERS_DESC","This is the group remittence officers are members of!");
	define("_XPY_MI_HELP","Display Form Help?");
	define("_XPY_MI_HELP_DESC","To turn on the help window (yes) or have it in blank invoice mode (no)");
	define("_XPY_MI_CURRENCY","Default Currency");
	define("_XPY_MI_CURRENCY_DESC","ISO Code for default currency. ie. AUD = Australian Dollar");
	define("_XPY_MI_WEIGHTUNIT","Default Weight Unit");
	define("_XPY_MI_WEIGHTUNIT_DESC","Default measurement for weight.");
	define("_XPY_MI_MANUAL","Manual Bank Payment Details");
	define("_XPY_MI_MANUAL_DESC","This is the manual payment via transfer with a bank");
	// Preference Options
	define("_XPY_MI_SECONDS_1DAYS","1 Day");
	define("_XPY_MI_SECONDS_3DAYS","3 Days");
	define("_XPY_MI_SECONDS_7DAYS","7 Days");
	define("_XPY_MI_SECONDS_14DAYS","14 Days");
	define("_XPY_MI_SECONDS_30DAYS","30 Days");
	define("_XPY_MI_SECONDS_60DAYS","60 Days");
	define("_XPY_MI_SECONDS_90DAYS","90 Days");
	define("_XPY_MI_SECONDS_180DAYS","180 Days");
	define("_XPY_MI_SECONDS_270DAYS","270 Days");
	define("_XPY_MI_SECONDS_365DAYS","1 Year");
	define("_XPY_MI_SECONDS_10","10s");
	define("_XPY_MI_SECONDS_30","30s");
	define("_XPY_MI_SECONDS_60","1m");
	define("_XPY_MI_SECONDS_90","1m 30s");
	define("_XPY_MI_SECONDS_120","2m");
	define("_XPY_MI_SECONDS_180","3m");
	define("_XPY_MI_SECONDS_240","4m");
	define("_XPY_MI_SECONDS_300","5m");
	define("_XPY_MI_SECONDS_360","6m");
	define("_XPY_MI_SECONDS_420","7m");	
	// Admin Menus
	define("_XPY_ADMENU1","Invoices");
	define("_XPY_ADMENU2","Transactions");
	define("_XPY_ADMENU3","Payment Gateways");
	define("_XPY_ADMENU4","Permissions");
	define("_XPY_ADMENU5","Groups");
	//Main menu
	define("_XPY_MI_MNU_BROKER","Broker Invoices");
	define("_XPY_MI_MNU_ACCOUNTS","Accounts Invoices");
	define("_XPY_MI_MNU_OFFICERS","Officers Invoices");
	//Groups
	define("_XPY_MI_GROUP_NAME_BROKER","Invoice Broker");
	define("_XPY_MI_GROUP_DESC_BROKER","This is a group for brokers of an invoice to belong to.");
	define("_XPY_MI_GROUP_TYPE_BROKER","Broker");
	define("_XPY_MI_GROUP_NAME_ACCOUNTS","Invoices Accounts");
	define("_XPY_MI_GROUP_DESC_ACCOUNTS","This is a group for accounts managers of invoices to belong to.");
	define("_XPY_MI_GROUP_TYPE_ACCOUNTS","Accounts");
	define("_XPY_MI_GROUP_NAME_OFFICER","Invoice Officers");
	define("_XPY_MI_GROUP_DESC_OFFICER","This is a group for remittence officers to belong to.");
	define("_XPY_MI_GROUP_TYPE_OFFICER","Officer");
	// Version 1.33
	//Menus
	define("_XPY_ADMENU6","Automatic Taxes");
	// Preferences
	define("_XPY_MI_AUTOTAX","Use and set Tax Automatically");
	define("_XPY_MI_AUTOTAX_DESC","You need to have an IPDB API Key to use Auto Tax, remember to set your tax rate to countries in the settings.");
	define("_XPY_MI_IPDB_APIKEY","IPDB API Key");
	define("_XPY_MI_IPDB_APIKEY_DESC",'Register at <a href="http://ipinfodb.com/register.php">IPDB Registration</a> to recieve an API Key');
	define("_XPY_MI_COUNTRYCODE","Shipping/Billing Country");
	define("_XPY_MI_COUNTRYCODE_DESC","This is the country shipping/billing address");
	define("_XPY_MI_DISTRICT","Shipping/Billing Postcode");
	define("_XPY_MI_DISTRICT_DESC","This is the postcode/zip of the district the shipping/billing is done from");
	define("_XPY_MI_CITY","Shipping/Billing City");
	define("_XPY_MI_CITY_DESC","This is the city the shipping/billing is done from");
	define("_XPY_MI_FRAUD_KNOCKOFF","Fraud Score Knock Off");
	define("_XPY_MI_FRAUD_KNOCKOFF_DESC","Percentile of score vs accuracy score for knock off on fraud, this and anything scoring below it will be marked for fraud.");
	define("_XPY_MI_FRAUD_KILL","Fraud Cancelation on Knock Off");
	define("_XPY_MI_FRAUD_KILL_DESC","Mark invoices cancelled when fraud knock off is met.");
	define("_XPY_MI_ID_PROTECT","Protect Invoice ID\'s");
	define("_XPY_MI_ID_PROTECT_DESC","This will replace ID in the URL with a secure MD5 checksum");
	define("_XPY_MI_HTACCESS",".htaccess SEO");
	define("_XPY_MI_HTACCESS_DESC","Enable SEO using Mod Rewrite and .htaccess (see /docs for ammendment to .htaccess file)");
	define("_XPY_MI_BASEURL","Base of the SEO rewrite");
	define("_XPY_MI_BASEURL_DESC","This is the intial path for the SEO");
	define("_XPY_MI_ENDOFURL","End of SEO URL");
	define("_XPY_MI_ENDOFURL_DESC","This is the extension at the end of the SEO");
	define("_XPY_MI_ENDOFURL_PDF","End of PDF SEO URL");
	define("_XPY_MI_ENDOFURL_PDF_DESC","This is the extension at the end of PDF output with the SEO");
	// Version 1.35
	// Preferences
	define("_XPY_MI_ISSUE_DISCOUNT","Issue discount on number of discounts?");
	define("_XPY_MI_ISSUE_DISCOUNT_DESC","This is whether you wish to issue a discount for particular individuals who email address tallies.");
	define("_XPY_MI_ISSUE_DISCOUNT_EVERY","Number of invoices to issue discount on");
	define("_XPY_MI_ISSUE_DISCOUNT_EVERY_DESC","This is the number of invoices someone has to have to be issued an invoice discount.");
	define("_XPY_MI_ISSUE_RANDOM_DISCOUNT","Issue random discount?");
	define("_XPY_MI_ISSUE_RANDOM_DISCOUNT_DESC","This is whether you wish to allot odds for discount assignment.");
	define("_XPY_MI_ODDS_RANGE_LOWER","Odds lowest number in random selection");
	define("_XPY_MI_ODDS_RANGE_LOWER_DESC","This is the lowest number used in alloting odds");
	define("_XPY_MI_ODDS_RANGE_HIGHER","Odds highest number in random selection");
	define("_XPY_MI_ODDS_RANGE_HIGHER_DESC","This is the highest number used in alloting odds");
	define("_XPY_MI_ODDS_MINIMUM","Odd Selected when Equal to or less than from random number");
	define("_XPY_MI_ODDS_MINIMUM_DESC","This is the number for equal to or less than for odds from the odds range.");
	define("_XPY_MI_ODDS_MAXIMUM","Odd Selected when Equal to or higher than from random number");
	define("_XPY_MI_ODDS_MAXIMUM_DESC","This is the number for equal to or higher than for odds from the odds range.");
	define("_XPY_MI_DISCOUNT_PREFIX","Discount Prefix for Code");
	define("_XPY_MI_DISCOUNT_PREFIX_DESC","This is prefix for the discount by default.");
	define("_XPY_MI_DISCOUNT_BASE","Discount code character base");
	define("_XPY_MI_DISCOUNT_BASE_DESC","These are the characters or combinations of characters in the discount code (seperate with a pipe symbol).");
	define("_XPY_MI_DISCOUNT_VALIDTILL","Number of seconds discount is valid for");
	define("_XPY_MI_DISCOUNT_VALIDTILL_DESC","This is the number of seconds a discount code is valid for (0 = forever).");
	define("_XPY_MI_DISCOUNT_PERCENTAGE","Discount Percentage");
	define("_XPY_MI_DISCOUNT_PERCENTAGE_DESC","Default percentage for a discount.");
	define("_XPY_MI_DISCOUNT_REDEEMS","Discount Redeems");
	define("_XPY_MI_DISCOUNT_REDEEMS_DESC","Default number of time a code can be redeemed on a discount.");
	define("_XPY_MI_DISCOUNT_AMOUNT","Apply discount to total value amount of items.");
	define("_XPY_MI_DISCOUNT_AMOUNT_DESC","This is whether you want to apply the discount to amount of the item.");
	define("_XPY_MI_DISCOUNT_SHIPPING","Apply discount to shipping value.");
	define("_XPY_MI_DISCOUNT_SHIPPING_DESC","This is whether you want to apply the discount to the shipping of the item.");
	define("_XPY_MI_DISCOUNT_HANDLING","Apply discount to handling value.");
	define("_XPY_MI_DISCOUNT_HANDLING_DESC","This is whether you want to apply the discount to the handling of the item.");
	define("_XPY_MI_REMINDER_RESENT_IN","Reminder Emails Need to wait between discount emails this many seconds");
	define("_XPY_MI_REMINDER_RESENT_IN_DESC","How long in seconds it waits for before sending another email like a reminder about a discount code.");
	// Admin menu
	define("_XPY_ADMENU7","Discount\'s");
	// Version 1.38
	// Admin Menus
	define("_XPY_ADMENU8","Dashboard");
	define("_XPY_ADMENU9","About");
	//  Version 1.45
	define("_XPY_MI_SECS_TOPAYMENT","Number of Seconds to Cut to Payment when specified.");
	define("_XPY_MI_SECS_TOPAYMENT_DESC","When \$_POST['topayment'] = true is set, cut to screen within this amount of time.");
	// Version 1.51
	define("_XPY_MI_ANNUM","Invoice Interest Annum");
	define("_XPY_MI_ANNUM_DESC","This is the period of time to wait on before charging interest on an unpaid invoice!");
	define("_XPY_MI_INTEREST_RATE","Default Interest Rate");
	define("_XPY_MI_INTEREST_RATE_DESC","This is the default interest rate charged per annum!");
	define("_XPY_MI_MANUALCODE","Prefix for manual payment reference!");
	define("_XPY_MI_MANUALCODE_DESC","This is the prefix for manual payment reference which is the invoice number and this prefix.");
?>