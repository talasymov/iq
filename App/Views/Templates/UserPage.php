<?php
require_once (DIR_INCLUDE . "Header.php");

$idUser = BF::ReturnInfoUser(BF::idUser);
$nameUser = BF::ReturnInfoUser(BF::nameUser);

$language = new Languages;

$page = <<<EOF
<div class="wrap" style="margin-top: -39px;">
					    
		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						
<div class="nav-customer-area nav-customer-mobile hidden-desktop">
    <div class="page-header-iq clear">
        <h1><strong>{$language->Translate('welcome')} {$nameUser}</strong></h1>
    </div>
    <ul class="nav-tabs nav-customer">
        <li class=""><a href="/user/">{$language->Translate('my_account')}</a></li>
        <li class=""><a href="/user/information">{$language->Translate('my_informations')}</a></li>
        <li><a href="/user/orders">{$language->Translate('my_orders')}</a></li>
        <li class=""><a href="/user/wish">{$language->Translate('my_wishlist')}</a></li>
        <li class="logout quit-user" style="margin-top: 10px;"><a class="btn btn-primary">{$language->Translate('logout')}</a></li>
    </ul>
</div>


<!--<div class="nav-customer-area visible-desktop">-->
    <!--<div class="page-header">-->
        <!--<h1>Welcome Lizw</h1>-->
        <!--<a href="https://www.soniarykiel.com/en_us/customer/account/logout/" class="close-link">To Log Out</a>-->
    <!--</div>-->
    <!--<ul class="nav-tabs nav-customer">-->
        <!--<li class=""><a href="https://www.soniarykiel.com/en_us/customer/account/">Account</a></li>-->
        <!--<li class=""><a href="https://www.soniarykiel.com/en_us/customer/account/edit/">Informations</a></li>-->
        <!--<li class=""><a href="https://www.soniarykiel.com/en_us/customer/address/">Address Book</a></li>-->
        <!--<li class="active"><a href="https://www.soniarykiel.com/en_us/sales/order/history/">Orders</a></li>-->
        <!--<li class=""><a href="https://www.soniarykiel.com/en_us/wishlist/">Wishlist</a></li>-->
        <!--<li class=" last"><a href="https://www.soniarykiel.com/en_us/newsletter/manage/">Newsletter</a></li>-->
    <!--</ul>-->
<!--</div>-->
<div class="my-account">
{$bodyText}
</div>
EOF;


$pageOld = <<<EOF
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="menu-top information-page click-menu">
                <div class="menu-home">
                    <strong><i class="fa fa-bars" aria-hidden="true"></i> Профиль № {$idUser}</strong>
                    <ul>
                        <li><a href="/user/">Главная</a></li>
                        <li><a href="/user/orders">Мои заказы</a></li>
                        <li><a href="/user/wish">Мои желания</a></li>
                        <li><a href="/user/reviews">Мои отзывы</a></li>
                        <li><a href="/user/information">Информация</a></li>
                        <li><a href="/user/partner">Партнерская программа</a></li>
                    </ul>
                    <div class="center"><button class="quit-user btn btn-info">Выйти из магазина <i class="fa fa-sign-out" aria-hidden="true"></i></button></div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="product">
                {$bodyText}
            </div>
        </div>
    </div>
</div>
EOF;

print($page);

require_once (DIR_INCLUDE . "Footer.php");

print($script);
