<?php
IncludesFn::printHeader("Orders", "customer grey");

$orders = R::getAll("SELECT * FROM Orders

INNER JOIN Products ON Products.ID_product = Orders.Orders_id_product

WHERE Orders_id_group = ?", [
    $data["OrdersGroup_id"]
]);

$propHtml = "";

$sum = 0;

foreach ($data as $item)
{
    $array = str_replace("[", "", $item["Orders_prop"]);
    $array = str_replace("]", "", $array);
    $array = explode("\",\"", $array);

    if($item["ProductCount"]) $count = $item["ProductCount"];
    else $count = 1;

    $sum += $item["ProductPrice"] * $count;

    if($array)
    {
        foreach ($array as $itemProp)
        {
            $propArray = explode(",", $itemProp);

            $propNameParent = R::getRow("SELECT * FROM PropertiesParent WHERE PropertiesGroup_id = ?", [
                intval(str_replace("\"", "", $propArray[0]))
            ]);

            $propNameChild = R::getRow("SELECT * FROM Properties WHERE PropertiesValues_id = ?", [
                intval(str_replace("\"", "", $propArray[1]))
            ]);

            if($propNameParent["PropertiesGroup_name"] != "")
            {
                $nameGroup = $propNameParent["PropertiesGroup_name"];

                if($item["ProductCategory"] == 59 && $propNameParent["PropertiesGroup_id"] == 2)
                {
                    $nameGroup = "Bra size";
                }
                else if($item["ProductCategory"] == 59 && $propNameParent["PropertiesGroup_id"] == 3)
                {
                    $nameGroup = "Pants size";
                }

                $propHtml .= <<<EOF
<strong>{$nameGroup}:</strong> {$propNameChild["PropertiesValues_name"]}<br />
EOF;
            }
        }
    }

    $priceProduct = "$" . number_format($item["ProductPrice"] * $count, 2, ".", ",");

    $tr .= <<<EOF
<tr>
    <td><a href="/product/{$item["ID_product"]}"><img width="80" src="{$item["ProductImagesPreview"]}" alt=""> {$item["ProductName"]}</a></td>
    <td>{$propHtml}</td>
    <td>{$priceProduct}</td>
</tr>
EOF;

}

$group = R::getRow("SELECT * FROM OrdersGroup

INNER JOIN OrdersStatus ON OrdersStatus.OrdersStatus_id = OrdersGroup_status

WHERE OrdersGroup_id = ?", [
    $data[0]["Orders_id_group"]
]);

$delivery = ShopFn::ReturnDeliveryInfo($group["OrdersGroup_delivery"]);

$allSum = "$" . number_format($delivery["money"] + $sum, 2, ".", ",");

$sum = "$" . number_format($sum, 2, ".", ",");
$sumDelivery = "$" . number_format($delivery["money"], 2, ".", ",");

$language = new Languages;

$date = date_create($group["OrdersGroup_date"]);
$date = date_format($date,"F d, Y");

$bodyText = <<<EOF
<div class="page-header-iq clear ta-l mobile-top">
    <h1>{$language->Translate('order_information')}</h1>
</div>

<div class="area-box">
    <p class="date">{$language->Translate('order_date')}: {$date}</p>
    <p class="number">{$language->Translate('order_order_num')}: {$data[0]["Orders_id_group"]}</p>
    <p class="status">{$language->Translate('order_status')}: {$group["OrdersStatus_name"]}</p>
    <p class="status">{$language->Translate('order_payment')}: {$group["OrdersGroup_comment_payment"]}</p>
    <!--<p class="payment">Payment Method: CC</p>-->
    <!--<div class="shipping-method">Shipping method: DHL Express - DHL Express</div>-->
</div>
<br />
<table class="table order-table">
<thead>
    <tr>
        <th>{$language->Translate('order_description')}</th>
        <th>{$language->Translate('order_size_color')}</th>
        <th>{$language->Translate('order_total')}</th>
    </tr>
</thead>
<tbody>
    {$tr}
</tbody>
</table>

<ul class="totals-list">
<!--<li class="subtotal clearfix">
    <div colspan="4" class="a-right">Subtotal</div>
    <div class="last a-right">
        <span class="price">{$sum}</span>
    </div>
</li>
<!--<li class="shipping clearfix">-->
    <!--<div colspan="4" class="a-right">Shipping &amp; Handling</div>-->
    <!--<div class="last a-right">-->
        <!--<span class="price">$0.00</span>-->
    <!--</div>-->
<!--</li>-->
<li class="grand_total clearfix">
    <div colspan="4" class="a-right">
        <strong>{$language->Translate('order_total_excl')}</strong>
    </div>
    <div class="last a-right">
        <strong><span class="price">{$sum}</span></strong>
    </div>
</li>
<li class="clearfix">
    <div colspan="4" class="a-right">
        {$language->Translate('order_tax')}
    </div>
    <div class="last a-right">
        <span class="price">{$sumDelivery}</span>
    </div>
</li>
<li class="grand_total_incl clearfix">
    <div colspan="4" class="a-right">
        <strong>{$language->Translate('order_total_incl')}</strong>
    </div>
    <div class="last a-right">
        <strong><span class="price">{$allSum}</span></strong>
    </div>
</li>
<li class="clearfix ta-c">
    <a href="/user/orders" class="link-under">{$language->Translate('order_back_my')}</a>
</li>
</ul>
EOF;


$bodyTextOld = <<<EOF
<h2 class="ta-l strong">В заказ входит:</h2><br />
<div class="container-fluid">
    <div class="row">
        {$orders}
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="/user/orders"><button class="btn btn-info">Вернуться назад</button></a>
        </div>
    </div>
</div>
EOF;
