<?php
class IncludesFn
{
    public static function printHeader($title, $bodyClass = null, $info = null)
    {
        $menuVisible = BF::ClearCode("menu", "str", "cookie");

        $language = new Languages;

        $categoriesLi = "";

        foreach (DataBase::GetRootCategory() as $item)
        {
            $categoriesLi .= <<<EOF
<li>
    <a href="/category/{$item["Categories_id"]}" class="category">{$item["Categories_name" . USER_LANG]}</a>
</li>
EOF;
        }

        $cartHtml = <<<EOF
{$language->Translate('cart_empty')}
EOF;

        $countInCart = ShopFn::GetCountInCart();

        if($countInCart > 0)
        {
            $classCart = "active";

//    $productsInCart = BF::GenerateList(ShopFn::GetProductsInCart(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-product-in-cart" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName", "ID_product"]);
            $productsInCart = BF::GenerateList(ShopFn::GetProductsInCart(),
                '<li class="item clearfix">
                    <div class="item-image">
                        <a class="product-image" href="/product/?"><img src="?" width="120" height="165" alt=""></a>
                    </div>
                    <div class="item-infos">
                        <div class="product-name pull-left">
                            <a href="/product/?">?</a>
                        </div>
                        <dl class="item-options dl-horizontal pull-left">
                            <dt>' . $language->Translate('quantity') . ' :</dt>
                            <dd>1</dd>
                        </dl>
                    </div>
                    <div class="item-price">
                        <span class="price">$?</span>
                    </div>
                </li>',
                ["ID_product", "ProductImagesPreview", "ID_product", "ProductName" . USER_LANG, "ProductPrice"]);

//            $productsInCart = "";
//
//            foreach (ShopFn::GetProductsInCart() as $itemCart) {
//                $price = $_SESSION['currency_symbol_left'] . number_format($itemCart['ProductPrice'] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];
//
//                $productsInCart .= <<<EOF
//<li class="item">
//    <div class="item-image">
//        <a class="product-image" href="/product/{$itemCart["ID_product"]}"><img src="{$itemCart["ProductImagesPreview"]}" width="120" height="165" alt=""></a>
//    </div>
//    <div class="item-infos">
//        <div class="product-name pull-left">
//            <a href="/product/{$itemCart["ID_product"]}">{$itemCart["ProductName" . USER_LANG]}</a>
//        </div>
//        <dl class="item-options dl-horizontal pull-left">
//            <dt>{$language->Translate('quantity')}</dt>
//            <dd>1</dd>
//        </dl>
//    </div>
//    <div class="item-price">
//        <span class="price">{$price}</span>
//    </div>
//</li>
//EOF;
//            }
            $productsInCart = "";

            $cart = ShopFn::GetIdFromCart();

            foreach (ShopFn::GetProductsInCart() as $item)
            {
//                $price = "$" . $item["ProductPrice"];

                $price = $_SESSION['currency_symbol_left'] . number_format($item['ProductPrice'] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

                $productsInCart .= <<<EOF
<li class="item clearfix">
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

            $cartHtml = <<<EOF
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

        $menuUser = <<<EOF
<li class="grey user"><a href="/login/">{$language->Translate('log_in')}</a></li>
<li class="grey"><a href="/sign-up/">{$language->Translate('signup')}</a></li>
EOF;

        if(BF::IfUserInSystem())
        {
            $menuUser = <<<EOF
<li class="grey"><a href="/user/">{$language->Translate('my_account')}</a></li>
<li class="grey"><a href="/user/information">{$language->Translate('my_informations')}</a></li>
<li class="grey"><a href="/user/orders">{$language->Translate('my_orders')}</a></li>
<li class="grey"><a href="/user/wish">{$language->Translate('my_wishlist')}</a></li>
<li class="grey logout quit-user" style="margin-top: 10px;"><a class="btn btn-primary">{$language->Translate('logout')}</a></li>
EOF;
        }

        $header = <<<EOF
<!DOCTYPE html>
<html>
<head>

<title>{$title}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/Libs/FrontEnd/css/font-awesome.css">
<link rel="stylesheet" href="/Libs/FrontEnd/css/styles_libs.css">
<link rel="stylesheet" href="/Libs/FrontEnd/css/styles.css">
<link rel="stylesheet" href="/Libs/FrontEnd/swiper/css/swiper.css">

<link rel="shortcut icon" type="image/png" href="/favicon.png"/>

{$info}

</head>
<body class="{$bodyClass} {$menuVisible}">
<script>
moneyCurrency = {$_SESSION['currency']};
moneyCurrencyLeft = '{$_SESSION['currency_symbol_left']}';
moneyCurrencyRight = '{$_SESSION['currency_symbol_right']}';
</script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 816634229;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/816634229/?guid=ON&amp;script=0"/>
</div>
</noscript>
<div class="mobile-menu">
    <ul>
        <li class="mobile-order-call">
            <a href="tel:+380503363655">+380503363655</a>
            <button class="order-call-button">{$language->Translate('order_call')}</button>
        </li>
        <li><form name="searchMobi" action="/search/s" method="get"><input type="text" name="q" placeholder="{$language->Translate('search')}"><button type="submit"><i class="fa fa-search"></i></button></form></li>
        {$categoriesLi}
        <li><a href="/individual-order/" class="category">{$language->Translate('individual_order')}</a></li>
        {$menuUser}
        <li class="grey"><a href="/content/about-us">{$language->Translate('about_us')}</a></li>
    </ul>
</div>
<div class="mobile-cart">
    {$cartHtml}
</div>
<div class="copy-body">
EOF;
        print($header);

    }

    public static function ReturnRating($int) // From 0 To 100
    {
        $countFull = (int)($int / 20);
        $countHalf = 0;

        if($int %20 != 0)
        {
            $countHalf = 1;
        }

        $countEmpty =  5 - (int)($countFull + $countHalf);

        $arrayRating = [$countFull, $countHalf, $countEmpty];

        $htmlRating = "";

        foreach ($arrayRating as $key => $value)
        {
            for ($i = 0; $i < $value; $i++)
            {
                if($key == 0)
                {
                    $htmlRating .= '<i class="fa fa-star" aria-hidden="true"></i>';
                }
                else if($key == 1)
                {
                    $htmlRating .= '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                }
                else
                {
                    $htmlRating .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                }
            }
        }

        return $htmlRating;
    }

    public static function ReturnIconCategory($name)
    {
        switch ($name)
        {
            case ("web"):
                return "/Images/Icons/web-03.svg"; break;
        }
    }

    public static function printMenuCategory($sql, $url, $name, $default = null, $prefix = null)
    {
        $category = R::getAll($sql);

        $li = "";

        foreach ($category as $value)
        {
            $href = $value[$url];
            $title = $value[$name];

            if($href == $default)
            {
                $li .= '<li><a href="' . $prefix . $href . '" class="active"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . $title . '</a></li>';
                continue;
            }

            $li .= '<li><a href="' . $prefix . $href . '"><i class="fa fa-circle-o" aria-hidden="true"></i> ' . $title . '</a></li>';
        }
        $menu = <<<EOF
            <ul>
                {$li}
            </ul>
EOF;
        return $menu;
    }

    public static function printMenu($url, $menuName, $className = null, $shell = null, $print = null)
    {
        $menu = "";

        $arrayMenu = [
            "/" => 'dashboard_menu_home_page',
            "/services/" => 'dashboard_menu_services',
            "/blog/" => 'dashboard_menu_blog',
            "/portfolio/" => 'dashboard_menu_portfolio',
            "/shop/" => 'dashboard_menu_template_shop',
            "/contacts/" => 'dashboard_menu_contacts',
        ];

        if($menuName == "base")
        {
            $li = "";

            foreach ($arrayMenu as $key => $value)
            {
                if($key == $url)
                {
                    $li .= '<li><a href="' . $key . '" class="active">' . Languages::Translate($value) . '</a></li>';
                    continue;
                }

                $li .= '<li><a href="' . $key . '">' . Languages::Translate($value) . '</a></li>';
            }
            $menu = <<<EOF
                <ul>
                    {$li}
                </ul>
EOF;
        }

        if($shell)
        {
            $languagesSwitch = Languages::LanguageSwitch("in");

            $menu = <<<EOF
            <div class="header-any-page clearfix {$className}">
                <div class="head-logo">
                    <a href="/"><div class="link-go-home"><img alt="Carrot" src="/Images/Home/logoBold-03.svg"></div></a>
                </div>
                <div class="head-menu">
                    <button><i class="fa fa-bars" aria-hidden="true"></i></button>
                    {$menu}
                </div>
                <div class="head-user">
                    {$languagesSwitch}
                        <a href="/login/"><button class="login-button clear-button"><span><i class="fa fa-user" aria-hidden="true"></i></span></button></a>
                </div>
            </div>
EOF;
        }

        if($print)
        {
            return print($menu);
        }
        return $menu;
    }

    public static function GenerateCategoryMenu()
    {
        $rootCategory = R::getAll("SELECT * FROM Categories WHERE Categories_parent = 0");

        $rootLi = '';

        foreach ($rootCategory as $value)
        {
            $subCategory = R::getAll("SELECT * FROM Categories WHERE Categories_parent = ?", [$value["Categories_id"]]);

            $subLi = '';
            $img = '';

            foreach ($subCategory as $subValue)
            {
                $popularProducts = R::getAll("SELECT * FROM Categories WHERE Categories_parent = ?", [$subValue["Categories_id"]]);

                $liProduct = '';

                foreach($popularProducts as $productValue)
                {
                    $liProduct .= '<li class="menu-li" data-id="'.$productValue["Categories_id"].'" data-img="/Images/Products/'.$productValue["ProductImagesPreview"].'"><a href="/category/'.$productValue["Categories_id"].'">' . $productValue["Categories_name"] . '</a></li>';
                }

                $ulProduct = '<ul>' . $liProduct . '</ul>';

                $subLi .= '<div><a href="/category/' . $subValue["Categories_id"] . '">' . $subValue["Categories_name"] . '</a>'.$ulProduct.'</div>';
            }

            $shares = R::getRow("SELECT * FROM Shares WHERE Shares_category = ? AND Shares_view = 1", [
                $value["Categories_id"]
            ]);

            if(intval($shares["shares_id"]) > 0)
            {
                $img = '<div class="img-preview-menu">
                    <strong>' . $shares["shares_title"] . '</strong>
                    <img src="' . $shares["shares_img"] . '">
                    <a href="' . $shares["shares_url"] . '">Перейти</a>
                </div>';
            }

            $subLi = '<div>' . $subLi . $img .'</div>';

            $rootLi .= '<li><a href="/category/' . $value["Categories_id"] . '">' . $value["Categories_name"] . "</a>" . $subLi . '</li>';
        }

        $ul = '<ul>' . $rootLi . '</ul>';

        return $ul;
    }
}
