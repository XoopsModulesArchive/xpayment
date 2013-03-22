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
 * @copyright       Chronolabs Co-Op http://www.chronolabs.com.au/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.com.au>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}


$modversion['dirname'] 		= basename(dirname(__FILE__));
$modversion['name'] 		= ucfirst(basename(dirname(__FILE__)));
$modversion['version']     	= "1.52";
$modversion['releasedate'] 	= "2012-08-21";

$modversion['description'] 	= _MI_XPY_DESC;
$modversion['credits']     	= _MI_XPY_CREDITS;
$modversion['author']      	= "Wishcraft, Aph3x, Mariane";
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0 or later';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html";
$modversion['official']    	= 0;
$modversion['image']       	= "images/xpayment_slogo.png";
$modversion['website']      = "www.chronolabs.com.au";

$modversion['system_dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['system_icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['system_icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['dirmoduleadmin2'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons162']        = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons322']        = '../../Frameworks/moduleclasses/icons/32';

$modversion['dirmoduleadmin'] = 'modules/xpayment';
$modversion['icons16'] = 'modules/xpayment/images/icons/16';
$modversion['icons32'] = 'modules/xpayment/images/icons/32';


$modversion['release_info'] = "Stable 2012/08/21";
$modversion['release_file'] = XOOPS_URL."/modules/xpayment/docs/changelog.txt";
$modversion['release_date'] = "2012/08/21";

$modversion['author_realname'] = "Simon Antony Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.com.au";
$modversion['author_website_name'] = "Chronolabs Australia";
$modversion['author_email'] = "simon@chronolabs.com.au";
$modversion['demo_site_url'] = "Chronolabs Australia";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://www.chronolabs.com.au/forums/viewforum.php?forum=30";
$modversion['support_site_name'] = "Chronolabs";
$modversion['submit_bug'] = "http://www.chronolabs.com.au/forums/viewforum.php?forum=30";
$modversion['submit_feature'] = "http://www.chronolabs.com.au/forums/viewforum.php?forum=30";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

//about
$modversion['release_date']        = '2013/02/02';
$modversion["module_website_url"]  = "www.xoops.org";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"]       = "Beta 1";
$modversion['min_php']             = '5.2';
$modversion['min_xoops']           = "2.5.5";
$modversion['min_admin']           = '1.1';
$modversion['min_db']              = array(
    'mysql'  => '5.0.7',
    'mysqli' => '5.0.7'
);


// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Main
$modversion['hasMain'] = 1;
$modversion['system_menu'] = 1;

$modversion['tables'][0] = 'xpayment_invoice_items';
$modversion['tables'][1] = 'xpayment_invoice';
$modversion['tables'][2] = 'xpayment_gateway_options';
$modversion['tables'][3] = 'xpayment_gateway';
$modversion['tables'][4] = 'xpayment_invoice_transactions';
$modversion['tables'][5] = 'xpayment_groups';
$modversion['tables'][6] = 'xpayment_autotax';
$modversion['tables'][7] = 'xpayment_discounts';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/main.php";
$modversion['adminmenu'] = "admin/menu.php";

// Install Script
$modversion['onInstall'] = "include/install.php";

// Update Script
$modversion['onUpdate'] = "include/onupdate.php";

// Update Script
$modversion['onUninstall'] = "include/uninstall.php";

xoops_load('XoopsLists');
$gateways = XoopsLists::getDirListAsArray($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'));
foreach($gateways as $gateway)
	$options[ucfirst($gateway)] = $gateway;
	
$i = 0;
// Config items
$i++;
$modversion['config'][$i]['name'] = 'gateway';
$modversion['config'][$i]['title'] = '_XPY_MI_GATEWAY';
$modversion['config'][$i]['description'] = '_XPY_MI_GATEWAY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'paypal';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'help';
$modversion['config'][$i]['title'] = '_XPY_MI_HELP';
$modversion['config'][$i]['description'] = '_XPY_MI_HELP_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'feecomphensate';
$modversion['config'][$i]['title'] = '_XPY_MI_FEECOMPHENSATE';
$modversion['config'][$i]['description'] = '_XPY_MI_FEECOMPHENSATE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'depositcomphensate';
$modversion['config'][$i]['title'] = '_XPY_MI_DEPOSITCOMPHENSATE';
$modversion['config'][$i]['description'] = '_XPY_MI_DEPOSITCOMPHENSATE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$options=array();
$options[_XPY_MI_SECONDS_1DAYS] = 60*60*24*1;
$options[_XPY_MI_SECONDS_3DAYS] = 60*60*24*3;
$options[_XPY_MI_SECONDS_7DAYS] = 60*60*24*7;
$options[_XPY_MI_SECONDS_14DAYS] = 60*60*24*14;
$options[_XPY_MI_SECONDS_30DAYS] = 60*60*24*30;
$options[_XPY_MI_SECONDS_60DAYS] = 60*60*24*60;
$options[_XPY_MI_SECONDS_90DAYS] = 60*60*24*90;
$options[_XPY_MI_SECONDS_180DAYS] = 60*60*24*180;
$options[_XPY_MI_SECONDS_270DAYS] = 60*60*24*270;
$options[_XPY_MI_SECONDS_365DAYS] = 60*60*24*365;

$i++;
$modversion['config'][$i]['name'] = 'annum';
$modversion['config'][$i]['title'] = '_XPY_MI_ANNUM';
$modversion['config'][$i]['description'] = '_XPY_MI_ANNUM_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*30;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'interest_rate';
$modversion['config'][$i]['title'] = '_XPY_MI_INTEREST_RATE';
$modversion['config'][$i]['description'] = '_XPY_MI_INTEREST_RATE_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '7.95';
$modversion['config'][$i]['options'] = array();


$i++;
$modversion['config'][$i]['name'] = 'due';
$modversion['config'][$i]['title'] = '_XPY_MI_DUE';
$modversion['config'][$i]['description'] = '_XPY_MI_DUE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*14;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'collect';
$modversion['config'][$i]['title'] = '_XPY_MI_COLLECT';
$modversion['config'][$i]['description'] = '_XPY_MI_COLLECT_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*30;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'wait';
$modversion['config'][$i]['title'] = '_XPY_MI_WAIT';
$modversion['config'][$i]['description'] = '_XPY_MI_WAIT_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*30;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'offline';
$modversion['config'][$i]['title'] = '_XPY_MI_OFFLINE';
$modversion['config'][$i]['description'] = '_XPY_MI_OFFLINE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*60;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'period';
$modversion['config'][$i]['title'] = '_XPY_MI_PERIOD';
$modversion['config'][$i]['description'] = '_XPY_MI_PERIOD_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*30;
$modversion['config'][$i]['options'] = $options;

$options=array();
$options[_XPY_MI_SECONDS_10] = 10;
$options[_XPY_MI_SECONDS_30] = 30;
$options[_XPY_MI_SECONDS_60] = 60;
$options[_XPY_MI_SECONDS_90] = 90;
$options[_XPY_MI_SECONDS_120] = 120;
$options[_XPY_MI_SECONDS_180] = 180;
$options[_XPY_MI_SECONDS_240] = 240;
$options[_XPY_MI_SECONDS_300] = 300;
$options[_XPY_MI_SECONDS_360] = 360;
$options[_XPY_MI_SECONDS_420] = 420;

$i++;
$modversion['config'][$i]['name'] = 'pause';
$modversion['config'][$i]['title'] = '_XPY_MI_PAUSE';
$modversion['config'][$i]['description'] = '_XPY_MI_PAUSE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'currency';
$modversion['config'][$i]['title'] = '_XPY_MI_CURRENCY';
$modversion['config'][$i]['description'] = '_XPY_MI_CURRENCY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'USD';

$i++;
$modversion['config'][$i]['name'] = 'weightunit';
$modversion['config'][$i]['title'] = '_XPY_MI_WEIGHTUNIT';
$modversion['config'][$i]['description'] = '_XPY_MI_WEIGHTUNIT_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'kgs';
$modversion['config'][$i]['options'] = array('kgs'=>'kgs', 'lbs'=>'lbs');

$groups_handler =& xoops_gethandler('group');
$i++;
$modversion['config'][$i]['name'] = 'brokers';
$modversion['config'][$i]['title'] = '_XPY_MI_BROKERS';
$modversion['config'][$i]['description'] = '_XPY_MI_BROKERS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_BROKER);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');

$i++;
$modversion['config'][$i]['name'] = 'accounts';
$modversion['config'][$i]['title'] = '_XPY_MI_ACCOUNTS';
$modversion['config'][$i]['description'] = '_XPY_MI_ACCOUNTS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_ACCOUNTS);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');	

