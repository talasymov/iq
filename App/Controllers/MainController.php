<?php
class MainController extends Controller
{
    public function IndexAction($params = null)
    {
        $data = $this->model->GetData();

        $this->view->GetTemplate("DefaultPage.php", "MainView.php", $data);
    }

    public function CartAction()
    {
        $data = ShopFn::GetProductsInCart();

        $this->view->GetTemplate("DefaultPage.php", "CartView.php", $data);
    }

    public function LoginAction()
    {
        BF::RedirectUser("user/", 1);

        $this->view->GetTemplate("DefaultPage.php", "LoginView.php");
    }

    public function SignUpAction($params = null)
    {
        if($params["child"] == "check")
        {
            $this->view->GetTemplate("DefaultPage.php", "SignUpCheckView.php");
        }
        else if($params["child"] == "confirm")
        {
            BF::ConfirmUser($params["arguments"]["email"]);

            $this->view->GetTemplate("DefaultPage.php", "SignUpConfirmView.php");
        }
        else
        {
            $this->view->GetTemplate("DefaultPage.php", "SignUpView.php");
        }
    }

    public function CheckoutAction($params = null)
    {
//        if($params["child"] == "shipping" || BF::IfUserInSystem())
//        {
            $this->view->GetTemplate("ClearPage.php", "CheckOutShippingView.php");
//        }
//        else
//        {
//            $data = ShopFn::GetProductsInCart();
//
//            $this->view->GetTemplate("ClearPage.php", "CheckoutView.php", $data);
//        }
    }
    public function CheckoutTestAction($params = null)
    {
        $this->view->GetTemplate("ClearPage.php", "CheckOutShippingTestView.php");
    }

    public function InOneClickAction()
    {
        $data = ShopFn::GetProductsInCart();

        $this->view->GetTemplate("DefaultPage.php", "InOneClickView.php", $data);
    }

    public function RegisterAction()
    {
        $this->view->GetTemplate("DefaultPage.php", "RegisterView.php");
    }

    public function SetLangAction($params = null)
    {
//        $_SESSION['language'] = $params["child"];
//        $lang = BF::ClearCode("language", "str", "cookie");

//        if($lang)
//        {
//            unset($_COOKIE['language']);
//            setcookie('language', null, '-1', '/');
////            echo "clean cookie";
//        }
        switch ($params["child"]){
            case "ru":
                $_SESSION['language'] = 'ru';
//                if($lang != "ru")
//                {
//                    unset($_COOKIE['language']);
//                    setcookie('language', null, '-1', '/');
////                    echo "clean cookie";
//                }
//                echo $_COOKIE["language"];
//                setcookie('language', "_ru", time() + 8640, '/');
//                define("USER_LANG", '_ru');
//                AuxiliaryFn::StylePrint('ru');
                break;
            default:
                $_SESSION['language'] = 'en';
//                unset($_COOKIE['language']);
//                if($lang != "en")
//                {
//                    unset($_COOKIE['language']);
//                    setcookie('language', null, '-1', '/');
////                    echo "clean cookie";
//                }
//                echo $_COOKIE["language"];
//                setcookie('language', "en", time() + 8640, '/');
//                define("USER_LANG", '');
//                AuxiliaryFn::StylePrint('en');
                break;
        }

        header('Location: /');
//        }
//        else
//        {
//            define("USER_LANG", '');
//        }
//        setcookie('lang', $params["child"], time() + 8640, '/');
//        AuxiliaryFn::StylePrint($_COOKIE["lang"]);
    }

