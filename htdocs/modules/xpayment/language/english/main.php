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

	// JSON Messages
	define('_XPY_VALIDATE_PASSKEYFAILED', '<strong>Passkey is old please refresh the page to get a new passkey</strong>');
	
	//Gateway Messages
	define('_XPY_MF_FEE', 'Additional Fee:&nbsp;');
	define('_XPY_MF_DEPOSIT', 'Additional Security Deposit:&nbsp;');
	define('_XPY_MF_ITEMNAME', 'Item Name:&nbsp;');
	define('_XPY_MF_TOTAL', 'Grand Total:&nbsp;');
	
	//Invoice Language
	define('_XPY_MF_MAKEPAYMENT_SELECTGATEWAY', 'Select Payment Gateway');
	define('_XPY_MSG_INVOICE_PAID', 'Invoice Marked Paid!');
	define('_XPY_MF_DONATION', 'Donation');
	define('_XPY_MF_INVOICE_H1', 'Tax Invoice');
	define('_XPY_MF_INVOICE_P', 'This is your current invoice, to make payment see the options below.');
	define('_XPY_MF_INVOICENUMBER', 'Invoice number');
	define('_XPY_MF_DRAWNFOR', 'Drawn for');
	define('_XPY_MF_DRAWNTO', 'Drawn to');
	define('_XPY_MF_AMOUNT', 'Amount');
	define('_XPY_MF_CREATED', 'Created');
	define('_XPY_MF_MODE', 'Status');
	define('_XPY_MF_ITEMS', 'Items on Invoice');
	define('_XPY_MF_ACTIONED', 'Actioned');
	define('_XPY_MF_ITEMS_H2', 'Items being Invoiced');
	define('_XPY_MF_ITEMS_P', 'This is the items being invoiced.');
	define('_XPY_MF_CAT_TH', 'Cat. Number');
	define('_XPY_MF_NAME_TH', 'Description');
	define('_XPY_MF_QUANTITY_TH', 'Quantity');
	define('_XPY_MF_UNITAMOUUNT_TH', 'Unit amount');
	define('_XPY_MF_TOTALAMOUUNT_TH', 'Total amount');
	define('_XPY_MF_GRANDTOTAL_TD', 'Grand Total');
	define('_XPY_MF_MAKEPAYMENT_H2', 'Make Payment');
	define('_XPY_MF_MAKEPAYMENT_P', 'Below is the option for making payment.');
	define('_XPY_MF_TOTALSHIPPING', 'Total Shipping');
	define('_XPY_MF_TOTALHANDLING', 'Total Handling');
	define('_XPY_MF_TOTALTAX', 'Total Tax');
	define('_XPY_MF_TOTALWEIGHT', 'Total Weight');
	define('_XPY_MF_TAX_TH', 'Tax Rate');
	define('_XPY_MF_SHIPPING_TH', 'Shipping');
	define('_XPY_MF_HANDLING_TH', 'Handling');
	define('_XPY_MF_TOTALWEIGHT_TH', 'Total Weight');
	define('_XPY_MF_UNITWEIGHT_TH', 'Unit Weight');
	define('_XPY_MF_GRANDAMOUUNT_TH', 'Grand Sum');
