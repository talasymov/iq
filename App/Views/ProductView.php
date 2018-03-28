<?php
$rootCategory = BF::GenerateList(DataBase::GetRootCategory(), '<span>?</span>', ["Categories_name" . USER_LANG]);

$echoCharacteristics = "";

$language = new Languages;

foreach ($data["characteristics"] as $value)
{
    if($value["cOutput_Value"] == null)
    {
        $valueCharacteristic = $value["cValueValue"];
    }
    else
    {
        $valueCharacteristic = $value["cOutput_Value"];
    }

    $echoCharacteristics .= '<tr><td><strong class="strong">' . $value["cSchema_Name"] . ':</strong></td><td>' . $valueCharacteristic . '</td></tr>';
}

foreach ($data["characteristicsValue"] as $value)
{
    $valueCharacteristic = "";

    if($value["cOutput_Value"] != "")
    {
        $valueCharacteristic = $value["cOutput_Value"];

        $echoCharacteristics .= '<tr><td><strong class="strong">' . $value["cSchema_Name"] . ':</strong></td><td>' . $valueCharacteristic . '</td></tr>';
    }
}

$echoReviewsLast = BF::GenerateList($data["reviewsLast"], '<div class="one-comment"><strong>? ?</strong><span class="comment"><i class="fa fa-quote-left" aria-hidden="true"></i>?<i class="fa fa-quote-right" aria-hidden="true"></i></span><span class="date">?</span></div>', ["Users_name", "Users_surname", "ReviewText", "ReviewDate"]);
$echoReviews = BF::GenerateList($data["reviews"], '<div class="one-comment"><strong>? ?</strong><span class="comment"><i class="fa fa-quote-left" aria-hidden="true"></i>?<i class="fa fa-quote-right" aria-hidden="true"></i></span><span class="date">?</span></div>', ["Users_name", "Users_surname", "ReviewText", "ReviewDate"]);
$echoSimilarProduct = BF::GenerateList($data["similarProducts"], '<a href="/product/?"><div class="one"><img src="?" /><strong>?</strong><span class="money">? грн</span></div></a>', ["ID_product", "ProductImagesPreview", "ProductName", "ProductPrice", "ProductLastPrice"], 8, "class='popular-parent clearfix'");

$echoImages = "";
$echoImagesId = 2;

$imgExplode = explode(";", $data["product"]["ProductImages"]);

foreach ($imgExplode as $valueSub)
{
    if ($valueSub != null)
    {
        $imgWaterMark = BF::ReturnWaterMark($valueSub);

//        $echoImages .= '<div class="item zoom-click" data-id="' . $echoImagesId . '"><img src="' . $valueSub . '" /></div>';
        $echoImages .= <<<EOF
<li class="other_images desktop swiper-slide">
    <img data-lazyload="unveil" data-def_img="{$valueSub}" itemprop="image" title="Aran knit sweater with basque hemline - sonia rykiel 2"  src="{$imgWaterMark}" alt="Aran knit sweater with basque hemline - sonia rykiel 2">
</li>
EOF;
        $echoImagesId++;
    }
}

$currency = ShopFn::GetCurrency();

$seo = <<<EOF
<meta name="keywords" content="{$data["product"]["ProductSeoKeywords"]}" />
<meta name="description" content="{$data["product"]["ProductSeoDesc"]}" />
EOF;

//$breadCrumbs = BF::BreadCrumbsProduct($data["product"]["ID_product"]);

$wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
    $data["product"]["ID_product"]
]);

$wholesaleHtml = "";

foreach ($wholesale as $value)
{
    $wholesaleHtml .= '<span>от ' . $value["Wholesale_count"] . " - " . $value["Wholesale_price"] . " грн</span><br />";
}

if($wholesaleHtml)
{
    $wholesaleHtml = <<<EOF
<div class="wholesale-html">
    <strong>Оптовые цены:</strong>
    {$wholesaleHtml}
</div>
EOF;

}

$workCategory = $data["product"]["ProductCategory"];

