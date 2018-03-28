<?php
IncludesFn::printHeader("Home", "grey");

$parentDiv = "";

$countProducts = count(ShopFn::GetProductsFromWish());

$col = 3;

if($countProducts == 2)
{
    $col = 6;
}
else if($countProducts == 3)
{
    $col = 4;
}
else if($countProducts == 4)
{
    $col = 3;
}

$infoDiv = "";
$allDiv = "";

$echoCharacteristics = "";
$echoCharacteristicsInfo = "";

$category = 0;
$y = false;

$parentDivNew = "";
$productCategory = "";

foreach(ShopFn::GetIdFromBalance() as $value)
{


    $characteristic = R::getAll("SELECT * FROM CharacteristicsOutput
    INNER JOIN CharacteristicsSchema ON CharacteristicsSchema.ID_cSchema = CharacteristicsOutput.cOutput_id_Schema
    INNER JOIN CharacteristicsValue ON CharacteristicsValue.ID_cValue = CharacteristicsOutput.cOutput_id_Value
    WHERE CharacteristicsOutput.cOutput_id_Product = ? ORDER BY cOutput_id_SubCategory", [$value]);

//    AuxiliaryFn::StylePrint($characteristic);

    $productInfo = R::getRow("SELECT * FROM Products
    INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory
    WHERE ID_product = ?", [
        $value
    ]);

    $echoCharacteristicsText = BF::GenerateList($characteristic, '<div class="tr-div">?</div>', ["cValueValue"]);

    if($echoCharacteristicsInfo == "")
    {
        $echoCharacteristicsInfo = BF::GenerateList($characteristic, '<div class="tr-div">?</div>', ["cSchema_Name"]);
    }

    if($productCategory == "")
    {
        $productCategory = $productInfo["Categories_name"];
    }

//    AuxiliaryFn::StylePrint($productInfo["Categories_name"] . " " . $productInfo["ProductName"]);

//    AuxiliaryFn::StylePrint($productInfo);

    if($productInfo["ProductCategory"] == $category || $category == 0)
    {
        $y = true;

//        AuxiliaryFn::StylePrint("1_ " . $productCategory);

        $echoCharacteristics .= <<<EOF
<div class="balance-parent">
    <button class='delete-from-balance' data-id='{$value}'><i class="fa fa-times"></i></button>
    <div class="head-height">
        <a href="/product/{$value}">
            <img src='{$productInfo["ProductImagesPreview"]}'>
            <strong>{$productInfo["ProductName"]}</strong>
        </a>
        <span class="price-b">{$productInfo["ProductPrice"]} грн</span>
        <button class="add-to-cart" data-id="{$productInfo["ID_product"]}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
        <button class="heart-button top-button clear-button" data-id="{$productInfo["ID_product"]}"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
    </div>
    {$echoCharacteristicsText}
</div>
EOF;
    }
    else
    {

//        AuxiliaryFn::StylePrint("0_ " . $productCategory);

        if($echoCharacteristics != "")
        {
            $parentDivNew .= <<<EOF
    <div class="parent balance-p">
        <h3>{$productCategory}</h3>
        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
        {$echoCharacteristics}
    </div>
EOF;
            $echoCharacteristics = "";
        }

        $echoCharacteristicsInfo = BF::GenerateList($characteristic, '<div class="tr-div">?</div>', ["cSchema_Name"]);
        $productCategory = $productInfo["Categories_name"];

        $echoCharacteristics .= <<<EOF
<div class="balance-parent">
    <button class='delete-from-balance' data-id='{$value}'><i class="fa fa-times"></i></button>
    <div class="head-height">
        <a href="/product/{$value}">
            <img src='{$productInfo["ProductImagesPreview"]}'>
            <strong>{$productInfo["ProductName"]}</strong>
        </a>
        <span class="price-b">{$productInfo["ProductPrice"]} грн</span>
        <button class="add-to-cart" data-id="{$productInfo["ID_product"]}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
        <button class="heart-button top-button clear-button" data-id="{$productInfo["ID_product"]}"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
    </div>
    {$echoCharacteristicsText}
</div>
EOF;

        $parentDivNew .= <<<EOF
    <div class="parent balance-p">
        <h3>{$productCategory}</h3>
        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
        {$echoCharacteristics}
    </div>
EOF;

        $echoCharacteristics = "";
        $y = false;


    }

//    if($productInfo["ProductCategory"] != $category && $category != 0)
//    {
//        $y = true;
//
//        $parentDivNew .= <<<EOF
//    <div class="parent balance-p">
//        <h3>{$productInfo["Categories_name"]}</h3>
//        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
//        {$echoCharacteristics}
//    </div>
//EOF;
//
////        AuxiliaryFn::StylePrint("Pic");
////        AuxiliaryFn::StylePrint($category . " " . $productInfo["ProductCategory"] . " " . $productInfo["ProductName"]);
//
//        $echoCharacteristics = "";
//        $echoCharacteristicsInfo = "";
//    }

    $category = $productInfo["ProductCategory"];
//
//    $echoCharacteristics .= <<<EOF
//<div class="balance-parent">
//    <button class='delete-from-balance' data-id='{$value}'><i class="fa fa-times"></i></button>
//
//    <a href="/product/{$value}">
//        <img src='/Images/Products/{$productInfo["ProductImagesPreview"]}'>
//        <strong>{$productInfo["ProductName"]}</strong>
//    </a>
//
//    <span class="price-b">{$productInfo["ProductPrice"]} грн</span>
//    <button class="add-to-cart" data-id="{$productInfo["ID_product"]}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
//    <button class="heart-button top-button clear-button" data-id="{$productInfo["ID_product"]}"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
//    {$echoCharacteristicsText}
//</div>
//EOF;
//
////    AuxiliaryFn::StylePrint($echoCharacteristicsInfo);
//    if($echoCharacteristicsInfo == "")
//    {
////        AuxiliaryFn::StylePrint("asd");
//        $echoCharacteristicsInfo = BF::GenerateList($characteristic, '<div class="tr-div">?</div>', ["cSchema_Name"]);
//    }
//
//    if($y)
//    {
//
//        AuxiliaryFn::StylePrint("true");
////        AuxiliaryFn::StylePrint($category . " " . $productInfo["ProductCategory"] . " " . $productInfo["ProductName"]);
//
//        $parentDivNew .= <<<EOF
//    <div class="parent balance-p">
//        <h3>{$productInfo["Categories_name"]}</h3>
//        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
//        {$echoCharacteristics}
//    </div>
//EOF;
//
//        $y = false;
//    }
//    else
//    {
//        AuxiliaryFn::StylePrint("false");
//
//        $parentDivNewCode .= <<<EOF
//    <div class="parent balance-p">
//        <h3>{$productInfo["Categories_name"]}</h3>
//        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
//        {$echoCharacteristics}
//    </div>
//EOF;
//    }

}

//AuxiliaryFn::StylePrint($y);

if($y)
{
    AuxiliaryFn::StylePrint("as");

        $parentDivNew .= <<<EOF
    <div class="parent balance-p">
        <h3>{$productCategory}</h3>
        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
        {$echoCharacteristics}
    </div>
EOF;
}

//if($echoCharacteristics != null && $parentDivNew == "")
//{
//    $parentDivNew = <<<EOF
//    <div class="parent balance-p">
//        <h3>{$productInfo["Categories_name"]}</h3>
//        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
//        {$echoCharacteristics}
//    </div>
//EOF;
//}

$parentDiv = <<<EOF
    <div class="parent balance-p">
        <div class="balance-headers">{$echoCharacteristicsInfo}</div>
        {$echoCharacteristics}
    </div>
EOF;

$bodyText = <<<EOF
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Сравнение</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br />
            <!--{$parentDiv}-->
            <br />
           {$parentDivNew}
            <br />
            <p class="mini-p">* Характеристики и комплектация товара могут изменяться производителем без уведомления.</p>
            <p class="mini-p">* Обзор подготовлен на базе одной из моделей серии. Точные спецификации смотрите во вкладке "Характеристики".</p>
        </div>
    </div>
</div>
EOF;
