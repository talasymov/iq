<?php
class ShopFn
{
    public static function GetCountInCart()
    {
        if (ShopFn::GetIdFromCart() != false) {
            return count(ShopFn::GetIdFromCart());
        }

        return 0;
    }

    public static function GetCountInBalance()
    {
        if (ShopFn::GetIdFromBalance() != false) {
            return count(ShopFn::GetIdFromBalance());
        }

        return 0;
    }

    public static function GetCountWish()
    {
        $count = R::getRow("SELECT COUNT(*) as Count FROM Wish WHERE Wish_user = ?", [
            BF::ReturnInfoUser(BF::idUser)
        ]);

        return $count["Count"];
    }

    public static function ClearCart()
    {
        unset($_SESSION["cartProducts"]);

        return true;
    }

    public static function ClearBalance()
    {
        unset($_SESSION["balanceProducts"]);

        return true;
    }

    public static function ClearViewed()
    {
        unset($_SESSION["viewedProducts"]);

        return true;
    }

    public static function AddViewed($idProduct)
    {
        $listProducts = ShopFn::GetIdFromViewed();

        $listProducts[$idProduct] = true;

        $_SESSION["viewedProducts"] = $listProducts;

        $listProducts = ShopFn::GetIdFromViewed();

        if (array_key_exists($idProduct, $listProducts)) {
            return true;
        }

        return true;
    }

    public static function DeleteFromCart($idProduct)
    {
        $listProducts = ShopFn::GetIdFromCart();

        unset($listProducts[$idProduct]);

        $_SESSION["cartProducts"] = $listProducts;
    }

    public static function AddToCart($idProduct, $property = false)
    {
        $listProducts = ShopFn::GetIdFromCart();

        unset($listProducts[$idProduct]);

        $listProducts[$idProduct]["count"] = 1;
        $listProducts[$idProduct]["property"] = $property;

        $_SESSION["cartProducts"] = $listProducts;

        $listProducts = ShopFn::GetIdFromCart();

        if (array_key_exists($idProduct, $listProducts)) {
            return true;
        }

        return false;
    }

    public static function ChangeCountInCart($idProduct, $count)
    {
        $listProducts = ShopFn::GetIdFromCart();

        if (array_key_exists($idProduct, $listProducts)) {
            $listProducts[$idProduct]["count"] = $count;

            $_SESSION["cartProducts"] = $listProducts;

            return true;
        }

        return false;
    }

    public static function AddToBalance($idProduct)
    {
        $listProducts = ShopFn::GetIdFromBalance();

        if (!in_array($idProduct, $listProducts)) {
            array_push($listProducts, $idProduct);

            $_SESSION["balanceProducts"] = $listProducts;

            return true;
        }

        return false;
    }

    public static function ReturnDeliveryInfo($id)
    {
        $delivery = [
            1 => [
                "money" => 7.95
            ],
            2 => [
                "money" => 25.55
            ]
        ];

        return $delivery[$id];
    }

