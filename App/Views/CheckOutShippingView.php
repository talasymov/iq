<?php
IncludesFn::printHeader("Shipping", "checkout-express-second grey");

$language = new Languages;

$constantData = R::getAll("SELECT * FROM ConstantData");

    $listIdCart = ShopFn::GetIdFromCart();

    $sumClear = number_format(ShopFn::GetCartSum(), 2, ".", "");
    $sumCurrencyLeft = $_SESSION['currency_symbol_left'];
    $sumCurrencyRight = $_SESSION['currency_symbol_right'];

//    $sum = "$" . number_format(ShopFn::GetCartSum(), 2, ".", ",");
//    $sum = $sumClear . "$";
    $sum = $_SESSION['currency_symbol_left'] . number_format($sumClear * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

//    $sumWithTax = "$" . number_format(ShopFn::GetCartSum() + 7.95, 2, ".", ",");
//    $sumWithTax = number_format((ShopFn::GetCartSum() + $constantData[2]["ConstantData_data"]), 2, ".", "") . "$";
    $sumWithTax = $_SESSION['currency_symbol_left'] . number_format((ShopFn::GetCartSum() + $constantData[2]["ConstantData_data" . USER_LANG]) * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

    $sumCurrency = number_format(ShopFn::GetCartSum() * $_SESSION['currency'], 2, ".", "");

    $listProduct = '';
    $i = 0;

//    foreach ($data as $key => $value)
//    {
//        $wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
//            $value["ID_product"]
//        ]);
//
//        $price = $value["ProductPrice"];
//
//        foreach ($wholesale as $subValue)
//        {
//            if($listIdCart[$value["ID_product"]]["count"] >= $subValue["Wholesale_count"])
//            {
//                $price = $subValue["Wholesale_price"];
//            }
//        }
//
//        $price = $listIdCart[$value["ID_product"]]["count"] * $price;
//
//        $listProduct .= "<div class='list-in-cart'>" . $listIdCart[$value["ID_product"]]["count"] . " x " . $value["ProductName"] . "<span class='price'><span class='strong'>" . number_format( $price, 0, "", " ") . '</span> грн</span></div>';
//
//        $i++;
//    }

    $buttons = "";
    $buttonsCheckOut = "";

    if(BF::IfUserInSystem() == true)
    {
        $selectDelivery = AuxiliaryFn::ArrayToSelect(ShopFn::GetListDelivery(), "design-input checkout-delivery", "ID_address", "Name", "Выберите");
        $selectPayment = AuxiliaryFn::ArrayToSelect(ShopFn::GetListPayment(), "design-input checkout-payment", "ID_paymentType", "PaymentTypeName", "Выберите");

        $buttons = <<<EOF
        <span class="header-blue">Название заказа</span> <input class="checkout-name design-input" value="1" />
        <span class="header-blue">Способ доставки</span> {$selectDelivery}
        <span class="header-blue">Способ оплаты</span> {$selectPayment}
        <span class="header-blue">Комментарий</span> <textarea class="checkout-comment design-textarea"></textarea>
EOF;

        $buttonsCheckOut = '<button class="btn btn-success checkout-confirm">Оформить заказ</button>';
    }
    else
    {
        $buttons = 'Извините, но для оформления заказа <a href="#" class="login-show">Войдите</a> или <a href="/register/">Зарегистрируйтесь</a>!';
    }

$countriesSql = R::getAll("SELECT * FROM countries");

//$countries = AuxiliaryFn::ArrayToSelect($countriesSql, "base-countries check-invalid-data required", "id", "name", "Select Countries", $getCategory);

$countriesList = "";
$stateList = "";
$cityList = "";

$thisCountry = BF::IpInfo("Visitor", "Country");
$thisState = BF::IpInfo("Visitor", "State");
$thisCity = BF::IpInfo("Visitor", "City");

//$thisCountry = "Ukraine";
//$thisState = "Odessa Oblast";
//$thisCity = "Odessa";

foreach ($countriesSql as $item) {
    if(strpos($thisCountry, $item["name"]) !== false)
    {
        $countriesList .= <<<EOF
<option value="{$item["id"]}" selected>{$item["name"]}</option>
EOF;

        $stateSql = R::getAll("SELECT * FROM states WHERE country_id = ?", [
            $item["id"]
        ]);
//        $stateSql = R::getAll("SELECT * FROM states WHERE name LIKE'%" . substr($thisState, 0, 4) . "%'");

//        if(count($stateSql) > 0)
//        {
            foreach ($stateSql as $stateItem)
            {
                if(strpos($thisState, substr($stateItem["name"], 0, 4)) !== false)
                {
                    $stateList .= <<<EOF
<option value="{$stateItem["id"]}" selected>{$stateItem["name"]}</option>
EOF;
                    $citySql = R::getAll("SELECT * FROM cities WHERE state_id = ?", [
                        $stateItem["id"]
                    ]);
//                    $citySql = R::getAll("SELECT * FROM cities WHERE name LIKE'%" . substr($thisCity, 0, 4) . "%'");

//                    if(count($citySql) > 0)
//                    {
                        foreach ($citySql as $stateCity)
                        {
                            if(strpos($thisState, $stateCity["name"]) !== false)
                            {
                                $cityList .= <<<EOF
<option value="{$stateCity["id"]}" selected>{$stateCity["name"]}</option>
EOF;
                            }
                            else
                            {
                                $cityList .= <<<EOF
<option value="{$stateCity["id"]}">{$stateCity["name"]}</option>
EOF;
                            }
                        }
//                    }
                }
                else
                {
                    $stateList .= <<<EOF
<option value="{$stateItem["id"]}">{$stateItem["name"]}</option>
EOF;
                }
            }
//        }
    }
    else
    {
        $countriesList .= <<<EOF
<option value="{$item["id"]}">{$item["name"]}</option>
EOF;
    }
}

//BF::IpInfo();

$userInfo = "";
$buttonCreate = '<button type="button" class="button button-medium button-full checkout-confirm" data-loading-text="Please Wait...">' . $language->Translate('complete_purchase') . '</button>';

if(!BF::IfUserInSystem())
{
    $buttonCreate = '<button type="button" class="button button-medium button-full checkout-confirm-all" data-loading-text="Please Wait...">' . $language->Translate('complete_purchase') . '</button>';

    $userInfo = <<<EOF
<div class="input inl-w5 p-r">
    <label for="firstname" class="label required">{$language->Translate('first_name')}<em>*</em></label>
    <input type="text" id="firstname" placeholder="{$language->Translate('first_name')}" name="firstname" value="" title="First Name" maxlength="255" class="required check-invalid-data">
</div>

<div class="input inl-w5 p-l">
    <label for="lastname" class="label required">{$language->Translate('last_name')}<em>*</em></label>
    <input type="text" id="lastname" placeholder="{$language->Translate('last_name')}" name="firstname" value="" title="Last Name" maxlength="255" class="required check-invalid-data">
</div>

<div class="input inl-w5 p-r">
    <label for="email" class="label required">{$language->Translate('email')}<em>*</em></label>
    <input type="text" id="email" placeholder="{$language->Translate('email')}" name="email" value="" title="E-mail" maxlength="255" class="required check-invalid-data">
</div>

<div class="input inl-w5 p-l">
    <label for="Password" class="label required">{$language->Translate('password')}<em>*</em></label>
    <input type="text" id="Password" placeholder="{$language->Translate('password')}" name="Password" value="" title="Password" maxlength="255" class="required check-invalid-data">
</div>

<div class="input">
    <label for="tel" class="label required">{$language->Translate('tel')}<em>*</em></label>
    <input type="text" id="tel" placeholder="{$language->Translate('tel')}" name="email" value="" title="Tel" maxlength="255" class="required check-invalid-data">
</div>
EOF;

}

//AuxiliaryFn::StylePrint($constantData);

//$zipCode = $constantData[2]["ConstantData_data"];
$zipCode = $_SESSION['currency_symbol_left'] . number_format($constantData[2]["ConstantData_data" . USER_LANG] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

$standartDelivery = $_SESSION['currency_symbol_left'] . number_format($constantData[2]["ConstantData_data" . USER_LANG] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];
$expressDelivery = $_SESSION['currency_symbol_left'] . number_format($constantData[3]["ConstantData_data" . USER_LANG] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

//$liqpay = new LiqPay('i94249257993', 'oGK7ySfbjQ4cjzSsLRFqTFrf5UozkmvZdNHGsd7t');
//
//$html = $liqpay->cnb_form(array(
//    'action'         => 'pay',
//    'amount'         => '1',
//    'currency'       => 'USD',
//    'description'    => 'description text',
//    'order_id'       => '1',
//    'version'        => '3',
//    'server_url'     => '/api/s?q=change-status-payment&id=2',
//    'result_url'     => '/dashboard/payment-success/s?id=2'
//));

$standartDeliveryCurrency = $constantData[2]["ConstantData_data" . USER_LANG] * $_SESSION['currency'];
$expressDeliveryCurrency = $constantData[3]["ConstantData_data" . USER_LANG] * $_SESSION['currency'];

$bodyText = <<<EOF
<table id="GeoResults"></table>
<div id="form-liq" style="display: none"></div>
<script>
    $.getJSON("http://ip-api.com/json/?callback=?", function(data) {
        var table_body = "";
        $.each(data, function(k, v) {
            table_body += "<tr><td>" + k + "</td><td><b>" + v + "</b></td></tr>";
        });
        $("#GeoResults").html(table_body);
    });
</script>
<div class="wrap">
					    		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						

<section class="header-logo">
    <header class="logo">
        <a class="brand" href="/"><img src="/App/Views/Include/logo.png" alt=""></a>
    </header>
</section>
	
		
<section class="progress" id="co_steps">
   <!--<a href="https://www.soniarykiel.com/en_us/checkout/cart/" class="progress-back">Back</a>-->
    <ol class="progress-list">
        <!--<li id="costep_login"><span class="progress-count">1</span><span>Login</span></li>-->
        <li id="costep_shipping_method" class="active"><span class="progress-count">1</span><span>{$language->Translate('shipping_info')}</span></li>
        <li id="costep_payment"><span class="progress-count">2</span><span>{$language->Translate('delivery_methods')}</span></li>
        <li id="costep_payment_3"><span class="progress-count">3</span><span>{$language->Translate('payment')}</span></li>
    </ol>
</section>

	<section class="step-shipping_method step" id="co_step_shipping_method">
  <article class="step-shipping-method">
       <h1>{$language->Translate('payment')}</h1>
		
        <form class="form col-left">
        	<input name="form_key" type="hidden" value="">
        	
        	{$userInfo}
   
			<div class="input inl-w5 p-r">
				<label class="label" for="shipping[country_id]">{$language->Translate('country')}<em>*</em></label>
				<select name="" class="base-countries check-invalid-data required" id="">
				    <option value="0">{$language->Translate('select_countries')}</option>
				    {$countriesList}
                </select> 
			</div> 
															
			<div class="input inl-w5 p-l">
				<label class="label" for="shipping[region_id]">{$language->Translate('state')}<em>*</em></label>
                <select class="base-state check-invalid-data required" title="States">
				    <option value="0" selected="selected">{$language->Translate('select_state')}</option>
				    {$stateList}
				</select>
            </div>
            
            <div class="input inl-w5 p-r">
				<label class="label" for="shipping[region_id]">{$language->Translate('city')}<em>*</em></label>
                <select class="base-city check-invalid-data required" title="City" data-count="-1">
				    <option value="0" selected="selected">{$language->Translate('select_city')}</option>
				    {$cityList}
				</select>
            </div>
            
            <div class="input inl-w5 p-l">
                <label for="firstname" class="label required">{$language->Translate('post_code')}<em>*</em></label>
                <input type="text" id="postcode" placeholder="{$language->Translate('post_code')}" name="firstname" value="" title="First Name" maxlength="255" class="required check-invalid-data only-num">
            </div>
            
            <div class="input">
                <label for="firstname" class="label required">{$language->Translate('address_delivery')}<em>*</em></label>
                <input type="text" id="address" placeholder="{$language->Translate('address_delivery')}" name="firstname" value="" title="First Name" maxlength="255" class="required check-invalid-data">
            </div>
	       	
            <div class="input input-half hidden">
				<label class="label" for="shipping[postcode]">{$language->Translate('zip_code')}</label>
				<input name="shipping[postcode]" type="text" value="12093" class="check-invalid-data only-num">
				<a href="#" id="shipping_postcode">OK</a>
	       	</div> 
	       	 
            <h2>{$language->Translate('select_your_method')}</h2>
            
            <div class="shipping-method-lists">
                <ul class="shipping-method-list">
                    <li>
                        <label class="label-radio" for="s_method_usual" data-sum-currency-clear="{$standartDeliveryCurrency}" data-sum="{$constantData[2]["ConstantData_data" . USER_LANG]}" data-sum-currency="{$standartDelivery}">
                            <input class="shipping-radio" name="shipping_method" type="radio" value="{$constantData[2]["ConstantData_data" . USER_LANG]}" checked id="s_method_usual" checked="checked">
                            <div class="shipping-method-info">
                                <span class="shipping-name">{$constantData[0]["ConstantData_name" . USER_LANG]}</span>
                                <span class="shipping-date">
                                    {$constantData[0]["ConstantData_data" . USER_LANG]}
                                </span>
                            </div>
                            <span class="shipping-price">{$standartDelivery}</span>
                        </label>
                    </li>
                    <li>
                        <label class="label-radio" for="s_method_fast" data-sum-currency-clear="{$expressDeliveryCurrency}" data-sum="{$constantData[3]["ConstantData_data" . USER_LANG]}" data-sum-currency="{$expressDelivery}">
                            <input class="shipping-radio" name="shipping_method" type="radio" value="{$constantData[3]["ConstantData_data" . USER_LANG]}" id="s_method_fast">
                            <div class="shipping-method-info">
                                <span class="shipping-name">{$constantData[1]["ConstantData_name" . USER_LANG]}</span>
                                <span class="shipping-date">
                                    {$constantData[1]["ConstantData_data" . USER_LANG]}
                                </span>
                            </div>
                            <span class="shipping-price">{$expressDelivery}</span>
                        </label>
                    </li>
                </ul>
            </div>
            
            <div class="input">
			    <label class="label" for="is_subscribed">
				<input type="checkbox" name="is_subscribed" title="Sign up to the newsletter" value="1" id="is_subscribed" checked> {$language->Translate('terms_conditions')}</label>
		    </div>
            
            <!--<h2>PAYMENT METHOD</h2>-->
            <!---->
            <!--<div class="shipping-method-lists">-->
                    <!--<ul class="shipping-method-list">-->
                        <!--<li>-->
                            <!--<label class="label-radio" data-sum="7.95">-->
                                <!--<input class="shipping-radio" name="shipping_method" type="radio" value="1" id="s_method_usual" checked="checked">-->
                                <!--<div class="shipping-method-info">-->
                                    <!--<span class="shipping-date">-->
                                        <!--<img src="/img/visa-mastercard.png" alt="" width="70">-->
                                    <!--</span>-->
                                <!--</div>-->
                            <!--</label>-->
                        <!--</li>-->
                    <!--</ul>-->
            <!--</div>-->
	
            
            <div class="alert-shipping-method alert" style="display: none;"></div>
           	
            <div class="container-button align-right">
            	{$buttonCreate}
            </div>

        </form>
        
        {$html}
        
        <div class="getPayment"></div>
        
        <!--Sidebar-->
        <aside class="sidebar col-right">
        	
<h2>{$language->Translate('your_order')}</h2>


<ul class="sidebar-list">
	
<div id="shopping-cart-totals">
	<div>
		<li>
	<span class="sidebar-name">
			{$language->Translate('subtotal')}	</span>
	<span class="sidebar-price">
		<input name="sidebar-subtotal-price" type="hidden" value="1810" class="sidebar-subtotal-price">
		<span class="price checkout-sum" data-sum="{$sumClear}" data-currency-sum="{$sumCurrency}" data-currency-left="{$sumCurrencyLeft}" data-currency-right="{$sumCurrencyRight}">{$sum}</span>
    </span>
</li>
	<li>
		<span class="sidebar-name">{$language->Translate('zip_code')}</span>
		<span class="sidebar-price" id="sidebar-shipping-price"><span class="free checkout-tax">{$zipCode}</span></span>
    </li>


		
<li>
	<span class="sidebar-name">{$language->Translate('shipping_incl_tax')}</span>
	<span class="sidebar-price" id="sidebar-total-price"><span class="price checkout-total">{$sumWithTax}</span></span>
</li>
	</div>
</div>	</ul>

        </aside>
    
    </article>
    </section>



	

						<div class="visible-phone">
													</div>
					</div>
				</div>
			</div>
			<div class="global-site-notice">
    <noscript>
        &lt;div class="noscript alert alert-error"&gt;
            &lt;div class="notice-inner"&gt;
                &lt;p&gt;
                    &lt;strong&gt;JavaScript seems to be disabled in your browser.&lt;/strong&gt;&lt;br /&gt;
                    You must have JavaScript enabled in your browser to utilize the functionality of this website.                &lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    </noscript>
</div>
			<div class="push hidden-phone"></div>
		</div>
EOF;

$bodyTextOld = <<<EOF
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            <div class="product big-padding">
                <h2 class="ta-c">Оформление заказа</h2>
                {$buttons}
            </div>
        </div>
        <div class="col-md-3">
            <div class="news-request product in-cart">
                <strong>Итого:</strong>
                {$listProduct}
                <strong>К оплате <b>{$sum}</b> грн</strong>
                {$buttonsCheckOut}
            </div>
        </div>
    </div>
</div>
EOF;

BF::IncludeScripts([
    "jquery/jquery-3.1.0.min",
    "owl/owl.carousel",
    "bootstrap-3.3.7/js/bootstrap",
    "core/bootbox.min",
    "core/ui-slider",
    "core/core"
]);