$i++;
$modversion['config'][$i]['name'] = 'officers';
$modversion['config'][$i]['title'] = '_XPY_MI_OFFICERS';
$modversion['config'][$i]['description'] = '_XPY_MI_OFFICERS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_OFFICER);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');	

$i++;
$modversion['config'][$i]['name'] = 'manual';
$modversion['config'][$i]['title'] = '_XPY_MI_MANUAL';
$modversion['config'][$i]['description'] = '_XPY_MI_MANUAL_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'SWIFT: 0000000<br/>
BIC: 0000000<br/>
BSB: 0000000<br/>
ACCOUNT: 0000000<br/>
NAME: John Doe';
$default='';
foreach (explode(' ', $GLOBALS['xoopsConfig']['sitename']) as $word) {
	$default .= strtoupper(substr($word,0,1));
}

$i++;
$modversion['config'][$i]['name'] = 'manualcode';
$modversion['config'][$i]['title'] = '_XPY_MI_MANUALCODE';
$modversion['config'][$i]['description'] = '_XPY_MI_MANUALCODE_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $default;

$i++;
$modversion['config'][$i]['name'] = 'autotax';
$modversion['config'][$i]['title'] = '_XPY_MI_AUTOTAX';
$modversion['config'][$i]['description'] = '_XPY_MI_AUTOTAX_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'ipdb_apikey';
$modversion['config'][$i]['title'] = '_XPY_MI_IPDB_APIKEY';
$modversion['config'][$i]['description'] = '_XPY_MI_IPDB_APIKEY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();