    public static function CheckOut($type = null)
    {
        $idFromCart = ShopFn::GetIdFromCart();

        if($idFromCart)
        {
            $orderUser = BF::ReturnInfoUser(BF::idUser);

            if($type == "newuser")
            {
                $FirstName = BF::ClearCode("firstName", "str", "post");
                $LastName = BF::ClearCode("lastName", "str", "post");

                $login = BF::ClearCode("email", "str", "post");
                $password = BF::ClearCode("password", "str", "post");

                $checkUserInSystem = BF::CheckUserInSystem(BF::GeneratePass($login), BF::GeneratePass($password));

                if($checkUserInSystem == 1)
                {
                    BF::LoginUser(BF::GeneratePass($login), BF::GeneratePass($password));

                    $orderUserRow = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
                        BF::ReturnInfoUser(BF::idUser)
                    ]);

                    $nameUser = $orderUserRow["Users_surname"] . " " . $orderUserRow["Users_name"];
                }
                else
                {
                    R::exec("INSERT INTO Users(Users_name, Users_surname, Users_login, Users_password, Users_email) VALUES(?, ?, ?, ?, ?)", [
                        $FirstName,
                        $LastName,
                        BF::GeneratePass($login),
                        BF::GeneratePass($password),
                        $login
                    ]);

                    BF::LoginUser(BF::GeneratePass($login), BF::GeneratePass($password));

                    $orderUserRow = R::getRow("SELECT * FROM Users ORDER BY Users_id DESC");

                    $orderUser = $orderUserRow["Users_id"];

                    $nameUser = $orderUserRow["Users_surname"] . " " . $orderUserRow["Users_name"];
                }
            }
            else
            {
                $orderUserRow = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
                    BF::ReturnInfoUser(BF::idUser)
                ]);

                $nameUser = $orderUserRow["Users_surname"] . " " . $orderUserRow["Users_name"];
                $emailUser = $orderUserRow["Users_email"];
                $phoneUser = $orderUserRow["Users_phone"];
            }

            $orderDelivery = BF::ClearCode("delivery", "int", "post");
            $orderCountries = BF::ClearCode("countries", "int", "post");
            $orderState = BF::ClearCode("state", "int", "post");
            $orderCity = BF::ClearCode("city", "int", "post");
            $orderPostCode = BF::ClearCode("postCode", "int", "post");
            $orderAddress = BF::ClearCode("address", "str", "post");
            $orderTel = BF::ClearCode("tel", "str", "post");
            $orderSum = ShopFn::GetCartSum();

            $countryRow = R::getRow("SELECT * FROM countries WHERE id = ?", [
                $orderCountries
            ]);

            $stateRow = R::getRow("SELECT * FROM states WHERE id = ?", [
                $orderState
            ]);

            $cityRow = R::getRow("SELECT * FROM cities WHERE id = ?", [
                $orderCity
            ]);

            R::exec("INSERT INTO Address(Country, Region, City, Street, CityIndex, Address_user_id) VALUES(?, ?, ?, ?, ?, ?)", [
                $orderCountries,
                $orderState,
                $orderCity,
                $orderAddress,
                $orderPostCode,
                $orderUser
            ]);

            $idAddress = R::getRow("SELECT ID_address FROM Address WHERE Address_user_id = ? ORDER BY ID_address DESC", [
                $orderUser
            ]);

            $nameOrder = "Default Order";

            if($_SESSION["indComment"] && $_SESSION["indComment"] != "")
            {
                $nameOrder = "Individual Order";
            }

            $resultGroup = R::exec("INSERT INTO OrdersGroup(OrdersGroup_date, OrdersGroup_name, OrdersGroup_delivery, OrdersGroup_sum, OrdersGroup_user, OrdersGroup_address, OrdersGroup_comment) VALUES(?, ?, ?, ?, ?, ?, ?)", [
                date("Y-m-d H:i:s"), $nameOrder, $orderDelivery, $orderSum, $orderUser, $idAddress["ID_address"], BF::ClearCode("indComment", "str", "session")
            ]);

            unset($_SESSION["indComment"]);

            $products = "";

            if ($idFromCart != false && ShopFn::GetCountInCart() != 0) {
                $idGroup = R::getRow("SELECT OrdersGroup_id FROM OrdersGroup ORDER BY OrdersGroup_id DESC");

                foreach ($idFromCart as $key => $value) {
                    $productRow = R::getRow("SELECT * FROM Products WHERE ID_product = ?", [
                        $key
                    ]);

                    $resultOrders = R::exec("INSERT INTO Orders(Orders_id_group, Orders_id_product, Orders_count, Orders_prop) VALUES(?, ?, ?, ?)", [
                        $idGroup["OrdersGroup_id"], $key, $value["count"], json_encode($value["property"])
                    ]);

                    $products .= <<<EOF
<div style="width: 30%; display: inline-block">
    <img src="https://iq-lingerie.com{$productRow["ProductImagesPreview"]}" style="width: 100%"><br />
    <strong>{$productRow["ProductName" . USER_LANG]}</strong><br />
    <strong>Price:</strong> {$productRow["ProductPrice"]} $
</div>
EOF;
                }

                $message = <<<EOF
<h1>Order №{$idGroup["OrdersGroup_id"]}</h1>

<h3>User info</h3>
<strong>Name:</strong> {$nameUser}<br />
<strong>Email:</strong> {$login} {$emailUser}<br />
<strong>Tel:</strong> {$orderTel} {$phoneUser}<br />
<h3>Delivery</h3>
<strong>Country:</strong> {$countryRow["name"]}<br />
<strong>State:</strong> {$stateRow["name"]}<br />
<strong>City:</strong> {$cityRow["name"]}<br />
<strong>Address:</strong> {$orderAddress}<br />
<strong>Post code:</strong> {$orderPostCode}<br />
<h3>Sum</h3>
<strong>Sum order:</strong> {$orderSum} $ <br />
<h3>Products</h3>
{$products}
EOF;

                $to = "iq.intimatequestion@gmail.com";
//                $to = "hebesh88@gmail.com";

                $subject = 'New order!';

                $headers = "From: office@intimatequestion.com\r\n";
                $headers .= "Reply-To: office@intimatequestion.com\r\n";
                $headers .= "CC: office@intimatequestion.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                mail($to, $subject, $message, $headers);

                ShopFn::ClearCart();

                return $idGroup["OrdersGroup_id"];
            }
        }

        return false;
    }

    public static function GetOrders()
    {
        return R::getAll("SELECT * FROM OrdersGroup

        INNER JOIN OrdersStatus ON OrdersStatus.OrdersStatus_id = OrdersGroup.OrdersGroup_status

        WHERE OrdersGroup_user = ?", [BF::ReturnInfoUser(BF::idUser)]);
    }

    public static function GetProductsFromOrderGroup($idGroup)
    {
        return R::getAll("SELECT * FROM Orders

        INNER JOIN Products ON Products.ID_product = Orders.Orders_id_product
        
        WHERE Orders.Orders_id_group = ?", [
            $idGroup
        ]);
    }

    public static function GetProducts($data)
    {

        if($data["search"])
        {
            $result["products"] = R::getAll("SELECT * FROM Products

INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory

WHERE ProductName LIKE ? LIMIT ?, ?", [
                "%" . BF::ClearCode($data["search"], "str") . "%",
                BF::ClearCode($data["offset"], "int"),
                BF::ClearCode($data["limit"], "int")
            ]);

            $allProducts = R::getAll("SELECT * FROM Products

INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory

WHERE ProductName LIKE ?", [
                "%". BF::ClearCode($data["search"], "str") . "%"
            ]);
        }
        else if($data["category"])
        {
            $result["products"] = R::getAll("SELECT * FROM Products

INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory

WHERE ProductCategory = ? LIMIT ?, ?", [
                BF::ClearCode($data["category"], "int"),
                BF::ClearCode($data["offset"], "int"),
                BF::ClearCode($data["limit"], "int")
            ]);

            $allProducts = R::getAll("SELECT * FROM Products

INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory

WHERE ProductCategory = ?", [
                BF::ClearCode($data["category"], "int")
            ]);
        }
        else
        {
            $result["products"] = R::getAll("SELECT * FROM Products

INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory LIMIT ?, ?", [
                BF::ClearCode($data["offset"], "int"),
                BF::ClearCode($data["limit"], "int")
            ]);

            $allProducts = R::getAll("SELECT * FROM Products
            
            INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory");
        }


        $arrayLink = AuxiliaryFn::PaginationGenerate($allProducts, $data["limit"], $data["link"]);

        $result["links"] = $arrayLink["pagination"];

        return  $result;
    }

    public static function GetClients($data)
    {
        $result["users"] = R::getAll("SELECT * FROM Users WHERE Users_permission = 0 OR Users_permission = 1 LIMIT ?, ?", [
            BF::ClearCode($data["offset"], "int"),
            BF::ClearCode($data["limit"], "int")
        ]);

        $arrayLink = AuxiliaryFn::PaginationGenerate(R::getAll("SELECT * FROM Users WHERE Users_permission = 0 OR Users_permission = 1"), $data["limit"], $data["link"], BF::ClearCode($data["offset"], "int"));

        $result["links"] = $arrayLink["pagination"];

        return  $result;
    }

    public static function GetProductsFromWish()
    {
        $product = [];

        foreach (self::GetIdFromWish() as $value)
        {
            $product[] = R::getRow("SELECT * FROM Products WHERE ID_product = ?", [
                $value["Wish_id_product"]
            ]);
        }

        return $product;
    }

    public static function DeleteFromBalance($idProduct)
    {
        $listProducts = ShopFn::GetIdFromBalance();


//        AuxiliaryFn::StylePrint($idProduct);
//        AuxiliaryFn::StylePrint($listProducts);

        if (in_array($idProduct, $listProducts)) {
            if(($key = array_search($idProduct, $listProducts)) !== FALSE){
                unset($listProducts[$key]);
            }

            $_SESSION["balanceProducts"] = $listProducts;

            return true;
        }
    }

    public static function GetIdFromViewed()
    {
        $products = BF::ClearCode("viewedProducts", "array", "session");

        if (!is_array($products)) {
            $products = [];
        }

        return $products;
    }

    public static function GetIdFromCart()
    {
        $products = BF::ClearCode("cartProducts", "array", "session");

        if (!is_array($products)) {
            $products = [];
        }

        return $products;
    }

    public static function GetIdFromBalance()
    {
        $products = BF::ClearCode("balanceProducts", "array", "session");

        if (!is_array($products)) {
            $products = [];
        }

        return $products;
    }

    public static function GetIdFromWish()
    {
        return R::getAll("SELECT Wish_id_product FROM Wish WHERE Wish_user = ?", [
            BF::ReturnInfoUser(BF::idUser)
        ]);
    }

    public static function GetJustIdFromWish()
    {
        $products = R::getAll("SELECT Wish_id_product FROM Wish WHERE Wish_user = ?", [
            BF::ReturnInfoUser(BF::idUser)
        ]);

        $arrayProduct = [];

        foreach ($products as $value)
        {
            $arrayProduct[] = $value["Wish_id_product"];
        }
        return $arrayProduct;
    }

    public static function GetProductsInCart()
    {
        $listProducts = ShopFn::GetIdFromCart();

        if (is_array($listProducts) && count($listProducts) > 0) {
            $stringArray = str_replace(",", " OR ID_product = ", implode(",", array_keys($listProducts)));

            $products = R::getAll("SELECT * FROM Products WHERE ID_product = " . $stringArray);

            return $products;
        }

        return false;
    }

    public static function GetProductsInBalance()
    {
        $listProducts = ShopFn::GetIdFromBalance();

        if (is_array($listProducts) && count($listProducts) > 0) {
            $stringArray = str_replace(",", " OR ID_product = ", implode(",", array_values($listProducts)));

            return R::getAll("SELECT * FROM Products WHERE ID_product = " . $stringArray);
        }

        return false;
    }

    public static function GetWishProducts()
    {
        $listProducts = ShopFn::GetJustIdFromWish();

        if (is_array($listProducts) && count($listProducts) > 0) {
            $stringArray = str_replace(",", " OR ID_product = ", implode(",", $listProducts));

            return R::getAll("SELECT * FROM Products WHERE ID_product = " . $stringArray);
        }

        return false;
    }

    public static function GetCharacteristic($category)
    {
        return R::getAll("SELECT * FROM CharacteristicsSchema WHERE cSchema_Category_FK = ?", [$category]);
    }

    public static function GetCartSum()
    {
        $sum = 0;

        if(ShopFn::GetProductsInCart())
        {
            foreach (ShopFn::GetProductsInCart() as $product)
            {
                $productInfo = self::GetIdFromCart();

                $wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
                    $product["ID_product"]
                ]);

                $price = $product["ProductPrice"];

                foreach ($wholesale as $subValue)
                {
                    if($productInfo[$product["ID_product"]]["count"] >= $subValue["Wholesale_count"])
                    {
                        $price = $subValue["Wholesale_price"];
                    }
                }

                $sum += $price * $productInfo[$product["ID_product"]]["count"];
            }
        }

        return $sum;
    }

    public static function GetListDelivery()
    {
        return R::getAll("SELECT *, CONCAT(Country, ', ', Region, ', ', City, ', ', Street, ', ', Build_numb) AS Name FROM Address WHERE Address_user_id = ?", [BF::ReturnInfoUser(BF::idUser)]);
    }

    public static function GetListPayment()
    {
        return R::getAll("SELECT * FROM PaymentType");
    }

    public static function GetUserInfo()
    {
        return R::getRow("SELECT * FROM Users WHERE Users_id = ?", [BF::ReturnInfoUser(BF::idUser)]);
    }

    public static function DrawSelectPublished($valueSelect)
    {
        $select = [
            0 => "Не опубликован",
            1 => "Опубликован"
        ];
    }

    public static function Search($data = null)
    {
        $query = BF::CreateLikeQuery(["ProductName" . USER_LANG, "ProductDescription"], BF::ClearCode("q", "str", "get"));

        $result["products"] = R::getAll("SELECT * FROM Products WHERE " . $query . " LIMIT ?, ?", [
            BF::ClearCode($data["offset"], "int"),
            BF::ClearCode($data["limit"], "int")
        ]);

        $arrayLink = AuxiliaryFn::PaginationGenerate(R::getAll("SELECT * FROM Products WHERE " . $query), $data["limit"], "/search/s?q=" . BF::ClearCode("q", "str", "get") . "&" . $data["link"], BF::ClearCode($data["offset"], "int"));

        $result["links"] = $arrayLink;

        return  $result;
    }

    public static function SearchWish($search)
    {
        foreach (self::GetIdFromWish() as $value)
        {
            if($value["Wish_id_product"] == $search)
            {
                return true;
            }
        }

        return false;
    }

    public static function GetCurrency()
    {
        $currencyId = BF::ClearCode("currency", "int", "cookie");

        if($currencyId == 0)
        {
            $currencyId = 1;
        }

//        AuxiliaryFn::StylePrint("");

        $currency = R::getRow("SELECT * FROM Currency WHERE Currency_id = ?", [
            $currencyId
        ]);

        $data = [
            "left" => $currency["Currency_symbol_left"],
            "right" => $currency["Currency_symbol_right"],
            "value" => $currency["Currency_value"]
        ];

        return $data;
    }

    public static function ProductAvailability($count)
    {
        $data = [];

        if($count == 0)
        {
            $data["class"] = "empty";
            $data["icon"] = "<i class=\"fa fa-battery-empty\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Нет в наличии\"></i>";
            $data["text"] = "Нет в наличии";
        }
        else if($count < 10)
        {
            $data["class"] = "few";
            $data["icon"] = "<i class=\"fa fa-battery-quarter\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Заканчивается\"></i>";
            $data["text"] =  "Заканчивается";
        }
        else
        {
            $data["class"] = "have";
            $data["icon"] = "<i class=\"fa fa-battery-full\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Есть в наличии\"></i>";
            $data["text"] =  "Есть в наличии";
        }

        return $data;
    }
 
    public static function GetPath($workCategory, $massive)
    {
        $thisCategory = R::getRow("SELECT * FROM Categories WHERE Categories_id = ?", [
            $workCategory
        ]);

        if(intval($thisCategory["Categories_parent"]) > 0)
        {
            $workCategory = intval($thisCategory["Categories_parent"]);

            $thisCategoryName = R::getRow("SELECT Categories_name FROM Categories WHERE Categories_id = ?", [
                $workCategory
            ]);

            $massive[$workCategory]["name"] = $thisCategoryName["Categories_name"];
            $massive[$workCategory]["id"] = $workCategory;

            return ShopFn::GetPath($workCategory, $massive);
        }
        else
        {
            return $massive;
        }
    }

    public static function PrintStyleRecurs($data, $default = null)
    {
        $massive = array_reverse($data);

        $i = 1;

        $print = "<a href='/'>Главная</a> <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i> ";

        foreach ($massive as $key => $value)
        {
            $dop = "";
            $class = "";

            if($i < count($massive))
            {
                $dop = " <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i> ";
            }

            if($default && $value["id"] == $default)
            {
                $class = "active";
            }

            $print .= "<a href='/category/" . $value["id"] . "' class='" . $class . "'>" . $value["name"] . "</a>" . $dop;

            $i++;
        }

        return $print;
    }

    public static function GetRatingProduct($idProduct)
    {
        $rating = R::getRow("SELECT SUM(Rating_value) / COUNT(*) as Rating_sum, COUNT(*) as Rating_count FROM Rating WHERE Rating_product = ?", [
            $idProduct
        ]);

        $result["value"] = round($rating["Rating_sum"], 2);
        $result["count"] = $rating["Rating_count"];

        $rating = $rating["Rating_sum"] * 100 / 5;

        $result["icon"] = IncludesFn::ReturnRating($rating);

        return $result;
    }

    /*
     * FRONT END FUNCTIONS
     */

    public static function DesignCartInfo()
    {
        $countInCart = ShopFn::GetCountInCart();

        $classCart = "false";

        $language = new Languages;

        $productsInCart = <<<EOF
Empty
EOF;

        if($countInCart > 0)
        {
            $classCart = "active";

            $productsInCart = "";

            $cart = ShopFn::GetIdFromCart();

            foreach (ShopFn::GetProductsInCart() as $item)
            {
//                $price = "$" . $item["ProductPrice"];
                $price = $_SESSION['currency_symbol_left'] . number_format($item["ProductPrice"] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

                $productsInCart .= <<<EOF
<li class="item">
    <div class="item-image">
        <a class="product-image" href="/product/{$item["ID_product"]}"><img src="{$item["ProductImagesPreview"]}" width="120" height="165" alt=""></a>
    </div>
    <div class="item-infos">
        <div class="product-name pull-left">
            <a href="/product/{$item["ID_product"]}">{$item["ProductName" . USER_LANG]}</a>
        </div>
        <dl class="item-options dl-horizontal pull-left">
            <dt>{$language->Translate('quantity')} :</dt>
            <dd>{$cart[$item["ID_product"]]["count"]}</dd>
        </dl>
    </div>
    <div class="item-price">
        <span class="price">{$price}</span>
    </div>
</li>
EOF;

            }

//            $sumInCart = ShopFn::GetCartSum();
            $sumInCart = $_SESSION['currency_symbol_left'] . number_format(ShopFn::GetCartSum() * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

            $productsInCart = <<<EOF
<div class="block-title">
<strong><span>{$language->Translate('my_cart')}</span></strong>
</div>
<div class="cart-summary-wrapper">
    <div class="block-content">
        <input type="hidden" value="3" name="cart-summary-nb-products" class="cart-summary-nb-products">
        <ul class="unstyled">
            {$productsInCart}
        </ul>
    </div>
</div>
<div id="shopping-cart-totals" class="row">
    <div>
        <div class="total-inc row">
            <div class="total-label span3">
                {$language->Translate('subtotal_incl_tax')}    </div>
            <div class="total-price span1">
                <span class="price">{$sumInCart}</span>    </div>
        </div>
    </div>
</div>
<div class="actions">
    <a class="btn btn-primary" href="/cart/" data-gua-event-action="My Cart" data-gua-event-category="Navigation" data-gtm-event-label="My Cart">{$language->Translate('go_to_my_cart')}</a>
</div>
EOF;
        }

        $data["count"] = $countInCart;
        $data["class"] = $classCart;
        $data["html"] = $productsInCart;
        $data["textAdded"] = $language->Translate('added_to_cart');

        return $data;
    }

    public static function DesignWishInfo()
    {
        $countWish = ShopFn::GetCountWish();

        $classWish = "false";

        $productsInWish = <<<EOF
<span>Желаний нет</span>
<i class="fa fa-heart-o"></i>
EOF;

        if($countWish > 0)
        {
            $classWish = "active";

            $productsInWish = BF::GenerateList(ShopFn::GetWishProducts(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-product-from-wish" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName" . USER_LANG, "ID_product"]);

            $productsInWish = <<<EOF
    <strong>Мои желания</strong>
    <hr />
    {$productsInWish}
    <hr />
    <a href="/user/wish" class="go-to">Мои желания</a>
EOF;
        }

        $data["count"] = $countWish;
        $data["class"] = $classWish;
        $data["html"] = $productsInWish;

        return $data;
    }

    public static function DesignBalanceInfo()
    {
        $countBalance = ShopFn::GetCountInBalance();

        $classBalance = "false";

        $productsInBalance = <<<EOF
<span>Тут нечего сравнивать</span>
<i class="fa fa-balance-scale"></i>
EOF;

        if($countBalance > 0)
        {
            $classBalance = "active";

            $productsInBalance = BF::GenerateList(ShopFn::GetProductsInBalance(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-from-balance" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName" . USER_LANG, "ID_product"]);

            $productsInBalance = <<<EOF
    <strong>Сравнение</strong>
    <hr />
    {$productsInBalance}
    <hr />
    <a href="/balance/" class="go-to">Перейти к сравнению</a>
EOF;
        }

        $data["count"] = $countBalance;
        $data["class"] = $classBalance;
        $data["html"] = $productsInBalance;

        return $data;
    }

    public static function DrawProduct($data, $col = null, $inline = 4, $view = "block") //Design Product
    {
        $language = new Languages;

        $productOne = '';
        $html = "";
        $startCount = 1;

        if($col == null)
        {
            $col = 4;
        }

        foreach ($data as $key => $value)
        {
            $balance = '';
            $heartClass = '';
            $lastPrice = '';
            $discount = '';
            $popularProduct = '';
            $novelty = '';
            $heart = 'fa-heart-o';

            $availability = ShopFn::ProductAvailability($value["ProductCount"]);

            if(array_key_exists ($value["ID_product"], ShopFn::GetIdFromCart()))
            {
                $buttonCart = '<button class="added-to-cart" data-id="' . $value["ID_product"] . '"><i class="fa fa-check" aria-hidden="true"></i> В корзине</button>';
            }
            else
            {
                if($value["ProductCount"] > 0)
                {
                    $buttonCart = '<button class="add-to-cart" data-id="' . $value["ID_product"] . '"><i class="fa fa-shopping-basket" aria-hidden="true"></i> В корзину</button>';
                }
                else
                {
                    $buttonCart = '<button class="none-to-cart" data-id="' . $value["ID_product"] . '"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Нет в наличии</button>';
                }
            }

            if(in_array($value["ID_product"], ShopFn::GetIdFromBalance()))
            {
                $balance = 'active';
            }

            if(ShopFn::SearchWish($value["ID_product"]))
            {
                $heart = 'fa-heart';

                $heartClass = "active";
            }

            if($value["ProductLastPrice"] != 0)
            {
                $lastPrice = '<span class="last-price">' . $value["ProductLastPrice"] . '</span>';

//                $discount = '<span class="discount">%</span>';
//                $discount = '<span class="discount">Акция</span>';
                $discount = '<i class="fa fa-percent" data-toggle="tooltip" data-placement="bottom" title="Скидка"></i>';
            }

            if($value["ProductPopular"] != 0)
            {
//                $popularProduct = '<span class="discount popular"><i class="fa fa-rocket" aria-hidden="true"></i></span>';
//                $popularProduct = '<span class="discount popular">Топ продаж</span>';
                $popularProduct = '<i class="fa fa-rocket" data-toggle="tooltip" data-placement="bottom" title="Топ продаж"></i>';
            }
            
            if(BF::DifferenceDate($value["ProductAddDate"]) <= 12)
            {
//                $novelty = '<span class="discount novelty"><i class="fa fa-calendar" aria-hidden="true"></i></span>';
//                $novelty = '<span class="discount novelty"><i class="fa fa-clock-o"></i></span>';
                $novelty = '<i class="fa fa-clock-o" data-toggle="tooltip" data-placement="bottom" title="Недавно добавлен"></i>';
            }

            $echoCharacteristics = BF::GenerateList(ShopFn::GetCharacteristics($value["ID_product"]), '<strong class="strong">?:</strong> ?, ', ["cSchema_Name", "cValueValue"]);

//

            if($view == "list")
            {
                $price = '<span class="money">' . number_format($value["ProductPrice"], 0, '', ' ').'</b>' . $lastPrice . ' грн</span>';

                $productOne .= <<<EOF
                <div class="col-md-12">
                    <div class="one-product inline">
                        <a href="/product/{$value["ID_product"]}"><img src="{$value["ProductImagesPreview"]}" /></a>
                        <div class="info-block">
                            <a href="/product/{$value["ID_product"]}">
                                <strong>{$value["ProductName" . USER_LANG]}</strong>
                            </a>
                            {$echoCharacteristics}
                            <!--<span class="availability {$availability["class"]}">{$availability["text"]}</span>
                            <div class="info-product-else">{$discount} {$popularProduct} {$novelty}</div>-->
                        </div>
                        <div class="manage-block">
                            <div class="status-product margin-bottom">
                            {$availability["icon"]} {$discount} {$popularProduct} {$novelty}
                            </div>
                            {$price}<br />
                            {$buttonCart}
                            <button class="heart-button top-button {$heartClass} clear-button" data-id="{$value["ID_product"]}" data-toggle="tooltip" data-placement="bottom" title="Желаю">
                            <i class="fa {$heart}" aria-hidden="true"></i></button>
                            <button class="balance-button clear-button {$balance}" data-id="{$value["ID_product"]}" data-toggle="tooltip" data-placement="bottom" title="В сравнение">
                            <i class="fa fa-balance-scale" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
EOF;

            }
            else
            {
                $price = $_SESSION['currency_symbol_left'] . number_format($value["ProductPrice"] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $listCategory = [];

                /*
                 * Выбор характеристик
                 */

                $prop = R::getAll("SELECT * FROM PropertiesValues

INNER JOIN Properties ON Properties.PropertiesValues_id = PropertiesValues.Properties_id_value

INNER JOIN PropertiesParent ON PropertiesParent.PropertiesGroup_id = Properties.PropertiesValues_category

WHERE Properties_product = ?", [
                    $value["ID_product"]
                ]);

                /*
                 * Генерируем массив из ID разбитый по категориям (Цвет, Размер и тд)
                 */

                foreach ($prop as $subValue)
                {
                    $categoryId = $subValue["PropertiesGroup_id"];

                    if(!in_array($categoryId, $listCategory))
                    {
                        $listCategory[] = $categoryId;
                    }
                }

                /*
                 * Генерируем массив разбитый по категориям
                 */

                $resultArray = [];

                foreach ($listCategory as $item)
                {
                    foreach ($prop as $subKey => $subValue)
                    {
                        if($subValue["PropertiesGroup_id"] == $item)
                        {
                            $resultArray[$item][] = $prop[$subKey];
                        }
                    }
                }

                $listProductsInCart = ShopFn::GetIdFromCart();

                $div = "";

                $classSelect = ["color", "size", "size size2"];

                $iC = 0;

                foreach ($resultArray as $product)
                {
                    $text = "";

                    $firstPropName = "";

                    $firstPropId = "";

                    $valSelect = 0;
                    $idSelected = 0;
                    $nameSelect = $language->Translate('unselected');
                    $valNameSelect = "";

                    $countLi = 0;

                    foreach ($product as $item) {
                        $active = "";

                        if($listProductsInCart)
                        {
                            if(is_array($listProductsInCart[$value["ID_product"]]["property"]))
                            {
                                if(in_array($item["Properties_id"], $listProductsInCart[$value["ID_product"]]["property"]))
                                {
                                    $active = "active";
                                }
                            }

                        }

                        if($firstPropName == null)
                        {
                            $firstPropName = $item["PropertiesValues_name" . USER_LANG];
                        }

                        if($firstPropId == null)
                        {
                            $firstPropId = $item["PropertiesValues_id"];
                        }

                        $nameGroup = $product[0]["PropertiesGroup_name" . USER_LANG];

                        if($value["ProductCategory"] == 59 && $product[0]["PropertiesGroup_id"] == 2)
                        {
                            $nameGroup = $language->Translate('bra_size');
                        }
                        else if($value["ProductCategory"] == 59 && $product[0]["PropertiesGroup_id"] == 3)
                        {
                            $nameGroup = $language->Translate('pants_size');
                        }

                        $valSelect = $item["PropertiesValues_id"];
                        $valNameSelect = $item["PropertiesValues_name" . USER_LANG];

                        $text .= <<<EOF
<li data-id="{$item["PropertiesValues_id"]}" class="selectboxit-option  selectboxit-option-first selectboxit-selected" data-sort="{$item["PropertiesValues_name" . USER_LANG]}">
    <a class="selectboxit-option-anchor" data-original-title="" title="">
        <span class="selectboxit-option-icon-container">
            <i class="selectboxit-option-icon  selectboxit-container"></i>
        </span>
        {$nameGroup} : {$item["PropertiesValues_name" . USER_LANG]}
    </a>
</li>
EOF;
                        $countLi++;

                    }

                    if($countLi == 1)
                    {
                        $idSelected = $valSelect;
                        $nameSelect = $valNameSelect;
                    }

                    $div .= <<<EOF
<div class="{$classSelect[$iC]} prop-each clearfix" data-id="{$product[0]["PropertiesGroup_id"]}" data-val="{$idSelected}" data-attribute-code="color">
    <h2 class="option label">{$nameGroup}</h2>
    <span id="" class="selectboxit-container product-prop" role="combobox"  aria-owns="">
        <span id="" class="selectboxit options selectboxit-enabled selectboxit-btn" name="" tabindex="0" unselectable="on" style="width: 208px;">
            <span class="selectboxit-option-icon-container"><i id="" class="selectboxit-default-icon selectboxit-option-icon selectboxit-container" unselectable="on"></i></span>
            <span id="" class="selectboxit-text" unselectable="on" data-val="12011" aria-live="polite" style="max-width: 178px;">{$nameGroup} : <b class="selected-ul-li">{$nameSelect}</b></span>
            <span id="" class="selectboxit-arrow-container" unselectable="on"><i id="" class="selectboxit-arrow selectboxit-default-arrow" unselectable="on"></i></span>
        </span>
        <ul class="selectboxit-options selectboxit-list">
            {$text}
        </ul>
    </span>
    <input id="super_attribute[92]" type="hidden" value="12011" name="super_attribute[92]">
</div>
EOF;
                    $iC++;
                }

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $imgWaterMark = "";

//                BF::ReturnWaterMark($value["ProductImagesPreview"]);

                $imgWaterMark = BF::ReturnWaterMark($value["ProductImagesPreview"]);

                $productOne .= <<<EOF
<li class="item location_0" data-id="{$value["ID_product"]}" data-type="configurable">
    <div class="product-image-box thumbnail ">
        <a href="/product/{$value["ID_product"]}" title="Aran knit sweater with basque hemline" class="product-image">
            <span class="normal-images">            
                <img data-lazyload="unveil" data-wm="{$value["ProductImagesPreview"]}" class="base-image" src="{$imgWaterMark}" alt="Aran knit sweater with basque hemline">
                <!--<noscript>-->
                    <!--&lt;img class="base-image"  src="https://media.soniarykiel.com/media/catalog/product/cache/5/image/598x895/9df78eab33525d08d6e5fb8d27136e95/3/6/3605738902281-6.jpg" width="598" height="895" alt="Aran knit sweater with basque hemline" /&gt;-->
                <!--</noscript> -->
            </span>
        </a>
        <div class="prop-hide clearfix catalog-product-view">
            <!--<button class="close-prop"></button>-->
            <div class="product-options right_part" id="product-options-wrapper">
                <input id="product_id" type="hidden" value="300881" name="product_id">
                {$div}
                <button class="add-to-c-f" data-id="{$value["ID_product"]}">{$language->Translate('add_to_cart')}</button>
            </div>
        </div>
    </div>
    <div class="product-shop">
        <h2 class="product-name"><a href="/product/{$value["ID_product"]}" title="Aran knit sweater with basque hemline">{$value["ProductName" . USER_LANG]}</a></h2>
        <div class="price-box" itemprop="offers" itemscope="" itemtype="http://data-vocabulary.org/Offer">
            <span itemprop="price" class="regular-price" id="product-price-300881">
                <span class="price">{$price}</span>
                <button class="add-to-c">{$language->Translate('buy_now')}</button>
            </span>
        </div>
    </div>
    <div class="del"></div>
</li>
EOF;

            }

            if($startCount == $inline)
            {
//                $html .= <<<EOF
//                <div class="row perspective">
//                    {$productOne}
//                </div>
//EOF;
                $html .= <<<EOF
            {$productOne}
EOF;
                $productOne = "";
                $startCount = 0;

            }

            $startCount++;
        }

        if(--$startCount != $inline)
        {
//            $html .= <<<EOF
//                <div class="row perspective">
//                    {$productOne}
//                </div>
//EOF;
            $html .= <<<EOF
            {$productOne}
EOF;
        }

        return $html;
    }

    public static function GetCharacteristics($idProduct)
    {
        return R::getAll("SELECT * FROM CharacteristicsOutput

        INNER JOIN CharacteristicsSchema ON CharacteristicsSchema.ID_cSchema = CharacteristicsOutput.cOutput_id_Schema
        
        INNER JOIN CharacteristicsValue ON CharacteristicsValue.ID_cValue = CharacteristicsOutput.cOutput_id_Value
        
        WHERE CharacteristicsOutput.cOutput_id_Product = ?", [$idProduct]);
    }
}