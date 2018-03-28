<?php
define("DIR_ROOT_CLEAR", $_SERVER["DOCUMENT_ROOT"]);
define("DIR_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("DIR_APP", DIR_ROOT . "App/");
define("DIR_CONTROLLERS", DIR_APP . "Controllers/");
define("DIR_MODELS", DIR_APP . "Models/");
define("DIR_VIEWS", DIR_APP . "Views/");
define("DIR_AJAX", DIR_APP . "Ajax/");
define("DIR_LIBS", DIR_ROOT . "Libs/");
define("DIR_IMAGES", DIR_ROOT . "Images/");
define("DIR_IMAGES_NON_ROOT", "/Images/");
define("DIR_INCLUDE", DIR_VIEWS . "Include/");
//define("REDIRECT_URL", $_SERVER["REDIRECT_URL"]);
define("REQUEST_URI", $_SERVER["REQUEST_URI"]);

//define("USER_LANG", '');

//if($_SESSION['language'] != '' && $_SESSION['currency_code'] != '' && $_SESSION['currency'] != '' && $_SESSION['currency_code_db'] != '')
//{
//    define("USER_LANG", $_SESSION['currency_code']);
//}
//else
//{
//    $currencyCode = strtolower(BF::IpInfo("Visitor", "countrycode"));
//
//    $currency_value = 1;
//
//    switch ($currencyCode){
//        case "ua":
//            $_SESSION['currency_code'] = 'ua';
//            $currency = R::getRow("SELECT * FROM Currency WHERE Currency_id = 1");
//            $currency_value = $currency['Currency_value'];
//            $_SESSION['currency_code_db'] = $currency['Currency_code'];
//            $_SESSION['currency_symbol_left'] = $currency['Currency_symbol_left'];
//            $_SESSION['currency_symbol_right'] = $currency['Currency_symbol_right'];
//            define("USER_LANG", '_ru');
//            break;
//        case "ru":
//            $_SESSION['currency_code'] = 'ru';
//            $currency = R::getRow("SELECT * FROM Currency WHERE Currency_id = 2");
//            $currency_value = $currency['Currency_value'];
//            $_SESSION['currency_code_db'] = $currency['Currency_code'];
//            $_SESSION['currency_symbol_left'] = $currency['Currency_symbol_left'];
//            $_SESSION['currency_symbol_right'] = $currency['Currency_symbol_right'];
//            define("USER_LANG", '_ru');
//            break;
//        default:
//            $_SESSION['currency_code'] = 'en';
//            $currency_value = 1;
//            $_SESSION['currency_code_db'] = 'USD';
//            $_SESSION['currency_symbol_left'] = '$';
//            $_SESSION['currency_symbol_right'] = '';
//            define("USER_LANG", '');
//            break;
//    }
//
//    $_SESSION['currency'] = $currency_value;
//}

//if($_SESSION['language'] != '')
//{
//    if($_SESSION['language'] == 'en') define("USER_LANG", '');
//    else define("USER_LANG", '_' . $_SESSION['language']);
//}
//else
//{
//    define("USER_LANG", '');
//}

//if(!isset($_SESSION['currency'])) $_SESSION['currency'] = 1;
//if(!isset($_SESSION['currency_code_db'])) $_SESSION['currency_code_db'] = 'USD';
//if(!isset($_SESSION['currency_symbol_left'])) $_SESSION['currency_symbol_left'] = '$';
//if(!isset($_SESSION['currency_symbol_right'])) $_SESSION['currency_symbol_right'] = '';

//$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
//switch ($lang){
//    case "ru":
//        //echo "PAGE FR";
//        define("USER_LANG", '_ru');
//        break;
//    default:
//        //echo "PAGE EN - Setting Default";
//        define("USER_LANG", '');
//        break;
//}

//echo '<span style="display: none">'.$_SESSION['language'].'</span>';

//define("USER_LANG", '');
//    define("USER_LANG", '_' . $_COOKIE["lang"]);

$currentYear = date("Y");

//Connect to DataBase
//
define("DB_SERVER", "localhost");	//	HOST
define("DB_USER", "u_iqlinger");	// USERNAME
define("DB_PASS", "Kr6ut2xm");	// PASSWORD
define("DB_NAME", "iqlinger");	// DATABASE NAME

require_once( DIR_LIBS . "BackEnd/redbeans/rb.php" );

R::setup( 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME , DB_USER, DB_PASS );

R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});
