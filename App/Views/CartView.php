<?php
IncludesFn::printHeader("Cart", "checkout-cart-index grey");

$language = new Languages;

if($data != false && is_array($data))
{
    $listProduct = '';
    $listIdCart = ShopFn::GetIdFromCart();

    $i = 0;

    foreach ($data as $key => $value)
    {
        $propHtml = "";

        $wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
            $value["ID_product"]
        ]);

        $propParent = $listIdCart[$value["ID_product"]]["property"];

        if($propParent)
        {
            foreach ($propParent as $itemProp)
            {
                $propArray = explode(",", $itemProp);

                $propNameParent = R::getRow("SELECT * FROM PropertiesParent WHERE PropertiesGroup_id = ?", [
                    $propArray[0]
                ]);

                $propNameChild = R::getRow("SELECT * FROM Properties WHERE PropertiesValues_id = ?", [
                    $propArray[1]
                ]);

//                $propHtml .= <<<EOF
//<dt>{$propNameParent["PropertiesGroup_name"]} :</dt>
//<dd>{$propNameChild["PropertiesValues_name"]}</dd>
//EOF;

                $nameGroup = $propNameParent["PropertiesGroup_name" . USER_LANG];

                if($value["ProductCategory"] == 59 && $propNameParent["PropertiesGroup_id"] == 2)
                {
                    $nameGroup = "Bra size";
                }
                else if($value["ProductCategory"] == 59 && $propNameParent["PropertiesGroup_id"] == 3)
                {
                    $nameGroup = "Pants size";
                }

                $propHtml .= <<<EOF
{$nameGroup}: {$propNameChild["PropertiesValues_name" . USER_LANG]}<br />
EOF;

            }
        }

//        $price = "$" . number_format($value["ProductPrice"] * $listIdCart[$value["ID_product"]]["count"], 2, ".", ",");

        $price = $_SESSION['currency_symbol_left'] . number_format($value["ProductPrice"] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

        $clearPrice = $value["ProductPrice"];

        $wholesaleHtml = "";

        foreach ($wholesale as $subValue)
        {
            if($listIdCart[$value["ID_product"]]["count"] >= $subValue["Wholesale_count"])
            {
                $price = $subValue["Wholesale_price"];
            }
        }

        $propText = '';

        if(is_array($listIdCart[$value["ID_product"]]["property"]))
        {
            foreach ($listIdCart[$value["ID_product"]]["property"] as $subValue)
            {
                $prop = R::getRow("SELECT * FROM PropertiesValues
                INNER JOIN Properties ON Properties.PropertiesValues_id = PropertiesValues.Properties_id_value
                INNER JOIN PropertiesParent ON PropertiesParent.PropertiesGroup_id = Properties.PropertiesValues_category
                WHERE Properties_id = ? AND Properties_product = ?", [
                    $subValue,
                    $value["ID_product"]
                ]);

                $nameGroup = $prop["PropertiesGroup_name" . USER_LANG];

                if($value["ProductCategory"] == 59 && $prop["PropertiesGroup_id"] == 2)
                {
                    $nameGroup = "Bra size";
                }
                else if($value["ProductCategory"] == 59 && $prop["PropertiesGroup_id"] == 3)
                {
                    $nameGroup = "Pants size";
                }

                $propText .= '<strong class="strong">' . $nameGroup . ':</strong> ' . $prop["PropertiesValues_name" . USER_LANG] . '<br />';
            }
        }

//        $listProduct .= '<tr>
//            <td class="zoom-click ta-c"><img class="mini-img" src="' . $value["ProductImagesPreview"] . '" /></td>
//            <td>' . $value["ProductName"] . '</td>
//            <td>' . $propText . '</td>
//            <td><input type="number" data-id="' . $value["ID_product"] . '" class="cart-one-change design-input" min="1" max="9999" value="' . $listIdCart[$value["ID_product"]]["count"] . '" /></td>
//            <td>' . $price . ' грн</td>
//            <td class="ta-c"><button class="delete-product-in-cart btn btn-default circle" data-id="' . $value["ID_product"] . '" data-toggle="tooltip" data-placement="left" title="Убрать из корзины"><i class="fa fa-times" aria-hidden="true"></i></button></td>
//        </tr>';



        $listProduct .= <<<EOF