$options = array("AFGHANISTAN" => "AF", "ALAND ISLANDS" => "AX", "ALBANIA" => "AL", "ALGERIA" => "DZ", "AMERICAN SAMOA" => "AS", "ANDORRA" => "AD", "ANGOLA" => "AO", "ANGUILLA" => "AI", "ANTARCTICA" => "AQ", "ANTIGUA AND BARBUDA" => "AG", "ARGENTINA" => "AR", "ARMENIA" => "AM", "ARUBA" => "AW", "AUSTRALIA" => "AU", "AUSTRIA" => "AT", "AZERBAIJAN" => "AZ", "BAHAMAS" => "BS", "BAHRAIN" => "BH", "BANGLADESH" => "BD", "BARBADOS" => "BB", "BELARUS" => "BY", "BELGIUM" => "BE", "BELIZE" => "BZ", "BENIN" => "BJ", "BERMUDA" => "BM", "BHUTAN" => "BT", "BOLIVIA, PLURINATIONAL STATE OF" => "BO", "BONAIRE, SAINT EUSTATIUS AND SABA" => "BQ", "BOSNIA AND HERZEGOVINA" => "BA", "BOTSWANA" => "BW", "BOUVET ISLAND" => "BV", "BRAZIL" => "BR", "BRITISH INDIAN OCEAN TERRITORY" => "IO", "BRUNEI DARUSSALAM" => "BN", "BULGARIA" => "BG", "BURKINA FASO" => "BF", "BURUNDI" => "BI", "CAMBODIA" => "KH", "CAMEROON" => "CM", "CANADA" => "CA", "CAPE VERDE" => "CV", "CAYMAN ISLANDS" => "KY", "CENTRAL AFRICAN REPUBLIC" => "CF", "CHAD" => "TD", "CHILE" => "CL", "CHINA" => "CN", "CHRISTMAS ISLAND" => "CX", "COCOS (KEELING) ISLANDS" => "CC", "COLOMBIA" => "CO", "COMOROS" => "KM", "CONGO" => "CG", "CONGO, THE DEMOCRATIC REPUBLIC OF THE" => "CD", "COOK ISLANDS" => "CK", "COSTA RICA" => "CR", "COTE D'IVOIRE" => "CI", "CROATIA" => "HR", "CUBA" => "CU", "CURACAO" => "CW", "CYPRUS" => "CY", "CZECH REPUBLIC" => "CZ", "DENMARK" => "DK", "DJIBOUTI" => "DJ", "DOMINICA" => "DM", "DOMINICAN REPUBLIC" => "DO", "ECUADOR" => "EC", "EGYPT" => "EG", "EL SALVADOR" => "SV", "EQUATORIAL GUINEA" => "GQ", "ERITREA" => "ER", "ESTONIA" => "EE", "ETHIOPIA" => "ET", "FALKLAND ISLANDS (MALVINAS)" => "FK", "FAROE ISLANDS" => "FO", "FIJI" => "FJ", "FINLAND" => "FI", "FRANCE" => "FR", "FRENCH GUIANA" => "GF", "FRENCH POLYNESIA" => "PF", "FRENCH SOUTHERN TERRITORIES" => "TF", "GABON" => "GA", "GAMBIA" => "GM", "GEORGIA" => "GE", "GERMANY" => "DE", "GHANA" => "GH", "GIBRALTAR" => "GI", "GREECE" => "GR", "GREENLAND" => "GL", "GRENADA" => "GD", "GUADELOUPE" => "GP", "GUAM" => "GU", "GUATEMALA" => "GT", "GUERNSEY" => "GG", "GUINEA" => "GN", "GUINEA-BISSAU" => "GW", "GUYANA" => "GY", "HAITI" => "HT", "HEARD ISLAND AND MCDONALD ISLANDS" => "HM", "HOLY SEE (VATICAN CITY STATE)" => "VA", "HONDURAS" => "HN", "HONG KONG" => "HK", "HUNGARY" => "HU", "ICELAND" => "IS", "INDIA" => "IN", "INDONESIA" => "ID", "IRAN, ISLAMIC REPUBLIC OF" => "IR", "IRAQ" => "IQ", "IRELAND" => "IE", "ISLE OF MAN" => "IM", "ISRAEL" => "IL", "ITALY" => "IT", "JAMAICA" => "JM", "JAPAN" => "JP", "JERSEY" => "JE", "JORDAN" => "JO", "KAZAKHSTAN" => "KZ", "KENYA" => "KE", "KIRIBATI" => "KI", "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF" => "KP", "KOREA, REPUBLIC OF" => "KR", "KUWAIT" => "KW", "KYRGYZSTAN" => "KG", "LAO PEOPLE'S DEMOCRATIC REPUBLIC" => "LA", "LATVIA" => "LV", "LEBANON" => "LB", "LESOTHO" => "LS", "LIBERIA" => "LR", "LIBYAN ARAB JAMAHIRIYA" => "LY", "LIECHTENSTEIN" => "LI", "LITHUANIA" => "LT", "LUXEMBOURG" => "LU", "MACAO" => "MO", "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF" => "MK", "MADAGASCAR" => "MG", "MALAWI" => "MW", "MALAYSIA" => "MY", "MALDIVES" => "MV", "MALI" => "ML", "MALTA" => "MT", "MARSHALL ISLANDS" => "MH", "MARTINIQUE" => "MQ", "MAURITANIA" => "MR", "MAURITIUS" => "MU", "MAYOTTE" => "YT", "MEXICO" => "MX", "MICRONESIA, FEDERATED STATES OF" => "FM", "MOLDOVA, REPUBLIC OF" => "MD", "MONACO" => "MC", "MONGOLIA" => "MN", "MONTENEGRO" => "ME", "MONTSERRAT" => "MS", "MOROCCO" => "MA", "MOZAMBIQUE" => "MZ", "MYANMAR" => "MM", "NAMIBIA" => "NA", "NAURU" => "NR", "NEPAL" => "NP", "NETHERLANDS" => "NL", "NEW CALEDONIA" => "NC", "NEW ZEALAND" => "NZ", "NICARAGUA" => "NI", "NIGER" => "NE", "NIGERIA" => "NG", "NIUE" => "NU", "NORFOLK ISLAND" => "NF", "NORTHERN MARIANA ISLANDS" => "MP", "NORWAY" => "NO", "OMAN" => "OM", "PAKISTAN" => "PK", "PALAU" => "PW", "PALESTINIAN TERRITORY, OCCUPIED" => "PS", "PANAMA" => "PA", "PAPUA NEW GUINEA" => "PG", "PARAGUAY" => "PY", "PERU" => "PE", "PHILIPPINES" => "PH", "PITCAIRN" => "PN", "POLAND" => "PL", "PORTUGAL" => "PT", "PUERTO RICO" => "PR", "QATAR" => "QA", "REUNION" => "RE", "ROMANIA" => "RO", "RUSSIAN FEDERATION" => "RU", "RWANDA" => "RW", "SAINT BARTHELEMY" => "BL", "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA" => "SH", "SAINT KITTS AND NEVIS" => "KN", "SAINT LUCIA" => "LC", "SAINT MARTIN (FRENCH PART)" => "MF", "SAINT PIERRE AND MIQUELON" => "PM", "SAINT VINCENT AND THE GRENADINES" => "VC", "SAMOA" => "WS", "SAN MARINO" => "SM", "SAO TOME AND PRINCIPE" => "ST", "SAUDI ARABIA" => "SA", "SENEGAL" => "SN", "SERBIA" => "RS", "SEYCHELLES" => "SC", "SIERRA LEONE" => "SL", "SINGAPORE" => "SG", "SINT MAARTEN (DUTCH PART)" => "SX", "SLOVAKIA" => "SK", "SLOVENIA" => "SI", "SOLOMON ISLANDS" => "SB", "SOMALIA" => "SO", "SOUTH AFRICA" => "ZA", "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS" => "GS", "SPAIN" => "ES", "SRI LANKA" => "LK", "SUDAN" => "SD", "SURINAME" => "SR", "SVALBARD AND JAN MAYEN" => "SJ", "SWAZILAND" => "SZ", "SWEDEN" => "SE", "SWITZERLAND" => "CH", "SYRIAN ARAB REPUBLIC" => "SY", "TAIWAN, PROVINCE OF CHINA" => "TW", "TAJIKISTAN" => "TJ", "TANZANIA, UNITED REPUBLIC OF" => "TZ", "THAILAND" => "TH", "TIMOR-LESTE" => "TL", "TOGO" => "TG", "TOKELAU" => "TK", "TONGA" => "TO", "TRINIDAD AND TOBAGO" => "TT", "TUNISIA" => "TN", "TURKEY" => "TR", "TURKMENISTAN" => "TM", "TURKS AND CAICOS ISLANDS" => "TC", "TUVALU" => "TV", "UGANDA" => "UG", "UKRAINE" => "UA", "UNITED ARAB EMIRATES" => "AE", "UNITED KINGDOM" => "GB", "UNITED STATES" => "US", "UNITED STATES MINOR OUTLYING ISLANDS" => "UM", "URUGUAY" => "UY", "UZBEKISTAN" => "UZ", "VANUATU" => "VU", "VENEZUELA, BOLIVARIAN REPUBLIC OF" => "VE", "VIET NAM" => "VN", "VIRGIN ISLANDS, BRITISH" => "VG", "VIRGIN ISLANDS, U.S." => "VI", "WALLIS AND FUTUNA" => "WF", "WESTERN SAHARA" => "EH", "YEMEN" => "YE0", "ZAMBIA" => "ZM", "ZIMBABWE" => "ZW");
$i++;
$modversion['config'][$i]['name'] = 'countrycode';
$modversion['config'][$i]['title'] = '_XPY_MI_COUNTRYCODE';
$modversion['config'][$i]['description'] = '_XPY_MI_COUNTRYCODE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'AU';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'district';
$modversion['config'][$i]['title'] = '_XPY_MI_DISTRICT';
$modversion['config'][$i]['description'] = '_XPY_MI_DISTRICT_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '2000';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'city';
$modversion['config'][$i]['title'] = '_XPY_MI_CITY';
$modversion['config'][$i]['description'] = '_XPY_MI_CITY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Sydney';
$modversion['config'][$i]['options'] = array();