//	define('_XPY_MF_TOTALAMOUUNT_TH', 'Total Amount');
	define('_XPY_MF_TOTALSHIPPING_TH', 'Total Shipping');
	define('_XPY_MF_TOTALHANDLING_TH', 'Total Handling');
	define('_XPY_MF_TOTALTAX_TH', 'Total Tax');
	define('_XPY_MF_BREAKDOWN_H2', 'Invoice Breakdown on Charges');
	define('_XPY_MF_BREAKDOWN_P', 'This is the invoice break down on shipping, handling, taxes and totals.');
	define('_XPY_MF_BREAKDOWN_PB','This is the invoice continuing to break down in totals.');
	define('_XPY_MF_BREAKDOWN_H2B', 'Totals Breakdown on Charges');
	define('_XPY_MF_GRANDAMOUNT', 'Total Grand Amount');
	define('_XPY_MF_PAID', 'Amount Paid');
	
	// Invoices Languages
	define('_XPY_MF_CANCEL', 'Cancel Invoice');
	define('_XPY_MF_VIEW', 'View Invoice');
	define('_XPY_MF_TRANSACTIONS', 'Invoice Transactions');
	define('_XPY_MF_ACTIONS_TH', 'Actions');
	define('_XPY_MF_PAYMENT', 'Mark Paid');
	define('_XPY_MF_INVOICELIST_H1', 'Tax Invoice List');
	define('_XPY_MF_INVOICELIST_P', 'This is the list of generated invoices on the system, you can cancel unpaid invoices, view the invoice and transaction on an invoice.');
	define('_XPY_MF_TH_MODE', 'Status');
	define('_XPY_MF_TH_INVOICENUMBER', 'Invoice Number');
	define('_XPY_MF_TH_DRAWFOR', 'Drawn for');
	define('_XPY_MF_TH_DRAWTO', 'Drawn to');
	define('_XPY_MF_TH_DRAWTO_EMAIL', 'Drawn to');
	define('_XPY_MF_TH_AMOUNT', 'Amount');
	define('_XPY_MF_TH_GRAND', 'Grand total');
	define('_XPY_MF_TH_SHIPPING', 'Shipping');
	define('_XPY_MF_TH_HANDLING', 'Handling');
	define('_XPY_MF_TH_WEIGHT', 'Weight');
	define('_XPY_MF_TH_WEIGHT_UNIT', 'Weight Unit');
	define('_XPY_MF_TH_TAX', 'Tax');
	define('_XPY_MF_TH_CURRENCY', 'Currency');
	define('_XPY_MF_TH_ITEMS', 'Items');
	define('_XPY_MF_TH_TRANSACTIONID', 'Transaction ID');
	define('_XPY_MF_TH_CREATED', 'Created');
	define('_XPY_MF_TH_UPDATED', 'Updated');
	define('_XPY_MF_TH_ACTIONED', 'Made');
	define('_XPY_MF_TH_PLUGIN', 'Plugin');
	define('_XPY_MF_TH_UID', 'User');
	define('_XPY_MF_TH_LIMIT', 'Limited');
	define('_XPY_MF_TH_MINIMUM', 'Minimum Amount');
	define('_XPY_MF_TH_MAXIMUM', 'Maximum Amount');
	define('_XPY_MF_TH_REMITTION', 'Remittion');
//	define('_XPY_MF_PAID', 'Amount Paid');
	define('_XPY_MF_ADDRULE', 'Add/Edit Group Rule');
	define('_XPY_MF_GROUP_FCT', 'Select Group');
	define('_XPY_MF_EDITGROUP', 'Edit Rule');
	define('_XPY_MF_DUE', 'Invoice Due');
	define('_XPY_MF_COLLECT', 'Invoice Collect on');	
	define('_XPY_MF_WAIT', 'Invoice Wait');
	define('_XPY_MF_OFFLINE', 'Invoice Offline');
	define('_XPY_MF_REOCCURRENCE_H2', 'Invoice Reoccurrence');
	define('_XPY_MF_REOCCURRENCE_P', 'This are the details on the reoccurrence of the invoice.');
	define('_XPY_MF_REOCCURRENCE', 'Number of Reoccurrences');
	define('_XPY_MF_REOCCURRENCES', 'Number of Occurrences');
	define('_XPY_MF_PERIOD', 'Invoice Reoccurrence Occurs Every');
	define('_XPY_MF_DAYS', 'Days');
	define('_XPY_MF_PREVIOUS', 'Previous Occurrence');
	define('_XPY_MF_OCCURRENCE', 'Next Occurrence');
	define('_XPY_MF_OCCURRENCE_PAID_TH', 'Paid');
	define('_XPY_MF_OCCURRENCE_LEFT_TH', 'Left');
	define('_XPY_MF_OCCURRENCE_TOTAL_TH', 'Total');
	define('_XPY_MF_OCCURRENCE_GRAND', 'Grand Total');
	define('_XPY_MF_OCCURRENCE_AMOUNT', 'Amount');
	define('_XPY_MF_OCCURRENCE_SHIPPING', 'Shipping');
	define('_XPY_MF_OCCURRENCE_HANDLING', 'Handling');
	define('_XPY_MF_OCCURRENCE_TAX', 'Tax');
	define('_XPY_MF_REOCCURRENCE_ONGOING', 'Invoice Ongoing');
	define('_XPY_MF_MAKEPAYMENT_MANUAL', 'Manual Bank Payment');
	define('_XPY_MF_MAKEPAYMENT_ONLINE', 'Online Instant Payment');	
	define('_XPY_MF_SETTLE_H2', 'Mark for settlement');
	define('_XPY_MF_SETTLE_P', 'If an invoice is under Notice or Collection you can mark it for settlement which is a value other than the amount it is worth.');
	define('_XPY_MF_REMITTION', 'Remittion Mode');
	define('_XPY_MF_REMITTED', 'Remittion Date');
	
	//Transactions Language
	define('_XPY_MF_EMAIL', 'Business Email');
	define('_XPY_MF_INVOICE', 'Invoice Id');
	define('_XPY_MF_CUSTOM', 'Custom Key');
	define('_XPY_MF_STATUS', 'Status');
	define('_XPY_MF_DATE', 'Date');
	define('_XPY_MF_GROSS', 'Gross');