<div class="item clearfix">
	<div class="item-image">
		<img src="{$value["ProductImagesPreview"]}" width="120" height="165" alt="{$value["ProductName" . USER_LANG]}">
    </div>
<div class="container-infos">
    <div class="item-infos">
        <h2 class="product-name">
			<a href="/product/{$value["ID_product"]}">{$value["ProductName" . USER_LANG]}</a>
		</h2>
        <!--<dl class="item-options dl-horizontal">-->
            {$propHtml}
        <!--</dl>-->
    </div>
	<div class="item-qty">
        <label>{$language->Translate('quantity')}</label>
        <input class="input-small count-ch" min="1" type="number" value="{$listIdCart[$value["ID_product"]]["count"]}" data-id="{$value["ID_product"]}" data-price="{$clearPrice}" />
        <!--<select class="item-qty-select input-small" data-count="{$listIdCart[$value["ID_product"]]["count"]}" data-id="{$value["ID_product"]}" data-price="{$clearPrice}">
            <option selected="selected" value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>-->
    </div>
    <div class="item-remove">
        <a title="Remove item" class="btn-remove delete-product-in-cart btn-remove2" data-id="{$value["ID_product"]}">{$language->Translate('remove_item')} x</a>
    </div>
    <div class="item-price desc-hide">
        <span class="cart-price"><span class="price">{$price}</span></span>
	</div>
    </div>
    <div class="item-price mob-hide">
        <span class="cart-price"><span class="price">{$price}</span></span>
	</div>
</div>    	
EOF;


        $i++;
    }

    $inCart = ShopFn::DrawProduct(ShopFn::GetProductsInCart(), 3, 4, "list");

//    $sumCart = "$" . number_format(ShopFn::GetCartSum(), 2, ".", ",");
    $sumCart = $_SESSION['currency_symbol_left'] . number_format(ShopFn::GetCartSum() * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];


    $bodyText = <<<EOF
<div class="wrap">
					    
		    <div class="container col1-layout margin-top-min-10"> 
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						

<div class="cart">
	<div class="cart-main">
        <div class="page-header-iq">
            <h1 class="bold-h1">{$language->Translate('my_cart')}</h1>
        </div>

        <div class="messages">           
  </div>                  <form name="" action="/checkout/" method="post" id="form_update">
    		<div id="shopping-cart">
                {$listProduct}  		    		</div>         
        </form> 
        
            
        <div class="cart-additionnal">
    
                            <form name="" id="discount-coupon-form" action="/checkout/" method="post" class="discount">
                
        				
						
	            <div class="discount-input clearfix ">
	                <div class="input-append">
	                    <label class="control-label" for="coupon_code">{$language->Translate('enter_coupon')}</label>
	                    <input type="text" class="input-medium" id="coupon_code" name="coupon_code" value="">
	
	                    	                        <button type="button" title="OK" class="btn btn-secondary" value="OK">
	                            OK	                        </button>
	                    	                </div>
	            </div>
            
                </form>
            
             
             
	<div class="giftmessage">
																		</div>
             
           
<div class="total-container">
<div class="total-inc row">
    <div class="total-label">
        {$language->Translate('grand_total_incl_taz')}    
    </div>
    <div class="total-price">
       <span class="price">{$sumCart}</span>    
    </div>
</div>
<a href="/checkout/" class="btn btn-checkout btn-express btn-primary">
		{$language->Translate('proceed_checkout')}	</a>
	</div>
	
</div> 

           </div>
           
           
          
        	    
        </div>

	</div>
    
</div>    
    
<div class="cart-collaterals">
	</div>

						<div class="visible-phone">
													</div>
					</div>
				</div>
			</div>
			
			
		</div>