$options=array();
for($d=0;$d<100;$d++)
	$options[$d.'%'] = $d;
$i++;
$modversion['config'][$i]['name'] = 'ipdb_fraud_knockoff';
$modversion['config'][$i]['title'] = '_XPY_MI_FRAUD_KNOCKOFF';
$modversion['config'][$i]['description'] = '_XPY_MI_FRAUD_KNOCKOFF';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '93';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'ipdb_fraud_kill';
$modversion['config'][$i]['title'] = '_XPY_MI_FRAUD_KILL';
$modversion['config'][$i]['description'] = '_XPY_MI_FRAUD_KILL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'id_protect';
$modversion['config'][$i]['title'] = '_XPY_MI_ID_PROTECT';
$modversion['config'][$i]['description'] = '_XPY_MI_ID_PROTECT_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_XPY_MI_HTACCESS";
$modversion['config'][$i]['description'] = "_XPY_MI_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_XPY_MI_BASEURL";
$modversion['config'][$i]['description'] = "_XPY_MI_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'payment';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_XPY_MI_ENDOFURL";
$modversion['config'][$i]['description'] = "_XPY_MI_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_pdf';
$modversion['config'][$i]['title'] = "_XPY_MI_ENDOFURL_PDF";
$modversion['config'][$i]['description'] = "_XPY_MI_ENDOFURL_PDF_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.pdf';

