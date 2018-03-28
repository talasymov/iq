<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/App/Config/Define.php");

foreach (ReturnListFiles(DIR_APP . "Library/Sweane/") as $path)
{
    require_once $path;
}

foreach (ReturnListFiles(DIR_MODELS . "Helpers/") as $path)
{
    require_once $path;
}

if(!BF::ClearCode("language", "str", "cookie"))
{
    setcookie("language", "ru", time() + 86400, "/");
}

//if(BF::ClearCode("language", "str", "session"))
//{
//    switch (BF::ClearCode("language", "str", "session")){
//        case "ru":
//            echo '<span style="display: none">' . $_COOKIE["language"] . '</span>';
//            setcookie('language', "_ru", time() + 8640, '/');
//            define("USER_LANG", '_ru');
//            break;
//        default:
//            echo '<span style="display: none">_' . $_COOKIE["language"] . '</span>';
//            setcookie('language', "en", time() + 8640, '/');
//            define("USER_LANG", '');
//            break;
//    }
//}
//else
//{
//    define("USER_LANG", '');
//}

if($_SESSION['currency_code'] != '' && $_SESSION['currency'] != '' && $_SESSION['currency_code_db'] != '')
{
//    AuxiliaryFn::StylePrint($_SESSION['currency_code']);

//    define("USER_LANG", $_SESSION['currency_code']);
    switch ($_SESSION['currency_code']){
        case "ua":
            define("USER_LANG", '_ru');
            break;
        case "ru":
            define("USER_LANG", '_ru');
            break;
        default:
            define("USER_LANG", '');
            break;
    }
}
else
{
    $currencyCode = strtolower(BF::IpInfo("Visitor", "countrycode"));

    $currency_value = 1;

    switch ($currencyCode){
        case "ua":
            $_SESSION['currency_code'] = 'ua';
            $currency = R::getRow("SELECT * FROM Currency WHERE Currency_id = 1");
            $currency_value = $currency['Currency_value'];
            $_SESSION['currency_code_db'] = $currency['Currency_code'];
            $_SESSION['currency_symbol_left'] = $currency['Currency_symbol_left'];
            $_SESSION['currency_symbol_right'] = $currency['Currency_symbol_right'];
            define("USER_LANG", '_ru');
            break;
        case "ru":
            $_SESSION['currency_code'] = 'ru';
            $currency = R::getRow("SELECT * FROM Currency WHERE Currency_id = 2");
            $currency_value = $currency['Currency_value'];
            $_SESSION['currency_code_db'] = $currency['Currency_code'];
            $_SESSION['currency_symbol_left'] = $currency['Currency_symbol_left'];
            $_SESSION['currency_symbol_right'] = $currency['Currency_symbol_right'];
            define("USER_LANG", '_ru');
            break;
        default:
            $_SESSION['currency_code'] = 'en';
            $currency_value = 1;
            $_SESSION['currency_code_db'] = 'USD';
            $_SESSION['currency_symbol_left'] = '$';
            $_SESSION['currency_symbol_right'] = '';
            define("USER_LANG", '');
            break;
    }

    $_SESSION['currency'] = $currency_value;
}

require_once(DIR_APP . "Core/Controller.php");
require_once(DIR_APP . "Core/Model.php");
require_once(DIR_APP . "Core/Route.php");
require_once(DIR_APP . "Core/View.php");

function ReturnListFiles($dir)
{
    $message = [];

    if(is_dir($dir))
    {
        if($listDir = opendir($dir))
        {
            while(($file = readdir($listDir)) !== false)
            {
                if(file_exists($dir . $file))
                {
                    if(filetype($dir . $file) == "file")
                    {
                        array_push($message, $dir . $file);
                    }
                }
            }
            closedir($listDir);
        }
    }

    return $message;
}

$route = new Route();
$route->Init();