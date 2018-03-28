<?php
class Route
{
  protected $controllerName = "MainController";
  protected $modelName = "MainModel";
  protected $actionName = "IndexAction";
  protected $parametersName = null;
  protected $controllerPreparePath = "Main";
  protected $modelPreparePath = "Main";
  protected $controllerPrepare = "Main";
  protected $modelPrepare = "Main";

    public function Init()
    {
//        AuxiliaryFn::StylePrint($_SERVER);

        $fileParams = $this->ReturnPath();

//        AuxiliaryFn::StylePrint($fileParams);

        if(file_exists(DIR_CONTROLLERS . $fileParams[0] . "Controller.php"))
        {
            if(require_once(DIR_CONTROLLERS . $fileParams[0] . "Controller.php"))
            {
                $this->controllerName = $fileParams[1] . "Controller";
//                AuxiliaryFn::AddStatus("1. Controller Required");
            }
        }

        if(file_exists(DIR_MODELS . $fileParams[0] . "Model.php"))
        {
            if(require_once(DIR_MODELS . $fileParams[0] . "Model.php"))
            {
                $this->modelName = $fileParams[1] . "Model";
//                AuxiliaryFn::AddStatus("2. Model Required");
            }
        }

        $controller = new $this->controllerName($this->modelName);
//        AuxiliaryFn::StylePrint($this->ReturnArgumentsLink());
        if(method_exists($controller, $fileParams[2] . "Action"))
        {
            $this->actionName = $fileParams[2] . "Action";
            $action = $this->actionName;
//            AuxiliaryFn::AddStatus("3. Action Have " . $_SERVER["argv"][0]);

            $controller->$action($this->ReturnArgumentsLink());
        }
//        AuxiliaryFn::GetStatus();
    }

    private function ReturnPath()
    {
        $link = REQUEST_URI;

        if(substr($link, -1) != "/")
        {
            $link = substr($link, 0, strripos($link, "/") + 1);
        }

        $array = [
            "/blog/" => ["/Blog", "Blog", "Index"],
            "/aboutus/" => ["/Main", "Main", "AboutUs"],
            "/category/" => ["/Category", "Category", "Index"],
            "/product/" => ["/Product", "Product", "Index"],
            "/contacts-us/" => ["/Main", "Main", "Contacts"],
            "/confirm-account/" => ["/Main", "Main", "ConfirmAccount"],
            "/restore-password/" => ["/Main", "Main", "RestorePassword"],
            "/check-your-email/" => ["/Main", "Main", "CheckYourEmail"],
            "/ForgotPassword/" => ["/Main", "Main", "ForgotPassword"],
            "/news/" => ["/Main", "Main", "News"],
            "/faq/" => ["/Main", "Main", "Faq"],
            "/apipay/" => ["/Main", "Main", "ApiPay"],
            "/delivery/" => ["/Main", "Main", "Delivery"],
            "/cart/" => ["/Main", "Main", "Cart"],
            "/checkout/" => ["/Main", "Main", "Checkout"],
            "/checkouttest/" => ["/Main", "Main", "CheckoutTest"],
            "/inoneclick/" => ["/Main", "Main", "InOneClick"],
            "/login/" => ["/Main", "Main", "Login"],
            "/sign-up/" => ["/Main", "Main", "SignUp"],
            "/user/" => ["/User/UserMain", "UserMain", "Index"],
            "/auth/" => ["/Main", "Main", "Auth"],
            "/content/" => ["/Main", "Main", "Content"],
            "/user/orders/" => ["/User/UserMain", "UserMain", "Orders"],
            "/register/" => ["/Main", "Main", "Register"],
            "/search/" => ["/Main", "Main", "Search"],
            "/balance/" => ["/Main", "Main", "Balance"],
            "/setlang/" => ["/Main", "Main", "SetLang"],
            "/setcurrency/" => ["/Main", "Main", "SetCurrency"],
            "/individual-order/" => ["/Main", "Main", "IndividualOrder"],
            "/dashboard/" => ["/Main", "Main", "Dashboard"],
            "/dashboard/orders/" => ["/Main", "Main", "DashboardOrders"],
            "/dashboard/clients/" => ["/Main", "Main", "DashboardClients"],
            "/dashboard/characteristics/category/" => ["/Main", "Main", "DashboardCharacteristicsCategory"],
            "/dashboard/characteristics/value/" => ["/Main", "Main", "DashboardCharacteristicsValue"],
            "/dashboard/products/edit/" => ["/Main", "Main", "ProductEdit"],
            "/dashboard/products/create/" => ["/Main", "Main", "ProductCreate"],
            "/dashboard/news/create/" => ["/Main", "Main", "NewsCreate"],
            "/dashboard/news/edit/" => ["/Main", "Main", "NewsEdit"],
            "/requests/" => ["/Requests", "Requests", "Ajax"],
            "/404/" => ["/NotFound", "NotFound", "Index"],
            "/" => ["/Main", "Main", "Index"],
            "default" => ["/Main", "Main", "Index"]
        ];

        $return = $array[strtolower($link)];

        if(isset($return))
        {
            return $return;
        }

        return $this->ErrorPage();
    }

    private function ReturnArgumentsLink()
    {
        $link = REQUEST_URI;
        $args = "";
        $argsArray = [];

        if(substr($link, -1) != "/")
        {
            $link = substr($link, strripos($link, "/") + 1, strlen($link));
        }

        if(strpos($link, "?"))
        {
            $link = explode("?", $link);

            $args = $link[1];
            $link = $link[0];
        }

        if(isset($args) && strpos($args, "="))
        {
            $argumentsExplode = explode("&", $args);

            if(is_array($argumentsExplode))
            {
                foreach ($argumentsExplode as $value)
                {
                    $paramsOne = explode("=", $value);

                    $argsArray[$paramsOne[0]] = $paramsOne[1];
                }
            }

            $arguments["arguments"] = $argsArray;
        }

        $arguments["child"] = $link;

        return $arguments;
    }

    public function ErrorPage()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: /404/');
    }
}