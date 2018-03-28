<?php
IncludesFn::printHeader("Checkout", "checkout-express-index grey");

if($data != false && is_array($data))
{
    $listIdCart = ShopFn::GetIdFromCart();
    $sum = number_format(ShopFn::GetCartSum(), 0, "", " ");
    $listProduct = '';
    $i = 0;

    foreach ($data as $key => $value)
    {
        $wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
            $value["ID_product"]
        ]);

        $price = $value["ProductPrice"];

        foreach ($wholesale as $subValue)
        {
            if($listIdCart[$value["ID_product"]]["count"] >= $subValue["Wholesale_count"])
            {
                $price = $subValue["Wholesale_price"];
            }
        }

        $price = $listIdCart[$value["ID_product"]]["count"] * $price;

        $listProduct .= "<div class='list-in-cart'>" . $listIdCart[$value["ID_product"]]["count"] . " x " . $value["ProductName"] . "<span class='price'><span class='strong'>" . number_format( $price, 0, "", " ") . '</span> грн</span></div>';

        $i++;
    }

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
}

$bodyText = <<<EOF
<div class="wrap">
					    		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						

<section class="header-logo">
    <header class="logo">
        <a class="brand" href="/"><img src="/App/Views/Include/logo.png"></a>
    </header>
</section>
		
<section class="progress" id="co_steps">
   <a href="/" class="progress-back">< Back</a>
    <ol class="progress-list">
        <li id="costep_login" class="active"><span class="progress-count">1</span><span>Login</span></li>
                	<li id="costep_shipping_method"><span class="progress-count">2</span><span>Shipping</span></li>
                <li id="costep_payment"><span class="progress-count">3</span><span>Payment</span></li>
    </ol>
</section>

	

<section class="step-login step" id="co_step_login">

	<h1>Login</h1>
	
	<ul class="nav-tabs">
		<li class=""><a href="#regular-customer" data-toggle="tab"><h2>Already registered</h2></a></li>
	    <li class="active"><a href="#first-purchase" data-toggle="tab"><h2>New customer</h2></a></li>
	</ul>
	         
	<ul class="tab-content">
		<li class="" id="regular-customer">
			
<form class="form" id="co-login-form" autocomplete="off" novalidate="novalidate">
	<input name="form_key" type="hidden" value="IUsgeTYYXVLgyfWu">
	<input type="hidden" name="form" value="login">

	<p class="input-require">* Required fields</p>
	<div class="input mail success">
		<label class="label required" for="login[username]">Email Address<em>*</em></label>
		<input type="text" name="login[username]" class="required login-input email email-input" placeholder="Email Address">
		<span class="help-inline input-message"></span>
	</div>

	<div class="input password success">
		<label class="label password-parent required" for="login[password]"><span class="text">Password</span><em>*</em></label>
		<input type="password" name="login[password]" class="required password-input" placeholder="Password">
		<span class="help-inline input-message"></span>
	</div>

	<div class="resetpasssword">
		<a class="forgout-pass">Forgotten password ? &gt;</a>
	</div>

	<!--<div class="alert-login alert"></div>-->

	<button type="button" class="button button-medium button-full btn-login-checkout" data-loading-text="Please Wait...">Next</button>
    <button type="button" class="btn btn-restore-pass btn-primary hidden">Restore Password</button>
    <div class="reset-password-info">Mail will be send! Check Your Email!</div>
</form>		</li>
		<li id="first-purchase" class="active">
			
<form class="form" id="co-guest-form" autocomplete="off" novalidate="novalidate">

    <input name="form_key" type="hidden" value="IUsgeTYYXVLgyfWu">
    <input type="hidden" name="form" value="register">

	<p class="input-require">* Required fields</p>
    	
<div class="customer-account-type">
      
</div>
	
    <!--<div class="input input-half">-->
        <!--<label for="prefix" class="label  required">Prefix<em>*</em></label>-->
        <!--<div class="controls">-->
                        	            	            	<!--<select name="prefix" id="prefix" class="check-invalid-data required">-->
            	<!---->
            		            		            		<!--<option value="Miss">Miss</option> -->
	            		            	            	 	            		            		<!--<option value="Mrs">Mrs.</option> -->
	            		            	            	 	            		            		<!--<option value="Mr">Mr.</option> -->
	            		            	            	 	            		            	            	             	 <!--</select>-->
                            <!--<span class="help-inline input-message"></span>-->
        <!--</div>-->
    <!--</div>-->
    <br />
    <div class="input">
        <label for="firstname" class="label required">First Name<em>*</em></label>
       	<input type="text" id="firstname" placeholder="First Name" name="firstname" value="" title="First Name" maxlength="255" class="required check-invalid-data">
	    <span class="help-inline input-message"></span>
    </div>
    

   <div class="input">
        <label for="lastname" class="label required">Last Name<em>*</em></label>
		<input type="text" id="lastname" placeholder="Last Name" name="lastname" value="" title="Last Name" maxlength="255" class="required check-invalid-data">
    	<span class="help-inline input-message"></span>
    </div>

	<div class="input">
		<label for="email" class="label required">Email Address<em>*</em><span class="label-info"> Will be used for order status update</span></label>
		<input type="text" class="required email check-invalid-data" name="email" id="email_address" placeholder="Email Address">
		<span class="help-inline input-message"></span>
	</div>
     <!-- Show if prof account-->
             <!-- END  -->
    
    <div class="control-group">
        <label for="telephone" class="control-label">Tel</label>
        <div class="controls">
            <input name="telephone" id="telephone" title="tel" value="" class="input-large check-invalid-data only-num" type="text" placeholder="tel">
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="input success">
    	<label class="label" for="password">Password<em>*</em></label>
    	<input type="password" name="password" id="password" class="required check-invalid-data" placeholder="Password">
    	<span class="help-inline input-message"></span>
    </div>


			<div class="input">
			    <label class="label" for="is_subscribed">
				<input type="checkbox" name="is_subscribed" title="Sign up to the newsletter" value="1" id="is_subscribed" checked> terms and conditions</label>
		    </div>
	    
    <!--<div class="alert-guest alert"></div>-->

	<button type="button" class="button button-medium button-full btn-register-checkout" data-loading-text="Please Wait..."><span class="register">Create an account and continue</span></button>
</form>
		</li>
	</ul>
                    </section>
                <div class="visible-phone"></div>
            </div>
        </div>
    </div>
</div>
<br />
<br />
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