$thisCategoryName = R::getRow("SELECT Categories_name FROM Categories WHERE Categories_id = ?", [
    $workCategory
]);

$res = ShopFn::PrintStyleRecurs(ShopFn::GetPath($workCategory, [
    $workCategory => [
        "name" => $thisCategoryName["Categories_name" . USER_LANG],
        "id" => $workCategory
    ]
]));

IncludesFn::printHeader($data["product"]["ProductName" . USER_LANG], " grey", $seo);

$balance = '';
$heartClass = '';
$lastPrice = '';
$heart = 'fa-heart-o';

if(array_key_exists ($data["product"]["ID_product"], ShopFn::GetIdFromCart()))
{
    $buttonCart = '<button class="added-to-cart" data-id="' . $data["product"]["ID_product"] . '"><i class="fa fa-check" aria-hidden="true"></i>В корзине</button>';
}
else
{
    if($data["product"]["ProductCount"] > 0)
    {
        $buttonCart = '<button class="add-to-cart" data-id="' . $data["product"]["ID_product"] . '"><i class="fa fa-shopping-basket" aria-hidden="true"></i>В корзину</button>';
    }
    else
    {
        $buttonCart = '<button class="none-to-cart" data-id="' . $value["ID_product"] . '"><i class="fa fa-shopping-basket" aria-hidden="true"></i>Нет в наличии</button>';
    }
}

$menu = IncludesFn::GenerateCategoryMenu();

if(in_array($data["product"]["ID_product"], ShopFn::GetIdFromBalance()))
{
    $balance = 'active';
}

ShopFn::AddViewed($data["product"]["ID_product"]);

if(ShopFn::SearchWish($data["product"]["ID_product"]))
{
    $heart = 'fa-heart';

    $heartClass = "active";
}

if($data["product"]["ProductLastPrice"] != 0)
{
    $lastPrice = '<span class="last-price">' . number_format($data["product"]["ProductLastPrice"] * $currency["value"], 0, '', ' ') . '</span>';
}

$listCategory = [];
/*
 * Выбор характеристик
 */
$prop = R::getAll("SELECT * FROM PropertiesValues

INNER JOIN Properties ON Properties.PropertiesValues_id = PropertiesValues.Properties_id_value

INNER JOIN PropertiesParent ON PropertiesParent.PropertiesGroup_id = Properties.PropertiesValues_category

WHERE Properties_product = ?", [
    $data["product"]["ID_product"]
]);

/*
 * Генерируем массив из ID разбитый по категориям (Цвет, Размер и тд)
 */

foreach ($prop as $value)
{
    $categoryId = $value["PropertiesGroup_id"];

    if(!in_array($categoryId, $listCategory))
    {
        $listCategory[] = $categoryId;
    }
}

/*
 * Генерируем массив разбитый по категориям
 */

$resultArray = [];

