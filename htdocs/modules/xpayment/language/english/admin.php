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
	// Messages
	define("_XPY_MSG_GATEWAY_INSTALL","Gateway Installed Successfully!");
	define("_XPY_MSG_GATEWAY_UPDATED","Gateway Updated Successfully!");
	define("_XPY_MSG_OPTIONS_SAVED","Gateway Options Saved Successfully!");
	define("_XPY_MSG_TESTMODES_SAVED","Gateway Testmode Saved Successfully!");
	define("_XPY_MSG_INVOICE_PAID","Invoice Paid Successfully!");
	define("_XPY_MSG_INVOICE_CANCELED","Invoice Canceled Successfully!");
	define("_XPY_MSG_CONFIRM_CANCEL","Are you sure you wish to cancel this invoice?");	
	define("_XPY_MSG_RULE_SAVED","Group Rule Saved!");
	define("_XPY_MSG_CONFIRM_DELETE","Are you sure you wish to delete this rule?");
	define("_XPY_MSG_RULE_DELETED","Rule has been deleted!");	
	// Invoices Languages
	define("_XPY_AM_DONATION","Donation");
	define("_XPY_AM_CANCEL","Cancel Invoice");
	define("_XPY_AM_VIEW","View Invoice");
	define("_XPY_AM_TRANSACTIONS","Invoice Transactions");
	define("_XPY_AM_ACTIONS_TH","Actions");
	define("_XPY_AM_PAYMENT","Mark Paid");
	define("_XPY_AM_INVOICELIST_H1","Tax Invoice List");
	define("_XPY_AM_INVOICELIST_P","This is the list of generated invoices on the system, you can cancel unpaid invoices, view the invoice and transaction on an invoice.");
	define("_XPY_AM_TH_MODE","Status");
	define("_XPY_AM_TH_INVOICENUMBER","Invoice Number");
	define("_XPY_AM_TH_DRAWFOR","Drawn for");
	define("_XPY_AM_TH_DRAWTO","Drawn to");
	define("_XPY_AM_TH_DRAWTO_EMAIL","Drawn to");
	define("_XPY_AM_TH_AMOUNT","Amount");
	define("_XPY_AM_TH_GRAND","Grand total");
	define("_XPY_AM_TH_SHIPPING","Shipping");
	define("_XPY_AM_TH_HANDLING","Handling");
	define("_XPY_AM_TH_WEIGHT","Weight");
	define("_XPY_AM_TH_WEIGHT_UNIT","Weight Unit");
	define("_XPY_AM_TH_TAX","Tax");
	define("_XPY_AM_TH_CURRENCY","Currency");
	define("_XPY_AM_TH_ITEMS","Items");
	define("_XPY_AM_TH_TRANSACTIONID","Transaction ID");
	define("_XPY_AM_TH_CREATED","Created");
	define("_XPY_AM_TH_UPDATED","Updated");
	define("_XPY_AM_TH_ACTIONED","Made");
	define("_XPY_AM_TH_PLUGIN","Plugin");
	define("_XPY_AM_TH_UID","User");
	define("_XPY_AM_TH_LIMIT","Limited");
	define("_XPY_AM_TH_MINIMUM","Minimum Amount");
	define("_XPY_AM_TH_MAXIMUM","Maximum Amount");
	define("_XPY_AM_TH_REMITTION","Remittion");
	define("_XPY_AM_PAID","Amount Paid");
	define("_XPY_AM_ADDRULE","Add/Edit Group Rule");
	define("_XPY_AM_GROUP_FCT","Select Group");
	define("_XPY_AM_EDITGROUP","Edit Rule");
	define("_XPY_AM_DUE","Invoice Due");
	define("_XPY_AM_COLLECT","Invoice Collect on");	
	define("_XPY_AM_WAIT","Invoice Wait");
	define("_XPY_AM_OFFLINE","Invoice Offline");
	define("_XPY_AM_REOCCURRENCE_H2","Invoice Reoccurrence");
	define("_XPY_AM_REOCCURRENCE_P","This is the details on the reoccurrence of the invoice.");
	define("_XPY_AM_REOCCURRENCE","Number of Reoccurrences");
	define("_XPY_AM_REOCCURRENCES","Number of Occurrences");
	define("_XPY_AM_PERIOD","Invoice Reoccurrence Occurs Every");
	define("_XPY_AM_DAYS","Days");
	define("_XPY_AM_PREVIOUS","Previous Occurrence");
	define("_XPY_AM_OCCURRENCE","Next Occurrence");
	define("_XPY_AM_OCCURRENCE_PAID_TH","Paid");
	define("_XPY_AM_OCCURRENCE_LEFT_TH","Left");
	define("_XPY_AM_OCCURRENCE_TOTAL_TH","Total");
	define("_XPY_AM_OCCURRENCE_GRAND","Grand Total");
	define("_XPY_AM_OCCURRENCE_AMOUNT","Amount");
	define("_XPY_AM_OCCURRENCE_SHIPPING","Shipping");
	define("_XPY_AM_OCCURRENCE_HANDLING","Handling");
	define("_XPY_AM_OCCURRENCE_TAX","Tax");
	define("_XPY_AM_REOCCURRENCE_ONGOING","Invoice Ongoing");
	define("_XPY_AM_MAKEPAYMENT_MANUAL","Manual Bank Payment");
	define("_XPY_AM_MAKEPAYMENT_ONLINE","Online Instant Payment");	
	define("_XPY_AM_SETTLE_H2","Mark for settlement");
	define("_XPY_AM_SETTLE_P","If an invoice is under Notice or Collection you can mark it for settlement which is a value other than the amount it is worth.");
	define("_XPY_AM_REMITTION","Remittion Mode");
	define("_XPY_AM_REMITTED","Remittion Date");
	//Groups
	define("_XPY_AM_GROUP_BROKERS","Brokers");
	define("_XPY_AM_GROUP_ACCOUNTS","Accountants");
	define("_XPY_AM_GROUP_OFFICERS","Collection Officers");
	//Transactions Language
	define("_XPY_AM_EMAIL","Business Email");
	define("_XPY_AM_INVOICE","Invoice Id");
	define("_XPY_AM_CUSTOM","Custom Key");
	define("_XPY_AM_STATUS","Status");
	define("_XPY_AM_DATE","Date");
	define("_XPY_AM_GROSS","Gross");
	define("_XPY_AM_FEE","Fee");
	define("_XPY_AM_SETTLE","Settlement");
	define("_XPY_AM_EXCHANGERATE","Exchange Rate");
	define("_XPY_AM_FIRSTNAME","Firstname");
	define("_XPY_AM_LASTNAME","Lastname");
	define("_XPY_AM_STREET","Street");
	define("_XPY_AM_CITY","City");
	define("_XPY_AM_STATE","State");
	define("_XPY_AM_POSTCODE","Postcode");
	define("_XPY_AM_COUNTRY","Country");
	define("_XPY_AM_ADDRESSSTATUS","Address Status");
	define("_XPY_AM_PAYEREMAIL","Payer Email");
	define("_XPY_AM_PAYERSTATUS","Payer Status");
	define("_XPY_AM_GATEWAY","Gateway");
	define("_XPY_AM_PLUGIN","Plugin");
	define("_XPY_AM_TRANSACTION_H1","Transaction");
	define("_XPY_AM_TRANSACTION_P","This is the transaction you wanted to view.");
	define("_XPY_AM_VIEWTRANSACTION","View Transaction");
	define("_XPY_AM_VIEWINVOICE","View Invoice");
	define("_XPY_AM_TRANSACTIONSLIST_H1","Transactions List");
	define("_XPY_AM_TRANSACTIONSLIST_P","This is the list of generated transaction headers on the system, you can cancel unpaid invoices, view the transaction on an invoice.");
	// Table Header
	define("_XPY_AM_TH_INVOICE","Invoice ID");
	define("_XPY_AM_TH_EMAIL","Business Email");
	define("_XPY_AM_TH_STATUS","Status");
	define("_XPY_AM_TH_DATE","Date");
	define("_XPY_AM_TH_GROSS","Gross");
	define("_XPY_AM_TH_FEE","Fee");
	define("_XPY_AM_TH_SETTLE","Settled");
	define("_XPY_AM_TH_EXCHANGERATE","Exchange Rate");
	define("_XPY_AM_TH_FIRSTNAME","First Name");
	define("_XPY_AM_TH_LASTNAME","Last Name");
	define("_XPY_AM_TH_STREET","Street");
	define("_XPY_AM_TH_CITY","City");
	define("_XPY_AM_TH_STATE","State");
	define("_XPY_AM_TH_POSTCODE","Postcode");
	define("_XPY_AM_TH_COUNTRY","Country");
	define("_XPY_AM_TH_ADDRESS_STATUS","Address Status");
	define("_XPY_AM_TH_PAYER_EMAIL","Payer email");
	define("_XPY_AM_TH_PAYER_STATUS","Payer status");
	define("_XPY_AM_TH_GATEWAY","Gateway");
	//Invoice Language
	define("_XPY_AM_INVOICE_H1","Tax Invoice");
	define("_XPY_AM_INVOICE_P","This is your current invoice, to make payment see the options below.");
	define("_XPY_AM_INVOICENUMBER","Invoice number");
	define("_XPY_AM_DRAWNFOR","Drawn for");
	define("_XPY_AM_DRAWNTO","Drawn to");
	define("_XPY_AM_AMOUNT","Amount");
	define("_XPY_AM_CREATED","Created");
	define("_XPY_AM_MODE","Status");
	define("_XPY_AM_ITEMS","Items on Invoice");
	define("_XPY_AM_ACTIONED","Actioned");
	define("_XPY_AM_ITEMS_H2","Items being Invoiced");
	define("_XPY_AM_ITEMS_P","This are the items being invoiced.");
	define("_XPY_AM_CAT_TH","Cat. Number");
	define("_XPY_AM_NAME_TH","Description");
	define("_XPY_AM_QUANTITY_TH","Quantity");
	define("_XPY_AM_UNITAMOUUNT_TH","Unit amount");
	define("_XPY_AM_TOTALAMOUUNT_TH","Total amount");
	define("_XPY_AM_GRANDTOTAL_TD","Grand Total");
	define("_XPY_AM_MAKEPAYMENT_H2","Make Payment");
	define("_XPY_AM_MAKEPAYMENT_P","Below is the option for making payment.");
	define("_XPY_AM_TOTALSHIPPING","Total Shipping");
	define("_XPY_AM_TOTALHANDLING","Total Handling");
	define("_XPY_AM_TOTALTAX","Total Tax");
	define("_XPY_AM_TOTALWEIGHT","Total Weight");
	define("_XPY_AM_TAX_TH","Tax Rate");
	define("_XPY_AM_SHIPPING_TH","Shipping");
	define("_XPY_AM_HANDLING_TH","Handling");
	define("_XPY_AM_TOTALWEIGHT_TH","Total Weight");
	define("_XPY_AM_UNITWEIGHT_TH","Unit Weight");
	define("_XPY_AM_GRANDAMOUUNT_TH","Grand Sum");
	define("_XPY_AM_TOTALSHIPPING_TH","Total Shipping");
	define("_XPY_AM_TOTALHANDLING_TH","Total Handling");
	define("_XPY_AM_TOTALTAX_TH","Total Tax");
	define("_XPY_AM_BREAKDOWN_H2","Invoice Breakdown on Charges");
	define("_XPY_AM_BREAKDOWN_P","This is the invoice break down on shipping, handling, taxes and totals.");
	define("_XPY_AM_BREAKDOWN_PB","This is the invoice continuing to break down in totals.");
	define("_XPY_AM_BREAKDOWN_H2B","Totals Breakdown on Charges");
	define("_XPY_AM_GRANDAMOUNT","Total Grand Amount");
	define("_XPY_AM_RULEEDIT_H1","Edit Group Rule");
	define("_XPY_AM_RULEEDIT_P","You can edit the group rule from here.");
	define("_XPY_AM_GROUPS_H1","Group Rules");
	define("_XPY_AM_GROUPS_P","You can browse and edit the group rule from this list.");
	//Gateway Language
	define("_XPY_AM_TH_AUTHOR","Author");
	define("_XPY_AM_TH_NAME","Plugin Name");
	define("_XPY_AM_TH_DESCRIPTION","Description");
	define("_XPY_AM_TH_TESTMODE","Testmode");
	define("_XPY_AM_INSTALLEDGATEWAYS_H1","Installed Gateways");
	define("_XPY_AM_INSTALLEDGATEWAYS_P","This are all the installed gateways");
	define("_XPY_AM_UNINSTALLEDGATEWAYS_H1","Gateways Offline");
	define("_XPY_AM_UNINSTALLEDGATEWAYS_P","This is a list of the uninstalled gateways!");
	define("_XPY_AM_OPTIONSGATEWAY_H1","Gateway Option");
	define("_XPY_AM_OPTIONSGATEWAY_P","This are the options for the gateway!");
	define("_XPY_AM_EDITOPTIONS","Edit options");
	define("_XPY_AM_UPDATEGATEWAY","Update gateway");
	define("_XPY_AM_INSTALLGATEWAY","Install Gateway");
	//Enumerator Value/ID Enscapulation (Do Not Change)
	define("_XPY_ENUM_MODE_PAID", 1);
	define("_XPY_ENUM_MODE_CANCEL", 2);
	define("_XPY_ENUM_MODE_UNPAID", 3);
	define("_XPY_ENUM_REMITTION_NONE", 10);
	define("_XPY_ENUM_REMITTION_PENDING", 15);
	define("_XPY_ENUM_REMITTION_NOTICE", 20);
	define("_XPY_ENUM_REMITTION_COLLECT", 25);
	define("_XPY_ENUM_REMITTION_FRAUD", 30);
	define("_XPY_ENUM_REMITTION_SETTLED", 35);
	define("_XPY_ENUM_ITEMMODE_PURCHASED", 40);
	define("_XPY_ENUM_ITEMMODE_REFUNDED", 45);
	define("_XPY_ENUM_ITEMMODE_UNDELIVERED", 50);
	define("_XPY_ENUM_ITEMMODE_DAMAGED", 55);
	define("_XPY_ENUM_ITEMMODE_PENDING", 60);
	define("_XPY_ENUM_ITEMMODE_EXPRESS", 65);
	define("_XPY_ENUM_TRANSACTION_PAYMENT", 70);
	define("_XPY_ENUM_TRANSACTION_REFUND", 75);
	define("_XPY_ENUM_TRANSACTION_PENDING", 80);
	define("_XPY_ENUM_TRANSACTION_NOTICE", 85);
	define("_XPY_ENUM_TRANSACTION_OTHER", 90);
	//permissions
	define("_XPY_AM_PERM_FCT","Permission Type");
	define("_XPY_AM_PERM_EMAIL","Email Transmission");
	define("_XPY_AM_PERM_GATEWAYS","Access to Gateway");
	define("_XPY_AM_PERM_TITLE_EMAIL","Emails that will be sent and who to!");
	define("_XPY_AM_PERM_NAME_EMAIL","email");
	define("_XPY_AM_PERM_DESC_EMAIL","From here you can set which emails and sub-email will send to what groups and people!");
	define("_XPY_AM_PERM_TITLE_GATEWAY","Gateways that are accessable!");
	define("_XPY_AM_PERM_NAME_GATEWAY","gateway");
	define("_XPY_AM_PERM_DESC_GATEWAY","From here you can set which gateways a user belonging to a group can access and select!");
	define("_XPY_AM_MODE_DESC_PAID","Paid Invoice");
	define("_XPY_AM_MODE_DESC_UNPAID","Unpaid Invoice");
	define("_XPY_AM_MODE_DESC_CANCEL","Canceled Invoice");
	define("_XPY_AM_MODE_DESC_PAID_NONE","No Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_NONE","No Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_NONE","No Remittence (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_PENDING","Pending Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_PENDING","Pending Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_PENDING","Pending Remittence (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_NOTICE","Overdue Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_NOTICE","Overdue Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_NOTICE","Overdue Remittence (Cancel Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_COLLECT","Collect Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_COLLECT","Collect Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_COLLECT","Collect Remittence (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_FRAUD","Fraud Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_FRAUD","Fraud Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_FRAUD","Fraud Remittence (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_SETTLED","Settled Remittence (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_SETTLED","Settled Remittence (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_SETTLED","Settled Remittence (Cancel Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_PURCHASED","Item Purchased (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_PURCHASED","Item Purchased (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_PURCHASED","Item Purchased (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_REFUNDED","Item Refunded (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_REFUNDED","Item Refunded (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_REFUNDED","Item Refunded (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_UNDELIVERED","Item Undelivered (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_UNDELIVERED","Item Undelivered (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_UNDELIVERED","Item Undelivered (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_DAMAGED","Item Damaged (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_DAMAGED","Item Damaged (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_DAMAGED","Item Damaged (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_PENDING","Item Pending (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_PENDING","Item Pending (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_PENDING","Item Pending (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_ITEM_EXPRESS","Item Express Delievery (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_ITEM_EXPRESS","Item Express Delievery (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_ITEM_EXPRESS","Item Express Delievery (Canceled Invoice)");	
	define("_XPY_AM_MODE_DESC_PAID_TRANSACTION_PAYMENT","Transaction Payment (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PAYMENT","Transaction Payment (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PAYMENT","Transaction Payment (Cancel Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_TRANSACTION_REFUND","Transaction Refund (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_TRANSACTION_REFUND","Transaction Refund (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_TRANSACTION_REFUND","Transaction Refund (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_TRANSACTION_PENDING","Transaction Pending (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PENDING","Transaction Pending (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PENDING","Transaction Pending (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_TRANSACTION_NOTICE","Transaction Notice (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_TRANSACTION_NOTICE","Transaction Notice (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_TRANSACTION_NOTICE","Transaction Notice (Canceled Invoice)");
	define("_XPY_AM_MODE_DESC_PAID_TRANSACTION_OTHER","Transaction Other (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_TRANSACTION_OTHER","Transaction Other (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_TRANSACTION_OTHER","Transaction Other (Canceled Invoice)");
	//Version 1.33
	//Messages
	define("_XPY_MSG_TAX_SAVED","Tax rates in current list saved!");
	//Tax List
	define("_XPY_AM_TH_CODE","Code");
	define("_XPY_AM_TH_RATE","Perentile Tax Rate");
	define("_XPY_AM_TAX_H1","Automatic Tax Rates");
	define("_XPY_AM_TAX_P","These automatic tax rates are based on user IP addresses and requires an IPDB API Key to be specified in the preferences of the module.");
	//Version 1.35
	//Headers
	define("_XPY_AM_NEWDISCOUNTS_H1","Create New Discounts");
	define("_XPY_AM_NEWDISCOUNTS_P","From here you can create and issue new discounts to people.");
	define("_XPY_AM_DISCOUNTS_H1","Discounts");
	define("_XPY_AM_DISCOUNTS_P","This is the current list of discounts that are on the system, you can filter and browse them from here.");
	define("_XPY_AM_EXPORT_INVOICELIST_A","Export Invoice List in *.CSV (includes filters)");
	// Table Headers
	define("_XPY_AM_TH_DID","Discount ID");
	define("_XPY_AM_TH_VALIDTILL","Valid Till");
	define("_XPY_AM_TH_REDEEMS","Redeems");
	define("_XPY_AM_TH_DISCOUNT","Discount");
	define("_XPY_AM_TH_REDEEMED","Redeemed");
	define("_XPY_AM_TH_DISCOUNT_AMOUNT","Discount Amount");
	//Permissions
	define("_XPY_AM_MODE_DESC_PAID_DISCOUNTED","Discounted (Paid Invoice)");
	define("_XPY_AM_MODE_DESC_UNPAID_DISCOUNTED","Discounted (Unpaid Invoice)");
	define("_XPY_AM_MODE_DESC_CANCEL_DISCOUNTED","Discounted (Canceled Invoice)");
	//Forms
	define("_XPY_AM_CREATE_DISCOUNT_CODES","Create More Discount Codes");
	define("_XPY_AM_PREFIX_DISCOUNT_CODE","Prefix for discount code");
	define("_XPY_AM_AMOUNT_DISCOUNT_CODE","Percentile of discount");
	define("_XPY_AM_REDEEMS_DISCOUNT_CODE","Number of time coupon can be redeemed");
	define("_XPY_AM_VALIDTILL_DISCOUNT_CODE","Valid Till");
	define("_XPY_AM_VALIDTILL_NEVERTIMEOUT_DISCOUNT_CODE","Never Timeout:");
	define("_XPY_AM_EMAILS_DISCOUNT_CODE","Emails to assign coupon to");
	define("_XPY_AM_EMAILS_DISCOUNT_CODE_DESC","Emails Seperated with a pipe symbol");
	define("_XPY_AM_SCAN_DISCOUNT_CODE","Scan Userbase and apply the following for discount coupons.");
	define("_XPY_AM_SINCE_DISCOUNT_CODE","Registered Since");
	define("_XPY_AM_LOGON_DISCOUNT_CODE","Logged on Since");
	define("_XPY_AM_GROUPS_DISCOUNT_CODE","Groups for discount");
	// Messages
	define("_XPY_MSG_DISCOUNT_NOREDEEMS_SPECIFIED","No valid numeric redeems value specified!");
	define("_XPY_MSG_DISCOUNT_NODISCOUNT_SPECIFIED","No valid numeric discount percentile value specified, can have ricipricol!");
	define("_XPY_MSG_DISCOUNT_CREATED_REMINDED","Created %s discount code successfully, sent %s reminders about existing codes!");
	// Emails
	define("_XPY_EMAIL_DISCOUNT_SUBJECT","Congradulations! A discount coupon worth %discount% valid upto %left!");
	define("_XPY_EMAIL_DISCOUNT_MORE_REDEEMS_SUBJECT","Your discount coupon for %discount% has %left goes left on other invoices!");
	define("_XPY_EMAIL_DISCOUNT_REMINDER_SUBJECT","Just a reminder your coupon for %discount% has %left goes left on other invoices!");
	// Tokens
	define("_XPY_AM_DISCOUNT_FOREVER","Forever");
	// Enumeration ID Values (Do Not change)
	define("_XPY_ENUM_REMITTION_DISCOUNTED", 95);
	// Version 1.38
	// Dashboard
	define("_XPY_AM_INVOICES_ASTOTALING","All Records Totaling");
	define("_XPY_AM_INVOICES_LAST12MONTHS","Records over last 12 Months");
	define("_XPY_AM_INVOICES_LAST6MONTHS","Records over last 6 Months");
	define("_XPY_AM_INVOICES_LAST3MONTHS","Records over last 3 Months");
	define("_XPY_AM_INVOICES_LAST1MONTHS","Records over last 1 Months");
	define("_XPY_AM_INVOICES_FROM","Records Created From: %s");
	define("_XPY_AM_INVOICES_TO","Records Created Upto: %s");
	define("_XPY_AM_INVOICES_SUM_TOTAL","Sum of %s in the currency of %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID","Sum of Unpaid Invoices: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID","Sum of Paid Invoices: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED","Sum of Cancelled Invoices: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_NONE","Sum of Unpaid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_NONE","Sum of Paid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_NONE","Sum of Cancelled Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_COLLECT","Sum of Unpaid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_COLLECT","Sum of Paid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_COLLECT","Sum of Cancelled Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_FRAUD","Sum of Unpaid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_FRAUD","Sum of Paid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_FRAUD","Sum of Cancelled Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_SETTLED","Sum of Unpaid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_SETTLED","Sum of Paid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_SETTLED","Sum of Cancelled Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_DISCOUNTED","Sum of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_DISCOUNTED","Sum of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_DISCOUNTED","Sum of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_DISCOUNTED_AMOUNT","Sum Discounted Amount of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_DISCOUNTED_AMOUNT","Sum Discounted Amount of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_DISCOUNTED_AMOUNT","Sum Discounted Amount of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_SUMARE_UNPAID_DONATED","Sum of Unpaid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_SUMARE_PAID_DONATED","Sum of Paid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_SUMARE_CANCELLED_DONATED","Sum of Cancelled Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_TAX_TOTAL","Sum of Tax of %s in the currency of %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID","Sum of Tax of Unpaid Invoices: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID","Sum of Tax of Paid Invoices: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED","Sum of Tax of Cancelled Invoices: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_NONE","Sum of Tax of Unpaid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_NONE","Sum of Tax of Paid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_NONE","Sum of Tax of Cancelled Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_COLLECT","Sum of Tax of Unpaid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_COLLECT","Sum of Tax of Paid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_COLLECT","Sum of Tax of Cancelled Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_FRAUD","Sum of Tax of Unpaid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_FRAUD","Sum of Tax of Paid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_FRAUD","Sum of Tax of Cancelled Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_SETTLED","Sum of Tax of Unpaid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_SETTLED","Sum of Tax of Paid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_SETTLED","Sum of Tax of Cancelled Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_DISCOUNTED","Sum of Tax of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_DISCOUNTED","Sum of Tax of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_DISCOUNTED","Sum of Tax of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_TAXARE_UNPAID_DONATED","Sum of Tax of Unpaid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_TAXARE_PAID_DONATED","Sum of Tax of Paid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_TAXARE_CANCELLED_DONATED","Sum of Tax of Cancelled Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_MAX_TOTAL","Maximum Value of %s in the currency of %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID","Maximum Value of Unpaid Invoices: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID","Maximum Value of Paid Invoices: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED","Maximum Value of Cancelled Invoices: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_NONE","Maximum Value of Unpaid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_NONE","Maximum Value of Paid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_NONE","Maximum Value of Cancelled Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_COLLECT","Maximum Value of Unpaid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_COLLECT","Maximum Value of Paid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_COLLECT","Maximum Value of Cancelled Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_FRAUD","Maximum Value of Unpaid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_FRAUD","Maximum Value of Paid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_FRAUD","Maximum Value of Cancelled Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_SETTLED","Maximum Value of Unpaid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_SETTLED","Maximum Value of Paid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_SETTLED","Maximum Value of Cancelled Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_DISCOUNTED","Maximum Value of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_DISCOUNTED","Maximum Value of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_DISCOUNTED","Maximum Value of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_DISCOUNTED_AMOUNT","Maximum Value Discounted Amount of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_DISCOUNTED_AMOUNT","Maximum Value Discounted Amount of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_DISCOUNTED_AMOUNT","Maximum Value Discounted Amount of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_MAXARE_UNPAID_DONATED","Maximum Value of Unpaid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_MAXARE_PAID_DONATED","Maximum Value of Paid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_MAXARE_CANCELLED_DONATED","Maximum Value of Cancelled Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_AVG_TOTAL","Average Value of %s in the currency of %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID","Average Value of Unpaid Invoices: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID","Average Value of Paid Invoices: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED","Average Value of Cancelled Invoices: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_NONE","Average Value of Unpaid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_NONE","Average Value of Paid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_NONE","Average Value of Cancelled Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_COLLECT","Average Value of Unpaid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_COLLECT","Average Value of Paid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_COLLECT","Average Value of Cancelled Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_FRAUD","Average Value of Unpaid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_FRAUD","Average Value of Paid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_FRAUD","Average Value of Cancelled Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_SETTLED","Average Value of Unpaid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_SETTLED","Average Value of Paid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_SETTLED","Average Value of Cancelled Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_DISCOUNTED","Average Value of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_DISCOUNTED","Average Value of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_DISCOUNTED","Average Value of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_DISCOUNTED_AMOUNT","Average Value Discounted Amount of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_DISCOUNTED_AMOUNT","Average Value Discounted Amount of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_DISCOUNTED_AMOUNT","Average Value Discounted Amount of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_AVGARE_UNPAID_DONATED","Average Value of Unpaid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_AVGARE_PAID_DONATED","Average Value of Paid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_AVGARE_CANCELLED_DONATED","Average Value of Cancelled Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_COUNTS_TOTAL","Count of Records which are %s in the currency of %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID","Count of Records which are Unpaid Invoices: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID","Count of Records which are Paid Invoices: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED","Count of Records which are Cancelled Invoices: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_NONE","Count of Records which are Unpaid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_NONE","Count of Records which are Paid Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_NONE","Count of Records which are Cancelled Invoices with No Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_PENDING","Count of Records which are Unpaid Invoices with Pending Payment Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_PENDING","Count of Records which are Paid Invoices with Pending Payment Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_PENDING","Count of Records which are Cancelled Invoices with Pending Payment Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_NOTICE","Count of Records which are Unpaid Invoices with Notice Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_NOTICE","Count of Records which are Paid Invoices with Notice Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_NOTICE","Count of Records which are Cancelled Invoices with Notice Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_COLLECT","Count of Records which are Unpaid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_COLLECT","Count of Records which are Paid Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_COLLECT","Count of Records which are Cancelled Invoices with Collection Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_FRAUD","Count of Records which are Unpaid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_FRAUD","Count of Records which are Paid Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_FRAUD","Count of Records which are Cancelled Invoices with Fradulent Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_SETTLED","Count of Records which are Unpaid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_SETTLED","Count of Records which are Paid Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_SETTLED","Count of Records which are Cancelled Invoices with Settled Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_DISCOUNTED","Count of Records which are Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_DISCOUNTED","Count of Records which are Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_DISCOUNTED","Count of Records which are Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_DISCOUNTED_AMOUNT","Sum Discounted Amount of Unpaid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_DISCOUNTED_AMOUNT","Sum Discounted Amount of Paid Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_DISCOUNTED_AMOUNT","Sum Discounted Amount of Cancelled Invoices with Discounted Flagged Remittion: %s");
	define("_XPY_AM_INVOICES_THEREARE_UNPAID_DONATED","Count of Records which are Unpaid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_THEREARE_PAID_DONATED","Count of Records which are Paid Invoices which are a Donation: %s");
	define("_XPY_AM_INVOICES_THEREARE_CANCELLED_DONATED","Count of Records which are Cancelled Invoices which are a Donation: %s");
	// Invoice List
	define("_XPY_AM_USER_INVOICE","User Invoice");
	define("_XPY_AM_USER_PDF","Invoice PDF");
	define("_XPY_AM_RESEND_NOTICE","Resend Payment Email");
	//  Emails
	define("_XPY_EMAIL_REMINDER_SUBJECT","Reminder of a Generated Invoice for %s %s drawn to %s!");
	// VErsion 1.51
	define("_XPY_AM_TH_INTEREST","Interest Charged");
	define("_XPY_AM_INVOICES_SUMARE_INTEREST","Sum of interest earned: %s");
	define("_XPY_AM_XPAYMENT_ABOUT_MAKEDONATE","Make XPayment Better Donate Today!");
?>