//	define('_XPY_MF_FEE', 'Fee');
	define('_XPY_MF_SETTLE', 'Settlement');
	define('_XPY_MF_EXCHANGERATE', 'Exchange Rate');
	define('_XPY_MF_FIRSTNAME', 'Firstname');
	define('_XPY_MF_LASTNAME', 'Lastname');
	define('_XPY_MF_STREET', 'Street');
	define('_XPY_MF_CITY', 'City');
	define('_XPY_MF_STATE', 'State');
	define('_XPY_MF_POSTCODE', 'Postcode');
	define('_XPY_MF_COUNTRY', 'Country');
	define('_XPY_MF_ADDRESSSTATUS', 'Address Status');
	define('_XPY_MF_PAYEREMAIL', 'Payer Email');
	define('_XPY_MF_PAYERSTATUS', 'Payer Status');
	define('_XPY_MF_GATEWAY', 'Gateway');
	define('_XPY_MF_PLUGIN', 'Plugin');
	define('_XPY_MF_TRANSACTION_H1', 'Transaction');
	define('_XPY_MF_TRANSACTION_P', 'This is the transaction you wanted to view.');
	
	// Emails
	define('_XPY_EMAIL_CREATED_SUBJECT','Generated:: Invoice for %s %s drawn to %s!');
	define('_XPY_EMAIL_PAID_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_NONE_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_NONE_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_NONE_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_PENDING_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_PENDING_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_PENDING_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_NOTICE_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_NOTICE_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_NOTICE_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_COLLECT_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_COLLECT_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_COLLECT_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_FRAUD_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_FRAUD_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_FRAUD_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_SETTLED_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_SETTLED_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_SETTLED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_PURCHASED_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_PURCHASED_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_PURCHASED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_REFUNDED_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_REFUNDED_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_REFUNDED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_UNDELIVERED_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_UNDELIVERED_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_UNDELIVERED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_DAMAGED_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_DAMAGED_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_DAMAGED_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_EXPRESS_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_EXPRESS_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_EXPRESS_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_TRANSACTION_PAYMENT_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_TRANSACTION_PAYMENT_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_TRANSACTION_PAYMENT_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_TRANSACTION_REFUND_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_TRANSACTION_REFUND_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_TRANSACTION_REFUND_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_TRANSACTION_PENDING_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_TRANSACTION_PENDING_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_TRANSACTION_PENDING_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_TRANSACTION_NOTICE_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_TRANSACTION_NOTICE_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_TRANSACTION_NOTICE_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	define('_XPY_EMAIL_PAID_TRANSACTION_OTHER_SUBJECT','Paid:: Invoice for %s %s drawn to %s has been marked paid!');
	define('_XPY_EMAIL_UNPAID_TRANSACTION_OTHER_SUBJECT','Unpaid:: Invoice for %s %s drawn to %s has been marked unpaid!');
	define('_XPY_EMAIL_CANCELED_TRANSACTION_OTHER_SUBJECT','Canceled:: Invoice for %s %s drawn to %s has been marked canceled!');
	
	//PDF Defines
	define('_XPY_PDF_MF_DONATION', 'Donation');
	define('_XPY_PDF_TITLE', 'Invoice from %s - Invoice %s');
	define('_XPY_PDF_SUBTITLE', 'Drawn to %s by %s to the amount of %s %s');
	define('_XPY_PDF_MF_SOURCE_H2', 'Online Source');
	define('_XPY_PDF_MF_SOURCE_P', 'The following URL\'s will allow you to browse this invoice');
	define('_XPY_PDF_MF_INVOICE_H1', 'Tax Invoice');
	define('_XPY_PDF_MF_INVOICE_P', 'This is your current invoice, to make payment see the options below.');
	define('_XPY_PDF_MF_INVOICENUMBER', 'Invoice number');
	define('_XPY_PDF_MF_DRAWNFOR', 'Drawn for');
	define('_XPY_PDF_MF_DRAWNTO', 'Drawn to');
	define('_XPY_PDF_MF_AMOUNT', 'Amount');
	define('_XPY_PDF_MF_CREATED', 'Created');
	define('_XPY_PDF_MF_MODE', 'Status');
	define('_XPY_PDF_MF_ITEMS', 'Items on Invoice');
	define('_XPY_PDF_MF_ACTIONED', 'Actioned');
	define('_XPY_PDF_MF_ITEMS_H2', 'Items being Invoiced');
	define('_XPY_PDF_MF_ITEMS_P', 'This is the items being invoiced.');
	define('_XPY_PDF_MF_CAT_TH', 'Cat. Number');
	define('_XPY_PDF_MF_NAME_TH', 'Description');
	define('_XPY_PDF_MF_QUANTITY_TH', 'Quantity');
	define('_XPY_PDF_MF_UNITAMOUUNT_TH', 'Unit amount');
	define('_XPY_PDF_MF_TOTALAMOUUNT_TH', 'Total amount');
	define('_XPY_PDF_MF_GRANDTOTAL_TD', 'Grand Total');
	define('_XPY_PDF_MF_MAKEPAYMENT_H2', 'Make Payment');
	define('_XPY_PDF_MF_MAKEPAYMENT_P', 'Below is the option for making payment.');
	define('_XPY_PDF_MF_TOTALSHIPPING', 'Total Shipping');
	define('_XPY_PDF_MF_TOTALHANDLING', 'Total Handling');
	define('_XPY_PDF_MF_TOTALTAX', 'Total Tax Paid');
	define('_XPY_PDF_MF_TOTALWEIGHT', 'Total Weight');
	define('_XPY_PDF_MF_TAX_TH', 'Tax Rate');
	define('_XPY_PDF_MF_SHIPPING_TH', 'Shipping');
	define('_XPY_PDF_MF_HANDLING_TH', 'Handling');
	define('_XPY_PDF_MF_TOTALWEIGHT_TH', 'Total Weight');
	define('_XPY_PDF_MF_UNITWEIGHT_TH', 'Unit Weight');
	define('_XPY_PDF_MF_TOTALTAX_TH', 'Tax Paid');
//	define('_XPY_PDF_MF_TOTALWEIGHT_TH', 'Total Weight');
//	define('_XPY_PDF_MF_UNITWEIGHT_TH', 'Unit Weight');
	define('_XPY_PDF_MF_GRANDAMOUUNT_TH', 'Grand Sum');
//	define('_XPY_PDF_MF_TOTALAMOUUNT_TH', 'Total Amount');
	define('_XPY_PDF_MF_TOTALSHIPPING_TH', 'Total Shipping');
	define('_XPY_PDF_MF_TOTALHANDLING_TH', 'Total Handling');
//	define('_XPY_PDF_MF_TOTALTAX_TH', 'Total Tax');
	define('_XPY_PDF_MF_BREAKDOWN_H2', 'Invoice Breakdown on Charges');
	define('_XPY_PDF_MF_BREAKDOWN_P', 'This is the invoice break down on shipping, handling, taxes and totals.');
	define('_XPY_PDF_MF_BREAKDOWN_H2B', 'Totals Breakdown on Charges');
	define('_XPY_PDF_MF_BREAKDOWN_PB','This is the invoice continuing to break down in totals.');
	define('_XPY_PDF_MF_GRANDAMOUNT', 'Total Grand Amount:');
	define('_XPY_PDF_MF_PAID', 'Amount Paid');
//	define('_XPY_PDF_MF_DONATION', 'Donation');
	define('_XPY_PDF_MF_DUE', 'Invoice Due');
	define('_XPY_PDF_MF_COLLECT', 'Invoice Collect on');	
	define('_XPY_PDF_MF_WAIT', 'Invoice Wait');
	define('_XPY_PDF_MF_OFFLINE', 'Invoice Offline');
	define('_XPY_PDF_MF_REOCCURRENCE_H2', 'Invoice Reoccurrence');
	define('_XPY_PDF_MF_REOCCURRENCE_P', 'This is the details on the reoccurrence of the invoice.');
	define('_XPY_PDF_MF_REOCCURRENCE', 'Number of Reoccurrences');
	define('_XPY_PDF_MF_REOCCURRENCES', 'Number of Occurrences');
	define('_XPY_PDF_MF_PERIOD', 'Invoice Reoccurrence Occurs Every');
	define('_XPY_PDF_MF_DAYS', 'Days');
	define('_XPY_PDF_MF_OCCURRENCE_PAID_TH', 'Paid');
	define('_XPY_PDF_MF_OCCURRENCE_LEFT_TH', 'Left');
	define('_XPY_PDF_MF_OCCURRENCE_TOTAL_TH', 'Total');
	define('_XPY_PDF_MF_OCCURRENCE_GRAND', 'Grand Total');
	define('_XPY_PDF_MF_OCCURRENCE_AMOUNT', 'Amount');
	define('_XPY_PDF_MF_OCCURRENCE_SHIPPING', 'Shipping');
	define('_XPY_PDF_MF_OCCURRENCE_HANDLING', 'Handling');
	define('_XPY_PDF_MF_OCCURRENCE_TAX', 'Tax');
	define('_XPY_PDF_MF_REOCCURRENCE_ONGOING', 'Invoice Ongoing');
	define('_XPY_PDF_MF_MAKEPAYMENT_MANUAL', 'Manual Bank Payment');
	define('_XPY_PDF_MF_MAKEPAYMENT_ONLINE', 'Online Instant Payment');	
	define('_XPY_PDF_MF_REMITTION', 'Remittion Mode');
	define('_XPY_PDF_MF_REMITTED', 'Remittion Date');
	
	// RESPONSE CODES
	define('_XPY_MF_RETURNED_H1', 'Transaction Approved');
	define('_XPY_MF_RETURNED_P', 'Your transaction has been approved for your convience!');
	
	define('_XPY_MF_CANCELED_H1', 'Transaction Canceled');
	define('_XPY_MF_CANCELED_P', 'You transaction has been canceled for your convience!');
	
	//Enumerator Value/ID Enscapulation (Do Not Change)
	define('_XPY_ENUM_MODE_PAID', 1);
	define('_XPY_ENUM_MODE_CANCEL', 2);
	define('_XPY_ENUM_MODE_UNPAID', 3);
	define('_XPY_ENUM_REMITTION_NONE', 10);
	define('_XPY_ENUM_REMITTION_PENDING', 15);
	define('_XPY_ENUM_REMITTION_NOTICE', 20);
	define('_XPY_ENUM_REMITTION_COLLECT', 25);
	define('_XPY_ENUM_REMITTION_FRAUD', 30);
	define('_XPY_ENUM_REMITTION_SETTLED', 35);
	define('_XPY_ENUM_ITEMMODE_PURCHASED', 40);
	define('_XPY_ENUM_ITEMMODE_REFUNDED', 45);
	define('_XPY_ENUM_ITEMMODE_UNDELIVERED', 50);
	define('_XPY_ENUM_ITEMMODE_DAMAGED', 55);
	define('_XPY_ENUM_ITEMMODE_PENDING', 60);
	define('_XPY_ENUM_ITEMMODE_EXPRESS', 65);
	define('_XPY_ENUM_TRANSACTION_PAYMENT', 70);
	define('_XPY_ENUM_TRANSACTION_REFUND', 75);
	define('_XPY_ENUM_TRANSACTION_PENDING', 80);
	define('_XPY_ENUM_TRANSACTION_NOTICE', 85);
	define('_XPY_ENUM_TRANSACTION_OTHER', 90);

	//Invoice Template
	define('_XPY_MN_CREATEINVOICE', 'Create An Invoice');
	define('_XPY_MN_CATELOUGUENUMBER', 'Catalogue Number');
	define('_XPY_MN_ITEMNAME', 'Item Name');
	define('_XPY_MN_UNITPRICE', 'Unit Price');
	define('_XPY_MN_QUANITY', 'Quanity');
	define('_XPY_MN_UNITSHIPPING', 'Unit Shipping');
	define('_XPY_MN_UNITHANDLING', 'Unit Handling');
	define('_XPY_MN_UNITWEIGHT', 'Unit Weight');
	define('_XPY_MN_TAX', 'Tax (%)');
	define('_XPY_MN_DRAWTO', 'Draw Invoice To (you):');
	define('_XPY_MN_DRAWTOEMAIL', 'Draw Invoice To Email (you):');
	define('_XPY_MN_INVOICE_H1', 'Draw Invoice');
	define('_XPY_MN_INVOICE_P', 'With the form below you can fill out an invoice for this website to pay.');
	define('_XPY_MN_INVOICE_P1', 'Currency:');
	
	// Version 1.33 RC2
	define('_XPY_VALIDATE_GATEWAY', 'Validate your gateway');
	
	// Version 1.35
	// Forms
	define('_XPY_MF_DISCOUNT', 'Have you got a discount code?');
	define('_XPY_MF_DISCOUNT_CODE', 'Discount Code');
	define('_XPY_MF_DISCOUNT_CODE_APPLIED', 'You have applied a discount code and you where discounted %discount% to the amount of %amount.');
	
	// Invoice
	define('_XPY_MF_DISCOUNTPERCENTILE', 'Discount Percentile');
	define('_XPY_MF_DISCOUNTAMOUNT', 'Discount Amount');
	define('_XPY_MF_APPLY_DISCOUNT_H2', 'Apply Discount');
	define('_XPY_MF_APPLY_DISCOUNT_P', 'From here you can enter a discount code, if you have been mailed one.');
	define('_XPY_MF_DISCOUNT_TD', 'Discount Amount');
	define('_XPY_MF_DISCOUNT_FOREVER', 'Forever');
		
	// Invoice PDF
	define('_XPY_PDF_MF_DISCOUNTPERCENTILE', 'Discount Percentile');
	define('_XPY_PDF_MF_DISCOUNTAMOUNT', 'Discount Amount');
	define('_XPY_PDF_MF_DISCOUNT_TD', 'Discount Amount');
	
	//Messages
	define('_XPY_MF_DISCOUNT_APPLIED_SUCCESSFULLY', 'Discount applied successfully you got %s% off which was a total amount of %s %s');
	define('_XPY_MF_DISCOUNT_APPLIED_UNSUCCESSFULLY', 'That is not a discount code! Try again!');
	
	//Enumeration IDS (do not change)
	define('_XPY_ENUM_REMITTION_DISCOUNTED', 95);
	
	// Version 1.51
	define('_XPY_MF_TOTALINTEREST', 'Total Interest & Rate:');
	define('_XPY_PDF_MF_TOTALINTEREST', 'Total Interest & Rate:');