foreach ($listCategory as $value)
{
    foreach ($prop as $subKey => $subValue)
    {
        if($subValue["PropertiesGroup_id"] == $value)
        {
            $resultArray[$value][] = $prop[$subKey];
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
            if(is_array($listProductsInCart[$data["product"]["ID_product"]]["property"]))
            {
                if(in_array($item["Properties_id"], $listProductsInCart[$data["product"]["ID_product"]]["property"]))
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

        if($data["product"]["ProductCategory"] == 59 && $product[0]["PropertiesGroup_id"] == 2)
        {
            $nameGroup = $language->Translate('bra_size');
        }
        else if($data["product"]["ProductCategory"] == 59 && $product[0]["PropertiesGroup_id"] == 3)
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
        <ul class="selectboxit-options selectboxit-list" style="min-width: 208px;">
            {$text}
        </ul>
    </span>
    <input id="super_attribute[92]" type="hidden" value="12011" name="super_attribute[92]">
</div>
EOF;

    $iC++;

}

$price = number_format($data["product"]["ProductPrice"] * $currency["value"], 0, '', ' ');

$user = R::getRow("SELECT Users_id, Users_company_name, Users_image FROM Users WHERE Users_id = ?", [
    $data["product"]["ProductUser"]
]);

$priceProd = $_SESSION['currency_symbol_left'] . number_format($data["product"]["ProductPrice"] * $_SESSION['currency'], 2, ".", ",") . $_SESSION['currency_symbol_right'];

if($data["product"]["ProductOthers"] != "")
{
    //$others = explode(";", $data["product"]["ProductOthers"]);
    $others = str_replace(";", ",", $data["product"]["ProductOthers"]);
    $others = substr($others, 0, strlen($others) - 1);

    $othersData = R::getAll("SELECT * FROM Products WHERE ID_product IN (" . $others . ")");

    $recommendations = ShopFn::DrawProduct($othersData);

    $recommendationsHtml = <<<EOF
<div class="page-header category-header">
    <div class="wrap_title_cat">
        <h2 class="cat-title-classic">{$language->Translate('frequently')}</h2>
    </div>
</div>
<div class="thRecommendations " data-widgetid="product2">
    <main class="category-view-main">
    <div class="category-products row"><div>
    <ol class="products-list unstyled thumbnails" id="products-list" data-featured="1" data-featured-container=".category-products" data-featured-item-class="item" data-featured-last-row-item-class="no-left-margin" data-featured-fade-in="1" style="visibility: visible;">
        {$recommendations}
    </ol>
    </div>
    </div>
    </main>
</div>
EOF;

}

$description = html_entity_decode($data["product"]["ProductDescription" . USER_LANG]);

$imgPreviewMark = BF::ReturnWaterMark($data["product"]["ProductImagesPreview"]);

$bodyText = <<<EOF
<div class="wrap">

    <div class="container col1-layout">
        <div class="main">

            <div class="col-main catalog-product-view">
                <div class="messages">
                </div> 
                <div class="product-view view row" style="opacity: 1; display: block;">

        <span itemprop="category" class="hidden" content="Sweaters">
        Sweaters    </span>
                <!--<div class="span12 wrap-return-social">
                    <div class="wrap-inner-return-social">
                        <a class="back" href=""><span class="vector_sprite arrow">Sweaters</span></a>
                        <ul class="social_wrap">
                            <button class="btn_social">
                                <span class="vector_sprite plus">Share</span>
                            </button>
                            <div class="ico_social_wrap">
                                <ul>

                                    <ul class="products-social">
                                        <li><span class="facebook-share">
	<a rel="nofollow" class="button_facebook_share" data-fancybox-type="iframe" title="facebook" target="_blank">Facebook</a>
</span></li>
                                        <li>
	<span class="twitter-custom">
		<a rel="nofollow">Twitter</a>
	</span>
                                        </li>
                                    </ul>


                                    <li class="email-friend">
                                        <a rel="nofollow">Email to a Friend</a>
                                    </li>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>-->


                  
                <div class="row container-part">
                <div class="span5 container-left-part">

                    <div class="product_img_container desktop">
                        <div class="product-media">
                            <div class="swiper-container product-img-slider swiper-container-horizontal" data-product-image-slide="swiper" data-slides-per-view="1">
                            <a class="prev" href="#"><span></span></a>
                            <a class="next" href="#"><span></span></a>
                                <ul class="swiper-wrapper">
                                    <li class="desc_img desktop swiper-slide">
                                        <img data-lazyload="unveil" itemprop="image" title="Aran knit sweater with basque hemline - sonia rykiel 1" src="{$imgPreviewMark}" alt="Aran knit sweater with basque hemline - sonia rykiel 1">
                                    </li>
                                    {$echoImages}
                                </ul>
                            </div>
                        </div>
                    </div>        </div>
                <div class="span7 container-right-part">
                    <form class="right_part" action="#" id="product_addtocart_form">
                        <div class="hidden">
                            <input type="hidden" name="product" data-type="configurable" value="300881">
                        </div>
                        <div class="product-shop reset-b">
                            <div class="page-header"> 


                                <h1 itemprop="name">{$data["product"]["ProductName" . USER_LANG]}</h1>



                                <div class="simple price_300887 price">


                                    <div class="price-box" itemprop="offers" itemscope="" itemtype="http://data-vocabulary.org/Offer">
                                                                        <span itemprop="price" class="regular-price" id="product-price-300887">
                	                                            <span class="price">{$priceProd}</span>                                    </span>

                                    </div>


                                </div>




                                <div class="simple price_300885 price hidden">


                                    <div class="price-box" itemprop="offers" itemscope="" itemtype="http://data-vocabulary.org/Offer">
                                                                        <span itemprop="price" class="regular-price" id="product-price-300885">
                	                                            <span class="price">$960.00</span>                                    </span>

                                    </div>


                                </div>

                            </div>
                            <div class="fixed_product">
                                <div class="tab-content">
                                    <div class="tab-pane active fade in" id="tab0-view">
                                        <h2>Details</h2>
                                        <div itemprop="description" class="std">
                                            {$description}</div>
                                    </div>
                                </div>
                            </div>
                                <div class="messages_block">
                                    <div class="messages">
                                    </div>                          </div>
                                    
                                <div class="product-options" id="product-options-wrapper">
                                    <input id="product_id" type="hidden" value="300881" name="product_id">
                                    {$div}
                                    <div class="sizeguide-container">
                                        <div class="size-guide-bottom">
                                            <a class="link-under" data-fancybox-type="iframe">{$language->Translate('size_guide')}</a>
                                        </div>
                                        <div class="ind-order-bottom">
                                            <a class="link-under" href="/individual-order/args?cat={$data["product"]["ProductCategory"]}&id={$data["product"]["ID_product"]}" data-fancybox-type="iframe">{$language->Translate('individual_order')}</a>
                                        </div>
                                    </div>
                                    <a id="sizeguide_link" data-fancybox-type="iframe">
                                </a><p class="alert-stock link-stock-alert"><a id="sizeguide_link" data-fancybox-type="iframe">
                                </a><a class="btn-product-alert" href="#" data-gua-event-action="Interaction" data-gua-event-category="Product Page" data-gua-event-label="Stock Subscription" data-gtm-event-label="Stock Subscription" title="Unavailable size ?" style="display: none;">Unavailable size ?</a>
                                </p>
                                    <div class="simple additional_300887 additional">
                                    </div>
                                    <div class="simple additional_300885 additional hidden">
                                    </div>
                                </div><div class="product-options-bottom">
                                <div class="add-to-cart">
                                    <div class="simple qty_300887 qty">
                                        <input type="hidden" name="qty" value="0" title="Qty">
                                    </div>
                                    <div class="simple qty_300885 qty hidden">
                                        <input disabled="disabled" type="hidden" name="qty" value="0" title="Qty">
                                    </div>
                                    <button type="button" title="{$language->Translate('add_to_cart')}" data-id="{$data["product"]["ID_product"]}" class="btn btn-primary add-to-cart btn-cart">{$language->Translate('add_to_cart')}</button>
                                </div>
                                <div class="add-to-links">
                                    <a class="btn heart-button btn-wishlist" data-id="{$data["product"]["ID_product"]}">{$language->Translate('add_to_wishlist')}</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            {$recommendationsHtml}
                <div class="product-collateral row">
            </div>
                <input type="hidden" name="created_at" value="2017-10-15 22:37:44">						<div class="visible-phone">
            </div>
            </div>
        </div>
    </div>
    <div class="push hidden-phone"></div>
</div>
<input type="hidden" value="{$language->Translate('added_to_wishlist')}" id="hid-wish-added">
<div class="size-guide-modal">
<button class="close-size-guide"><i class="fa fa-times"></i></button>
<strong>{$language->Translate('size_guide')}</strong>
<table class="table">
<tbody>
<tr>
<td class="back-table" colspan="4">{$language->Translate('panties')}</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('size')}</td>
<td>XS</td>
<td>S</td>
<td>M</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('waist')}</td>
<td>60-62</td>
<td>68-70</td>
<td>73-75&nbsp;</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('hip')}</td>
<td>86-89</td>
<td>94-97</td>
<td>98-102</td>
</tr>
</tbody>
</table>
<table class="table">
<tbody>
<tr>
<td class="back-table" colspan="6">{$language->Translate('bra')}</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('size')}</td>
<td>70A</td>
<td>75A</td>
<td>75B</td>
<td>75C</td>
<td>80C</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('under_bust')}</td>
<td>68-72</td>
<td>&nbsp;73-77</td>
<td>&nbsp;73-77</td>
<td>&nbsp;73-77</td>
<td>&nbsp;78-82</td>
</tr>
<tr>
<td class="back-table">{$language->Translate('bust')}</td>
<td>80-82</td>
<td>&nbsp;80-82</td>
<td>&nbsp;83-85</td>
<td>&nbsp;89-91</td>
<td>&nbsp;89-91</td>
</tr>
</tbody>
</table>
<span class="color-red">* {$language->Translate('measurements_in_centimeters')}</span>
</div>
EOF;


