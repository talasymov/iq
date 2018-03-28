<?php
IncludesFn::printHeader("Individual Order");

$language = new Languages;

$getCategory = intval($data["arguments"]["cat"]);
$getId = intval($data["arguments"]["id"]);

if($getCategory > 0)
{
    $categories = AuxiliaryFn::ArrayToSelect(DataBase::GetRootCategory(), "ind-order-cat required", "Categories_id", "Categories_name" . USER_LANG, $language->Translate('select_category'), $getCategory);

    $products = R::getAll("SELECT * FROM Products WHERE ProductCategory = ?", [
        $getCategory
    ]);

    if($getId > 0)
    {
        $productsArray = AuxiliaryFn::ArrayToSelect($products, "check-invalid-data ind-order-prod required", "ID_product", "ProductName" . USER_LANG, $language->Translate('before_select_lingerie'), $getId);
    }
    else
    {
        $productsArray = AuxiliaryFn::ArrayToSelect($products, "check-invalid-data ind-order-prod required", "ID_product", "ProductName" . USER_LANG, $language->Translate('before_select_lingerie'));
    }

}
else
{
    $categories = AuxiliaryFn::ArrayToSelect(DataBase::GetRootCategory(), "check-invalid-data ind-order-cat required", "Categories_id", "Categories_name" . USER_LANG, $language->Translate('select_category'));

    $productsArray = <<<EOF
<select id="shipping" class="check-invalid-data ind-order-prod required" title="Country">
    <option value="0" selected="selected">{$language->Translate('before_select_lingerie')}</option>
</select>
EOF;
}

$page = R::getRow("SELECT * FROM News WHERE news_id = 8");

$content = html_entity_decode($page["news_content"]);

$bodyText = <<<EOF
<div class="page-header-iq">
    <h1>{$language->Translate('individual_order')}</h1>
</div>
<div id="ind-order" class="clearfix">
    <div class="video">
        {$content}
    </div>
    <div class="form-order">
        <div class="input input-half">
            <label class="label" for="shipping">{$language->Translate('name_of_lingerie')}</label>
            {$categories}
        </div>
        <br />
        <div class="input">
            <label class="label" for="shipping">{$language->Translate('name_of_set')}</label>
            {$productsArray}
        </div>
        <br />
        <div class="input ind-input ind-waist">
            <label class="label required">{$language->Translate('waist')}, cm<em>*</em></label>
            <input type="text" placeholder="{$language->Translate('waist')}" maxlength="255" class="check-invalid-data required only-num">
            <span class="help-inline input-message"></span>
        </div>
        <div class="input ind-input ind-hip">
            <label class="label required">{$language->Translate('hip')}, cm<em>*</em></label>
            <input type="text" placeholder="{$language->Translate('hip')}" maxlength="255" class="check-invalid-data required only-num">
            <span class="help-inline input-message"></span>
        </div>
        <div class="input ind-input ind-bust">
            <label class="label required">{$language->Translate('bust')}, cm<em>*</em></label>
            <input type="text" placeholder="{$language->Translate('bust')}" maxlength="255" class="check-invalid-data required only-num">
            <span class="help-inline input-message"></span>
        </div>
        <div class="input ind-input ind-under-bust">
            <label class="label required">{$language->Translate('under_bust')}, cm<em>*</em></label>
            <input type="text" placeholder="{$language->Translate('under_bust')}" maxlength="255" class="check-invalid-data required only-num">
            <span class="help-inline input-message"></span>
        </div>
        <div class="cart">
            <a class="btn btn-ind-checkout btn-checkout btn-express btn-primary">{$language->Translate('proceed_checkout')}</a>
        </div>
    </div>
</div>
EOF;

$script = <<<EOF
<script>
$(document).ready(function(){
id = {$getCategory};

if(id == 9)
{
    $(".ind-bust").show();
    $(".ind-under-bust").show();
}
else if(id == 58)
{
    $(".ind-waist").show();
    $(".ind-hip").show();
}
else if(id != 0)
{
    $(".ind-bust").show();
    $(".ind-under-bust").show();
    $(".ind-waist").show();
    $(".ind-hip").show();
}
});
</script>
EOF;