<div class="hide-empty">
<div class="container col1-layout margin-top-min-10">
        <div class="main">
                                <div class="col-main">
                <div class="messages">           
</div>  						

<div class="cart" style="opacity: 1;"><div class="page-header-iq">
<h1>{$language->Translate('cart_is_empty')}</h1>
</div><div class="cart-empty">
<div class="messages">           
</div>  	    	    <p>{$language->Translate('cart_empty')}</p>
{$language->Translate('click_continue_shopping')}
    </div></div>    

<div class="cart-collaterals">
</div>

                <div class="visible-phone">
                                            </div>
            </div>
        </div>
    </div>
</div>
EOF;

    $bodyTextOld = <<<EOF
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product">
                    <h2 class="ta-c">Корзина</h2>
                     <table class="table">
                        <thead class="strong">
                            <tr><th width="100">Изображение</th><th width="200">Название товара</th><th>Свойства</th><th width="140">Количество</th><th width="140">Стоимость</th><th width="100" class="ta-c">Управление</th></tr>
                        </thead>
                        <tbody>
                            {$listProduct}
                        </tbody>
                    </table>
                    <div class="center">
                        <hr />
                        <button class="btn btn-default circle save-cart-change" data-toggle="tooltip" title="Сохранить изменения"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        <button class="btn btn-default circle clear-cart" data-toggle="tooltip" title="Очистить корзину"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <a href="/checkout/"><button class="btn btn-default circle" data-toggle="tooltip" title="Оформление заказа"><i class="fa fa-check" aria-hidden="true"></i></button></a>
                        <button class="btn btn-default circle buy-in-click" data-toggle="tooltip" title="Купить в один клик"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-design-bg">
        <div class="modal-design">
            <button class="delete-from-cart close-btn close-modal-design"><i class="fa fa-times"></i></button>
            <h2 class="ta-c">Купить в один клик</h2>
            <br />
            <br />
            <div class="scroll-div meScroll-mini">
                <div class="container-fluid">
                    {$inCart}
                </div>
            </div>
            <h2 class="ta-c">Информация о Вас:</h2>
            <div class="ta-c margin-bottom bold-input"><br />
                <input class="design-input one-click-name" data-placeholder="Имя" />
                <input class="design-input one-click-phone" data-placeholder="Телефон" />
                <input class="design-input one-click-city" data-placeholder="Город" /><br /><br />
                <a href="/cart/"><button class="btn btn-default circle big" data-toggle="tooltip" title="Редактировать корзину"><i class="fa fa-shopping-basket"></i></button></a>
                <button class="btn btn-default circle big buyinclick" data-toggle="tooltip" title="Купить"><i class="fa fa-check"></i></button>
                <button class="btn btn-default circle big close-modal-design" data-toggle="tooltip" title="Продолжить покупки"><i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
EOF;

$script = <<<EOF
<script>
$(document).ready(function(){
    $(".item-qty-select").each(function(i, e) {
      $(e).val($(e).attr("data-count"));
    });
});
</script>
EOF;
}
else
{
    $bodyText = <<<EOF
<!--<div class="clear-cart-bg">-->
    <!--<span>В корзине пусто <i class="fa fa-frown-o" aria-hidden="true"></i></span>-->
    <!--<i class="fa fa-shopping-basket"></i>-->
<!--</div>-->
<div class="wrap">
                
    <div class="container col1-layout margin-top-min-10">
        <div class="main">
                                <div class="col-main">
                <div class="messages">           
</div>  						

<div class="cart" style="opacity: 1;"><div class="page-header-iq">
<h1>{$language->Translate('cart_is_empty')}</h1> 
</div><div class="cart-empty">
<div class="messages">           
</div>  	    	    <p>{$language->Translate('cart_empty')}</p>
{$language->Translate('click_continue_shopping')}
    </div></div>    

<div class="cart-collaterals">
</div>

                <div class="visible-phone">
                                            </div>
            </div>
        </div>
    </div>
    
    
</div>
EOF;
}