$i++;
$modversion['config'][$i]['name'] = 'issue_discount';
$modversion['config'][$i]['title'] = "_XPY_MI_ISSUE_DISCOUNT";
$modversion['config'][$i]['description'] = "_XPY_MI_ISSUE_DISCOUNT_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'issue_discount_every';
$modversion['config'][$i]['title'] = "_XPY_MI_ISSUE_DISCOUNT_EVERY";
$modversion['config'][$i]['description'] = "_XPY_MI_ISSUE_DISCOUNT_EVERY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'issue_random_discount';
$modversion['config'][$i]['title'] = "_XPY_MI_ISSUE_RANDOM_DISCOUNT";
$modversion['config'][$i]['description'] = "_XPY_MI_ISSUE_RANDOM_DISCOUNT_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'odds_range_lower';
$modversion['config'][$i]['title'] = "_XPY_MI_ODDS_RANGE_LOWER";
$modversion['config'][$i]['description'] = "_XPY_MI_ODDS_RANGE_LOWER_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'odds_range_higher';
$modversion['config'][$i]['title'] = "_XPY_MI_ODDS_RANGE_HIGHER";
$modversion['config'][$i]['description'] = "_XPY_MI_ODDS_RANGE_HIGHER_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 11;

$i++;
$modversion['config'][$i]['name'] = 'odds_minimum';
$modversion['config'][$i]['title'] = "_XPY_MI_ODDS_MINIMUM";
$modversion['config'][$i]['description'] = "_XPY_MI_ODDS_MINIMUM_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(1,6);

