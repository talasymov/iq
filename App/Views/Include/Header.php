<?php
//$menu = BF::GenerateList(DataBase::GetMenu(), '<a href="?">?</a>', ["Link", "Name"]);
$contacts = BF::GenerateList(DataBase::GetContacts(), '<span class="one-phone"><i class="fa fa-phone" aria-hidden="true"></i> ?</span>', ["phones_text"]);
$countInCart = ShopFn::GetCountInCart();
$countWish = ShopFn::GetCountWish();
$countBalance = ShopFn::GetCountInBalance();

//$productsInCart = <<<EOF
//<span>В корзине пусто</span>
//<i class="fa fa-shopping-basket"></i>
//EOF;

$language = new Languages;

$cartHtml = <<<EOF
{$language->Translate('cart_empty')}
EOF;

$productsInBalance = <<<EOF
<span>Тут нечего сравнивать</span>
<i class="fa fa-balance-scale"></i>
EOF;

$productsInWish = <<<EOF
<span>Желаний нет</span>
<i class="fa fa-heart-o"></i>
EOF;

$classCart = "false";
$classWish = "false";
$classBalance = "false";

if($countInCart > 0)
{
    $classCart = "active";

//    $productsInCart = BF::GenerateList(ShopFn::GetProductsInCart(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-product-in-cart" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName", "ID_product"]);
//    $productsInCart = BF::GenerateList(ShopFn::GetProductsInCart(),
//        '<li class="item">
//                    <div class="item-image">
//                        <a class="product-image" href="/product/?"><img src="?" width="120" height="165" alt=""></a>
//                    </div>
//                    <div class="item-infos">
//                        <div class="product-name pull-left">
//                            <a href="/product/?">?</a>
//                        </div>
//                        <dl class="item-options dl-horizontal pull-left">
//                            <dt>'.$language->Translate('quantity').' :</dt>
//                            <dd>1</dd>
//                        </dl>
//                    </div>
//                    <div class="item-price">
//                        <span class="price">$?</span>
//                    </div>
//                </li>',
//        ["ID_product", "ProductImagesPreview", "ID_product", "ProductName", "ProductPrice"]);
//    $productsInCart = "";

    $cart = ShopFn::GetIdFromCart();

    foreach (ShopFn::GetProductsInCart() as $item)
    {
//        $price = "$" . $item["ProductPrice"];
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
//    $productsInCart = <<<EOF
//    <strong>Корзина</strong>
//    <hr />
//        <div>
//            {$productsInCart}
//        </div>
//    <hr />
//    <a href="/cart/" class="go-to">Перейти в корзину</a>
//EOF;

//    var_dump(ShopFn::GetCartSum());

//    $sumInCart = ShopFn::GetCartSum();
    $sumInCart = $_SESSION['currency_symbol_left'] . number_format(ShopFn::GetCartSum() * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

    $cartHtml = <<<EOF
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

if($countBalance > 0)
{
    $classBalance = "active";

    $productsInBalance = BF::GenerateList(ShopFn::GetProductsInBalance(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-from-balance" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName", "ID_product"]);

    $productsInBalance = <<<EOF
    <strong>Сравнение</strong>
    <hr />
    {$productsInBalance}
    <hr />
    <a href="/balance/" class="go-to">Перейти к сравнению</a>
EOF;
}

if($countWish > 0)
{
    $classWish = "active";

    $productsInWish = BF::GenerateList(ShopFn::GetWishProducts(), '<div class="mini-product clearfix"><img src="?"/><span>?</span><button class="delete-from-cart delete-product-from-wish" data-id="?"><i class="fa fa-times"></i></button></div>', ["ProductImagesPreview", "ProductName", "ID_product"]);

    $productsInWish = <<<EOF
    <strong>Мои желания</strong>
    <hr />
    {$productsInWish}
    <hr />
    <a href="/user/wish" class="go-to">Мои желания</a>
EOF;
}

if(BF::IfUserInSystem() == false)
{
    $buttotUserInfo = <<<EOF
    <strong>Вход в личный кабинет</strong>
    <span class="header-login">Логин</span>
    <input class="login-input" type="email" name="email">
    <span class="header-login">Пароль</span>
    <input class="password-input" type="password" name="password">
    <a href="" class="forgot">Забыли пароль?</a>
    <button class="btn-login">Войти</button>
    <span class="header-span">Нет учетной записи?</span>
    <a href="/register/">Регистрация</a>
    <hr />
    <strong>Вход через соц сети</strong>
    <script src="//ulogin.ru/js/ulogin.js"></script>
    <div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name;providers=vkontakte,facebook,google,odnoklassniki;hidden=;redirect_uri=http%3A%2F%2Fstore.sweane%2Fauth%2F;mobilebuttons=0;"></div>
EOF;
}
else if(BF::ReturnInfoUser(BF::permissionUser) == 777)
{
    $activeUserButton = "active";

    $buttotUserInfo = <<<EOF
    <ul>
        <li><a href="/dashboard/">Статистика</a></li>
        <li><a href="/dashboard/orders">Заказы</a></li>
        <li><a href="/dashboard/products">Товары</a></li>
        <li><a href="/dashboard/category">Категории товара</a></li>
        <li><a href="/dashboard/characteristics">Характеристики товара</a></li>
        <li><a href="/dashboard/news">Новости</a></li>
        <li><a href="/dashboard/news">Контакты</a></li>
    </ul>
    <button class="quit-user">Выйти</button>
EOF;
}
else {
    $activeUserButton = "active";

    $buttotUserInfo = <<<EOF
    <ul>
        <li><a href="/user/information">Моя информация</a></li>
        <li><a href="/user/orders">Мои заказы</a></li>
        <li><a href="/user/wish">Мои желания</a></li>
    </ul>
    <button class="quit-user">Выйти</button>
EOF;
}

foreach (DataBase::GetRootCategory() as $item)
{
    $categoriesLi .= <<<EOF
<li class="level0 nav-2 level-top parent dropdown">
    <a href="/category/{$item["Categories_id"]}" class="">{$item["Categories_name" . USER_LANG]}</a>
</li>
EOF;
}

//$categoriesLi .= <<<EOF
//<li class="level1 nav-1-2 col-1">
//    <a href="defile-pe18.html" class=" ">Bras</a>
//</li>
//
//<li class="level1 nav-1-3 col-1">
//    <a href="lookbook-defile-pe18-921.html" class=" ">Pans</a>
//
//</li>
//
//<li class="level1 nav-1-4 col-1">
//    <a href="campagne-ah17.html" class=" ">Sets</a>
//
//</li>
//EOF;

$menuUser = <<<EOF
<li><a href="/sign-up/">{$language->Translate('signup')}</a></li>
<li><a href="/user/wish" title="{$language->Translate('my_wishlist')}" class="not-empty">{$language->Translate('my_wishlist')}</a></li>
<li class="sep"></li>
<li><a href="/login/">{$language->Translate('log_in')}</a></li>
EOF;

$countInCart = ShopFn::GetCountInCart();

if(BF::IfUserInSystem())
{
    $name = BF::ReturnInfoUser(BF::nameUser);

    $menuUser = <<<EOF
<li>$name</li>
<li><a href="/user/orders" title="My Orders" class="not-empty">{$language->Translate('my_orders')}</a></li>
<li><a href="/user/wish" title="My Wishlist" class="not-empty">{$language->Translate('my_wishlist')}</a></li>
<li class="sep"></li>
<li><a class="quit-user">{$language->Translate('logout')}</a></li>
EOF;
}
$headerLogo = <<<EOF
    <a class="brand">
        <img src="/App/Views/Include/logo.png" alt="">
    </a>
EOF;

if($_SERVER["REQUEST_URI"] != "/")
{
    $headerLogo = <<<EOF
    <a class="brand" href="/">
        <img src="/App/Views/Include/logo.png" alt="">
    </a>
EOF;
}

$lang = "";

if(BF::ReturnInfoUser(BF::permissionUser) == 777) {
    $lang = <<<EOF
<!--<li class="level0 nav-2 level-top parent dropdown">-->
    <!--<a class="">|</a>-->
<!--</li>-->
<!--<li class="level0 nav-2 level-top parent dropdown">-->
    <!--<a href="/setlang/ru" class="">RU</a>-->
<!--</li>-->
<!--<li class="level0 nav-2 level-top parent dropdown">-->
    <!--<a href="/setlang/en" class="">EN</a>-->
<!--</li>-->
<li class="level0 nav-2 level-top parent dropdown">
    <a class="">|</a>
</li>
<li class="level0 nav-2 level-top parent dropdown">
    <a href="/setcurrency/ua" class="">UAH</a>
</li>
<li class="level0 nav-2 level-top parent dropdown">
    <a href="/setcurrency/ru" class="">RUB</a>
</li>
<li class="level0 nav-2 level-top parent dropdown">
    <a href="/setcurrency/en" class="">DOLLAR</a>
</li>
EOF;
//
//    echo "Country: " . strtolower(BF::IpInfo("Visitor", "countrycode")) . ", ";
//    echo "Currency Code: " . $_SESSION['currency_code'] . ", ";
//    echo "Currency Code DB: " . $_SESSION['currency_code_db'] . ", ";
//    echo "Currency: " . $_SESSION['currency'];
}

$Header = <<<EOF
<header class="header navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <div class="wrapper-header">
            
                <div class="header-links-left">
                    <div class="top-left-menu">
                        <a href="tel:+380503363655">+380503363655</a>
                        <button class="order-call-button">{$language->Translate('order_call')}</button>
                    </div>
                </div>
                
                <div class="menu-hamburger">
                    <a class="btn-navigation-new">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </div>

                <h1>
                    {$headerLogo}
                </h1>

                <ul class="nav">
                    <li class="nav-map"><a rel="nofollow" href="/content/about-us" title="About Us" class="top-link-map" data-toggle=".redirect-form">{$language->Translate('about_us')}</a></li>

                    <li class="nav-customer dropdown">
                        <a class="dropdown-toggle top-link-account" id="customericon" href="/user/"><span class="indented">{$language->Translate('my_account')}</span><span class="ico"></span></a>
                        <div class="customer-summary dropdown-menu">
                            <div class="wrapper">    <div class="logged-out" id="top_account_summary">
                                <div>
                                    <ul>
                                        {$menuUser}
                                    </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                    </li>
                    <li class="hidden-desktop cart-link">
                        <a class="mobile-cart-btn" data-position="right" data-toggle="pageslide" data-scroller="cart-summary-scroller" data-target=".cart-summary"></a>
                        <div class="cart-summary">
                            <div class="wrapper"></div>
                        </div>
                    </li>
                    <li class="nav-cart">
                        <a href="/cart/" data-gua-event-action="My Cart" data-gua-event-category="Navigation" id="top_link_cart" class="top-link-cart">
                            {$language->Translate('cart')} (<span class="product-count">{$countInCart}</span>)
                        </a>
                        <div class="cart-summary" style="display: none;">
                            <div class="loader" style="display: none;"></div>
                            <div class="wrapper">
                                <div class="cart-summary-container">
                                    {$cartHtml}
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-search"><a rel="nofollow" href="#" title="Search" class="top-link-search" id="searchicon"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                </ul>
            </div>

            <div class="nav-slide pageslide">
                <div class="wrapper">
                    <!--<div class="menu-mobile-search">-->
                        <!--<form class="navbar-form pull-left">-->
                            <!--<div class="input-append">-->
                                <!--<input id="search" class="input-medium" type="text" data-suggest="true" placeholder="Search" name="q" value="" maxlength="128">-->
                                <!--<button type="submit" title="Ok" class="btn-search-mini">OK</button>-->
                            <!--</div>-->
                            <!--<a href="#" class="close">Close</a>-->
                        <!--</form>-->
                    <!--</div>-->
                    <div class="mobile-menu-container">
                        <nav>
                            <ul id="anchor_header" class="nav-items nav" data-nav="container">


                                <!--<li class="level0 nav-1 first level-top parent dropdown">
                                    <a href="/individual-order/" class="dropdown-toggle level-top" data-toggle="dropdown">
                                       INTRO COLLECTION	           		</a>
                                    <ul class="level0 dropdown-menu unstyled">
                                        {$categoriesLi}
                                    </ul>
                                </li>-->
                                {$categoriesLi}
                                {$lang}
                                <!--<li class="level0 nav-2 level-top parent dropdown">-->
                                    <!--<a href="/individual-order/" class="dropdown-toggle level-top">Individual order</a>-->
                                <!--</li>-->
                            </ul>
                        </nav>
                    </div>
                    <!--<div class="menu-mobile-links">-->
                        <!--<div class="menu-mobile-links">-->
                            <!--<ul class="nav">-->
                                <!--<li class="nav-mobile-maison"><a rel="nofollow" href="la-maison/index.html" title="La Maison" class="top-link-maison">La Maison</a></li>-->
                                <!--<li class="nav-mobile-stores"><a rel="nofollow" href="ozcms/stores/locator/index.html" title="Stores" class="top-link-stores" id="storeicon">Stores</a></li>-->
                                <!--<li class="nav-mobile-map">-->
                                    <!--<div class="country-switcher">-->
                                        <!--<a href="redirect/index/index/index.html" data-toggle=".redirect-form" class="redirect-country-switch redirect-country top-link-map" data-redirect-country-code="US">United States</a>-->
                                    <!--</div>-->
                                <!--</li>-->
                                <!--<li class="nav-mobile-signin"><a rel="nofollow" href="customer/account/login/index.html" title="Sign in" class="top-link-signin">Sign in</a></li>-->
                                <!--<li class="nav-mobile-signup"><a rel="nofollow" href="customer/account/create/index.html" title="Sign up" class="top-link-signup">Sign up</a></li>-->
                                <!--<li class="nav-mobile-wishlist"><a rel="nofollow" href="wishlist/index.html" title="My Wishlist" class="top-link-wishlist">My Wishlist</a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                     <!--</div>-->
                </div>
            </div>
            <div class="search-desktop">
                <form name="search_mini" action="/search/s" class="navbar-form pull-left" method="get">
                    <div class="input-append">
                        <input id="search" class="input-medium" type="text" data-suggest="true" placeholder="{$language->Translate('search')}" name="q" value="" maxlength="128">
                        <button type="button" title="Ok" class="btn-search-mini">OK</button>
                    </div>
                    <div class="close-search"><i class="fa fa-times" aria-hidden="true"></i></div>
                </form>
            </div>
        </div>
    </div>
</header>
<div class="size-guide-modal order-call-modal mini">
    <button class="close-size-guide"><i class="fa fa-times"></i></button>
    <strong>{$language->Translate('order_call')}</strong>
    <!--<input type="text" class="design-input" placeholder="">-->
    <div class="input ind-input ind-waist" style="display: block;">
        <label class="label required">{$language->Translate('phone')}<em>*</em></label>
        <input type="text" placeholder="{$language->Translate('phone')}" maxlength="255" class="check-invalid-data required only-num order-call-phone">
        <span class="help-inline input-message"></span>
    </div>
    <div class="input ind-input ind-waist" style="display: block;">
        <label class="label required">{$language->Translate('name')}<em>*</em></label>
        <input type="text" placeholder="{$language->Translate('name')}" maxlength="255" class="check-invalid-data required order-call-name">
        <span class="help-inline input-message"></span>
    </div>
    <button class="send-order-call">{$language->Translate('send')}</button>
</div>
EOF;

$HeaderOld = <<<EOF
<div class="container-fluid menu-inline">
    <div class="row">
        <div class="col-md-7">
            <div class="menu-top">
                <a href="/delivery/">Доставка и оплата</a>
                <a href="/aboutus/">О нас</a>
                <a href="/contacts/">Контакты</a>
                <a href="/faq/">FAQ</a>
                <a class="blue" href="http://champ.in.ua/">Рекламное агентство</a>
            </div>
        </div>
        <div class="col-md-5 ta-r">
            <!--<div class="dropdown">
            <button class="btn btn-default" type="button" data-toggle="dropdown" aria-expanded="true">
            <span class="text">UAH</span></button>
            <ul class="dropdown-menu dropdown-menu-right shadow-none change-currency">
                <li><a data-id="1">UAH</a></li>
                <li><a data-id="2">RUB</a></li>
                <li><a data-id="3">USD</a></li>
            </ul>
            </div>-->
            <button class="callback-phone clear-button"><i class="fa fa-phone" aria-hidden="true"></i> Обратный звонок</button>
        </div>
    </div>
</div>

<div class="container-fluid header-info">
    <div class="row">
        <div class="col-md-12">
            <!--<a href="/"><img src="/Images/Home/logo.svg" /></a>-->
            <a href="/"><img src="/Images/Icons/new-logo-none-02.svg" /></a>
            <div class="mini-bars">
                <button><i class="fa fa-bars" aria-hidden="true"></i></button>
                {$menu}
            </div>
            <div class="search-top">
                <form action="/search/" method="get">
                    <input type="text" class="search-top-input" name="query" data-placeholder="Что будем искать?">
                    <button class="search-top-btn clear-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="top-phones">
                {$contacts}
            </div>
            <div class="buttons-parent">
                <span class="top-div-balance" data-toggle="tooltip" data-placement="bottom" title="Сравнение">
                    <button class="top-button clear-button"><span class="count {$classBalance}">{$countBalance}</span><i class="fa fa-balance-scale" aria-hidden="true"></i></button>
                    <div class="drop-down-top balance {$classBalance}">
                        {$productsInBalance}
                    </div>
                </span>
                <span class="top-div-wish" data-toggle="tooltip" data-placement="bottom" title="Мои желания">
                    <button class="top-button clear-button"><span class="count {$classWish}">{$countWish}</span><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                    <div class="drop-down-top wish {$classWish}">
                        {$productsInWish}
                    </div>
                </span>
                <span class="top-div-cart" data-toggle="tooltip" data-placement="bottom" title="Корзина">
                    <button class="top-button clear-button"><span class="count {$classCart}">{$countInCart}</span><i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
                    <div class="drop-down-top cart {$classCart}">                    
                        {$productsInCart}
                    </div>
                </span>
                <button data-toggle="tooltip" data-placement="left" title="Мой профиль" class="top-button clear-button login-show {$activeUserButton}"><i class="fa fa-user-o" aria-hidden="true"></i></button>
                <div class="drop-user ta-c">
                    {$buttotUserInfo}
                </div>
            </div>
        </div>
    </div>
</div>
<button class="go-top-button"><i class="fa fa-arrow-up"></i></button>
EOF;

print($Header);