    public function SetCurrencyAction($params = null)
    {
        $currency_value = 1;

        switch ($params["child"]){
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

        header('Location: /');
//        AuxiliaryFn::StylePrint(USER_LANG);
    }

    public function BalanceAction()
    {
        $this->view->GetTemplate("DefaultPage.php", "BalanceView.php");
    }

    public function IndividualOrderAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "IndividualOrderView.php", $params);
    }

    public function SearchAction($params = null)
    {
        if($params["arguments"]["q"] != "")
        {
            $data["result"] = ShopFn::Search([
                "limit" => 20,
                "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                "link" => "start="
            ]);

            $data["params"] = $params;

            $this->view->GetTemplate("DefaultPage.php", "SearchView.php", $data);
        }
        else
        {
            BF::RedirectPage("");
        }
    }

    public function AuthAction($params = null)
    {
        $social = BF::ClearCode($params['child'], "str");

        $data = [];

        if($social == "vk")
        {
            AuxiliaryFn::StylePrint($social);

            $data["social"] = "vk";
            $data["client_id"] = 6023314;
            $data["client_secret"] = "F5zaPrea9vA8ebKEv7Aj";
            $data["redirect_uri"] = "http://store.sweane/auth/vk";
            $data["response_type"] = "code";
            $data["auth_uri"] = "http://oauth.vk.com/authorize";
        }
        else if($social == "fb")
        {
            AuxiliaryFn::StylePrint($social);

            $data["social"] = "fb";
            $data["client_id"] = 1708906252735592;
            $data["client_secret"] = "d2fdfd9aab98c9e9a4654117d9602102";
            $data["redirect_uri"] = "http://store.sweane/auth/fb";
            $data["response_type"] = "code";
            $data["auth_uri"] = "https://www.facebook.com/dialog/oauth";
        }

        $this->view->GetTemplate("ClearPage.php", "AuthView.php", $data);
    }

    public function NewsAction($params = null)
    {
        if(BF::ClearCode($params["child"], "str") == "s")
        {
            $data = $this->model->GetNews([
                "limit" => 20,
                "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                "link" => "/news/s?start="
            ]);

            $this->view->GetTemplate("DefaultPage.php", "NewsView.php", $data);
        }
        else
        {
            $data = $this->model->GetNewsForId(BF::ClearCode($params["child"], "int"));

            $this->view->GetTemplate("DefaultPage.php", "NewsOneView.php", $data);
        }
    }

    public function ContentAction($params = null)
    {
        $link = BF::ClearCode($params["child"], "str");

        if($link != "/content/")
        {
            $data = R::getRow("SELECT * FROM News WHERE news_link LIKE '" . BF::ClearCode($link, "str") . "'");

            if(intval($data["news_id"]) > 0)
            {
                $this->view->GetTemplate("DefaultPage.php", "ContentView.php", $data);
            }
            else
            {
                BF::NotFound();
            }
        }
    }

    public function ForgotPassword()
    {

    }

    public function ApiPayAction($params = null)
    {
        $this->view->GetTemplate("ClearPage.php", "ApiPayView.php");
    }

    public function CheckYourEmailAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "CheckYourEmailView.php");
    }

    public function ConfirmAccountAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "ConfirmAccountView.php", $params);
    }

    public function RestorePasswordAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "RestorePasswordView.php", $params);
    }

    public function DashboardAction($params = null)
    {
        BF::RedirectUser("", 0);

        if(BF::ReturnInfoUser(BF::permissionUser) != 777 && BF::ReturnInfoUser(BF::permissionUser) != 555)
        {
            BF::RedirectUser("user/", 1);
        }

        $command = BF::ClearCode($params["child"], "str");

        if($command == "products")
        {
            if(BF::ClearCode("search", "str", "get"))
            {
                $data = ShopFn::GetProducts([
                    "limit" => 20,
                    "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                    "link" => "/dashboard/products?search=" . BF::ClearCode("search", "str", "get"). "&start=",
                    "search" => BF::ClearCode("search", "str", "get")
                ]);
            }
            else if(BF::ClearCode("category", "str", "get"))
            {
                $data = ShopFn::GetProducts([
                    "limit" => 20,
                    "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                    "link" => "/dashboard/products?category=" . BF::ClearCode("category", "str", "get"),
                    "category" => BF::ClearCode("category", "str", "get")
                ]);
            }
            else
            {
                $data = ShopFn::GetProducts([
                    "limit" => 20,
                    "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                    "link" => "/dashboard/products?start="
                ]);
            }

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/ProductsView.php", $data);

            return;
        }
        else if($command == "taxation")
        {
            $data = $this->model->GetTaxations();

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/TaxationView.php", $data);

            return;
        }
        else if($command == "banners")
        {
            $data = $this->model->GetBanners();

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/BannersView.php", $data);

            return;
        }
        else if($command == "settings")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/SettingsView.php");

            return;
        }
        else if($command == "currency")
        {
            $data = $this->model->GetCurrency();

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/CurrencyView.php", $data);

            return;
        }
        else if($command == "category")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/CategoryView.php");

            return;
        }
        else if($command == "orders")
        {
            $data = R::getAll("SELECT * FROM OrdersGroup
            INNER JOIN OrdersStatus ON OrdersStatus.OrdersStatus_id = OrdersGroup.OrdersGroup_status

            INNER JOIN Users ON Users.Users_id = OrdersGroup.OrdersGroup_user ORDER BY OrdersGroup_id DESC LIMIT ?, ?",[
                BF::ClearCode($params["arguments"]["start"], "int"),
                10
            ]);

            $dataCount = R::getAll("SELECT * FROM OrdersGroup
            INNER JOIN OrdersStatus ON OrdersStatus.OrdersStatus_id = OrdersGroup.OrdersGroup_status

            INNER JOIN Users ON Users.Users_id = OrdersGroup.OrdersGroup_user ORDER BY OrdersGroup_id DESC");

            $arrayLink = AuxiliaryFn::PaginationGenerate($dataCount,
                10,
                "/dashboard/orders?start=", BF::ClearCode($params["arguments"]["start"], "int"));

            $data["orders"] = $data;
            $data["link"] = $arrayLink["pagination"];

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/OrdersView.php", $data);

            return;
        }
        else if($command == "characteristics")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/CharacteristicsView.php");

            return;
        }
        else if($command == "properties")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/PropertiesView.php");

            return;
        }
        else if($command == "clients")
        {
            $data = ShopFn::GetClients([
                "limit" => 20,
                "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                "link" => "/dashboard/clients?start="
            ]);

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/ClientsView.php", $data);

            return;
        }
        else if($command == "blog")
        {
            $data = $this->model->GetNews([
                "limit" => 20,
                "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                "link" => "/dashboard/blog?start="
            ]);

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/BlogView.php", $data);

            return;
        }
        else if($command == "emails")
        {
            $data = $this->model->GetEmails([
                "limit" => 20,
                "offset" => BF::ClearCode($params["arguments"]["start"], "int"),
                "link" => "/dashboard/emails?start="
            ]);

            $this->view->GetTemplate("DashboardPage.php", "Dashboard/EmailsView.php", $data);

            return;
        }
        else if($command == "company-settings")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/CompanySettingsView.php");

            return;
        }
        else if($command == "partner")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/PartnerView.php");

            return;
        }
        else if($command == "shares-menu")
        {
            $this->view->GetTemplate("DashboardPage.php", "Dashboard/SharesMenuView.php");

            return;
        }

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/MainView.php");
    }

    public function DashboardCharacteristicsCategoryAction($params = null)
    {
        BF::RedirectUser("", 0);

        $data = $this->model->GetCharacteristicsCategory(BF::ClearCode($params["child"], "int"));

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/CharacteristicsCategoryView.php", $data);
    }

    public function DashboardCharacteristicsValueAction($params = null)
    {
        BF::RedirectUser("", 0);

        $data = $this->model->GetCharacteristicsValue(BF::ClearCode($params["child"], "int"));

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/CharacteristicsValueView.php", $data);
    }


    public function DashboardOrdersAction($params = null)
    {
        $data["products"] = ShopFn::GetProductsFromOrderGroup(BF::ClearCode($params["child"], "str"));
        $data["group"] = R::getRow("
        SELECT * FROM OrdersGroup
        
        INNER JOIN Users ON Users.Users_id = OrdersGroup.OrdersGroup_user
        
        WHERE OrdersGroup_id = ?", [
            BF::ClearCode($params["child"], "str")
        ]);

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/OrderOneView.php", $data);
    }

    public function DashboardClientsAction($params = null)
    {
        $data = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
            BF::ClearCode($params["child"], "str")
        ]);

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/ContactsOneView.php", $data);
    }

    public function FaqAction($params = null)
    {
        $this->view->GetTemplate("InformationPage.php", "FaqView.php");
    }

    public function DeliveryAction($params = null)
    {
        $this->view->GetTemplate("InformationPage.php", "DeliveryView.php");
    }

    public function AboutUsAction($params = null)
    {
        $this->view->GetTemplate("InformationPage.php", "AboutUsView.php");
    }

    public function ContactsAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "ContactsView.php");
    }

    public function NewsCreateAction($params = null)
    {
        BF::RedirectUser("", 0);

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/AddNewsView.php");
    }

    public function NewsEditAction($params = null)
    {
        BF::RedirectUser("", 0);

//        var_dump($params);

        $data = $this->model->GetNewsForId(BF::ClearCode($params["child"], "int"));

        $data["lang"] = $params["arguments"]["lang"];

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/EditNewsView.php", $data);
    }

    public function ProductCreateAction($params = null)
    {
        BF::RedirectUser("", 0);

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/AddProductView.php");
    }

    public function ProductEditAction($params = null)
    {
        BF::RedirectUser("", 0);

        $data["products"] = R::getRow("SELECT *  FROM Products WHERE ID_product = ?", [BF::ClearCode($params["child"], "int")]);

        $selectCharacteristic = "";

        foreach (ShopFn::GetCharacteristic($data["products"]["ProductCategory"]) as $value)
        {
            $listValues = R::getAll("SELECT * FROM CharacteristicsValue WHERE cValueSchema_FK = ?", [$value["ID_cSchema"]]);

            $default = R::getRow("SELECT * FROM CharacteristicsOutput

            INNER JOIN CharacteristicsSchema ON CharacteristicsSchema.ID_cSchema = CharacteristicsOutput.cOutput_id_Schema

            INNER JOIN CharacteristicsValue ON CharacteristicsValue.ID_cValue = CharacteristicsOutput.cOutput_id_Value

            WHERE CharacteristicsOutput.cOutput_id_Product = ? AND CharacteristicsSchema.ID_cSchema = ?
            ", [$data["products"]["ID_product"], $value["ID_cSchema"]]);

            $select = AuxiliaryFn::ArrayToSelect($listValues, "design-input characteristic" . $value["ID_cSchema"], "ID_cValue", "cValueValue", "Выберите из списка", $default["cOutput_id_Value"]);

            $selectCharacteristic .= '<tr><td><span class="list-characteristic header-blue" data-value="' . $value["ID_cSchema"] . '">' . $value["cSchema_Name"] . '</td><td>' . $select . '</td></tr>';
        }

        $data["characteristics"] = $selectCharacteristic;

        $this->view->GetTemplate("DashboardPage.php", "Dashboard/EditProductView.php", $data);
    }
}