$i++;
$modversion['config'][$i]['name'] = 'odds_maximum';
$modversion['config'][$i]['title'] = "_XPY_MI_ODDS_MAXIMUM";
$modversion['config'][$i]['description'] = "_XPY_MI_ODDS_MAXIMUM_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(5,11);

$default='';
foreach(explode(' ', $GLOBALS['xoopsConfig']['sitename']) as $word) {
	$default.=strtoupper(substr($word, 0, 1));
}
$i++;
$modversion['config'][$i]['name'] = 'discount_prefix';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_PREFIX";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_PREFIX_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $default;

$i++;
$modversion['config'][$i]['name'] = 'discount_base';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_BASE";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_BASE_DESC";
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '0|1|2|3|4|5|6|7|8|9|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z';

$i++;
$modversion['config'][$i]['name'] = 'discount_validtill';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_VALIDTILL";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_VALIDTILL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*7*4*5;

$i++;
$modversion['config'][$i]['name'] = 'discount_percentage';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_PERCENTAGE";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_PERCENTAGE_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(5,30);

$i++;
$modversion['config'][$i]['name'] = 'discount_redeems';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_REDEEMS";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_REDEEMS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'discount_amount';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_AMOUNT";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_AMOUNT_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'discount_shipping';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_SHIPPING";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_SHIPPING_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'discount_handling';
$modversion['config'][$i]['title'] = "_XPY_MI_DISCOUNT_HANDLING";
$modversion['config'][$i]['description'] = "_XPY_MI_DISCOUNT_HANDLING_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'reminder_resend_in';
$modversion['config'][$i]['title'] = "_XPY_MI_REMINDER_RESENT_IN";
$modversion['config'][$i]['description'] = "_XPY_MI_REMINDER_RESENT_IN_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*9;