$bodyTextOld = <<<EOF
<div class="bg-menu-black" style="display: none;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!--<div class="menu-top click-menu s-hide">
                <div class="menu-home  category">
                    <strong><i class="fa fa-bars" aria-hidden="true"></i> Каталог товара</strong>
                    {$menu}
                </div>
            </div>-->
            <br />
            <div class="product product-one-page">
                <div class="bread-crumb">                
                    {$res}
                    <i class="fa fa-chevron-right" aria-hidden="true"></i> <a href="" class="active">{$data["product"]["ProductName" . USER_LANG]}</a>
                </div>
                <h1>{$data["product"]["ProductName" . USER_LANG]}</h1>
                <strong class="code-product margin-bottom">Артикул товара: {$data["product"]["ID_product"]}</strong>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="poduct-p-image-preview zoom-click" data-id="1">
                                <img src="{$data["product"]["ProductImagesPreview"]}" />
                            </div>
                            <div class="product-list-images carouselHidden">
                                {$echoImages}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div><strong class="product-price">{$currency["left"]} {$price} {$currency["right"]} {$lastPrice}</strong>{$wholesaleHtml}</div>
                            <div class="rating">{$data["rating"]["icon"]} {$data["rating"]["value"]} ({$data["rating"]["count"]})</div>
                            {$div}                    
                            {$buttonCart}
                            <button class="heart-button top-button clear-button {$heartClass}" data-id="{$data["product"]["ID_product"]}"><i class="fa {$heart}" aria-hidden="true"></i></button>
                            <button class="balance-button clear-button {$balance}" data-id="{$data["product"]["ID_product"]}"><i class="fa fa-balance-scale" aria-hidden="true"></i></button><br />
                            <strong class="product-header">Краткие характеристики:</strong>
                            <table class="char-table">
                                {$echoCharacteristics}
                            </table>
                        </div>
                        <div class="col-md-4 border-left-review">
                            <div class="info-about-seller clearfix">
                                <b>Продавец:</b>
                                <img src="{$user["Users_image"]}">
                                <strong>{$user["Users_company_name"]}</strong>
                                <a href="">Профиль</a>
                            </div>
                            <strong class="product-header">Отзывы покупателей:</strong>
                            <div class="reviews-parent">
                                {$echoReviewsLast}
                            </div>
                            <span class="info">Чтобы оставить отзыв, необходимо приобрести товар!</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="poduct-p-description">
                                <div class="list-header-block">
                                    <strong class="head-strong active" data-class="description-product">Описание</strong>
                                    <strong class="head-strong" data-class="reviews-product">Отзывы ({$data["reviewsCount"]})</strong>
                                </div>
                                
                                <div class="description-product div-b vis">
                                    {$data["product"]["ProductDescription"]}
                                </div>
                                <div class="reviews-product reviews-parent div-b">
                                    {$echoReviews}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            {$echoSimilarProduct}
        </div>
    </div>
</div>
EOF;

$script = <<<EOF
<script>
$(document).ready(function(){
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.next',
        prevButton: '.prev',
        spaceBetween: 30,
        loop: true
    });
});
</script>
EOF;