$options=array();
$options[_XPY_MI_SECONDS_10] = 10;
$options[_XPY_MI_SECONDS_30] = 30;
$options[_XPY_MI_SECONDS_60] = 60;
$options[_XPY_MI_SECONDS_90] = 90;
$options[_XPY_MI_SECONDS_120] = 120;
$options[_XPY_MI_SECONDS_180] = 180;
$options[_XPY_MI_SECONDS_240] = 240;
$options[_XPY_MI_SECONDS_300] = 300;
$options[_XPY_MI_SECONDS_360] = 360;
$options[_XPY_MI_SECONDS_420] = 420;

$i++;
$modversion['config'][$i]['name'] = 'secs_topayment';
$modversion['config'][$i]['title'] = '_XPY_MI_SECS_TOPAYMENT';
$modversion['config'][$i]['description'] = '_XPY_MI_SECS_TOPAYMENT_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 420;
$modversion['config'][$i]['options'] = $options;

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_help.html';
$modversion['templates'][$i]['description'] = 'payment help screen!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice.html';
$modversion['templates'][$i]['description'] = 'blank invoice template!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_payment.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_payment_pdf.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice PDF Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_return.html';
$modversion['templates'][$i]['description'] = 'Payment Return Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cancel.html';
$modversion['templates'][$i]['description'] = 'Payment Cancel Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice_list.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice_view.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_transactions_list.html';
$modversion['templates'][$i]['description'] = 'Transaction Return Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_transactions_view.html';
$modversion['templates'][$i]['description'] = 'Transaction Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_invoice_list.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_invoice_view.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display  Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_transactions_list.html';
$modversion['templates'][$i]['description'] = 'Transaction Return Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_transactions_view.html';
$modversion['templates'][$i]['description'] = 'Transaction Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_gateways_list.html';
$modversion['templates'][$i]['description'] = 'Gateway Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_gateways_options.html';
$modversion['templates'][$i]['description'] = 'Gateway Options Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_groups.html';
$modversion['templates'][$i]['description'] = 'Groups Rules Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_groups_edit.html';
$modversion['templates'][$i]['description'] = 'Groups Rules Display Form Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_tax_list.html';
$modversion['templates'][$i]['description'] = 'Auto Tax List Form Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_discounts_list.html';
$modversion['templates'][$i]['description'] = 'Discount List Form Control Panel!';


$i=0;
if ($GLOBALS['xoopsUser']) {
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$xoMod = $module_handler->getByDirname('xpayment');
	if (is_object($xoMod)) {
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		if (in_array($xoConfig['brokers'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _XPY_MI_MNU_BROKER;
			$modversion['sub'][$i]['url'] = "broker.php";
		}
		if (in_array($xoConfig['accounts'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _XPY_MI_MNU_ACCOUNTS;
			$modversion['sub'][$i]['url'] = "accounts.php";
		}
		if (in_array($xoConfig['officers'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _XPY_MI_MNU_OFFICERS;
			$modversion['sub'][$i]['url'] = "officers.php";
		}
	}
}

?>
