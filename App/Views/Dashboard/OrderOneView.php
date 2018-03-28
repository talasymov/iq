<?php
$pageName = "Заказ № " . $data["group"]["OrdersGroup_id"];

Dashboard::printHeader($pageName, "grey");

//$orders = ShopFn::DrawProduct(, 3, 4);

$status = AuxiliaryFn::ArrayToSelect(R::getAll("SELECT * FROM OrdersStatus"), "select-status design-input", "OrdersStatus_id", "OrdersStatus_name", "Выберите статус", $data["group"]["OrdersGroup_status"]);

$payment = R::getRow("SELECT PaymentTypeName FROM PaymentType WHERE ID_paymentType = ?", [
    $data["group"]["OrdersGroup_payment"]
]);

//$delivery = R::getRow("SELECT * FROM Address WHERE ID_address = ?", [
//    $data["group"]["OrdersGroup_delivery"]
//]);

$deliveryInfo = ShopFn::ReturnDeliveryInfo($data["group"]["OrdersGroup_delivery"]);

$delivery = R::getRow("SELECT *, cities.name AS CityName, countries.name AS CountryName, states.name AS StateName FROM Address

INNER JOIN countries ON countries.id = Address.Country
INNER JOIN cities ON cities.id = Address.City
INNER JOIN states ON states.id = Address.Region

WHERE ID_address = ?", [
    $data["group"]["OrdersGroup_address"]
]);

$deliveryMoney = "$" . number_format($deliveryInfo["money"], 2, ".", ",");
$sum = "$" . number_format($deliveryInfo["money"] + $data["group"]["OrdersGroup_sum"], 2, ".", ",");

//AuxiliaryFn::StylePrint($data);

$comment = html_entity_decode($data["group"]["OrdersGroup_comment"]);

$listProduct = '';
//$listIdCart = ShopFn::GetIdFromCart();
$tr = "";

$i = 0;

foreach ($data["products"] as $key => $value)
{
    $propHtml = "";

    $wholesale = R::getAll("SELECT * FROM Wholesale WHERE Wholesale_product = ?", [
        $value["ID_product"]
    ]);

    $propParent = $listIdCart[$value["ID_product"]]["property"];

    $array = str_replace("[", "", $value["Orders_prop"]);
    $array = str_replace("]", "", $array);
    $array = explode("\",\"", $array);

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

    $price = "$" . number_format($value["ProductPrice"] * $value["Orders_count"], 2, ".", ",");
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

            $nameGroup = $prop["PropertiesGroup_name"];

            if($value["ProductCategory"] == 59 && $prop["PropertiesGroup_id"] == 2)
            {
                $nameGroup = "Bra size";
            }
            else if($value["ProductCategory"] == 59 && $prop["PropertiesGroup_id"] == 3)
            {
                $nameGroup = "Pants size";
            }

            $propText .= '<strong class="strong">' . $nameGroup . ':</strong> ' . $prop["PropertiesValues_name"] . '<br />';
        }
    }

    $listProduct .= <<<EOF
<div class="item clearfix">
	<div class="item-image">
		<img src="{$value["ProductImagesPreview"]}" width="120" height="165" alt="{$value["ProductName"]}">
    </div>
<div class="container-infos">
    <div class="item-infos">
        <h2 class="product-name">
			<a href="/product/{$value["ID_product"]}">{$value["ProductName"]}</a>
		</h2>
        <!--<dl class="item-options dl-horizontal">-->
            {$propHtml}
        <!--</dl>-->
    </div>
	<div class="item-qty">
        <label>Quantity</label>
        {$value["Orders_count"]}
    </div>
    <div class="item-price desc-hide">
        <span class="cart-price"><span class="price">{$price}</span></span>
	</div>
    </div>
</div>    	
EOF;

    $tr .= <<<EOF
<tr>
    <td><a href="/product/{$value["ID_product"]}"><img width="80" src="{$value["ProductImagesPreview"]}" alt=""></a></td>
    <td><a href="/product/{$value["ID_product"]}">{$value["ProductName"]}</a></td>
    <td>{$value["Orders_count"]}</td>
    <td>{$propHtml}</td>
    <td>{$value["ProductPrice"]} $</td>
</tr>
EOF;

    $i++;
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <a href="/dashboard/orders"><button class="btn btn-default circle" data-toggle="tooltip" data-placement="bottom" data-original-title="Вернуться назад"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
                <a href="/dashboard/clients/{$data["group"]["Users_id"]}"><button class="btn btn-default circle" data-toggle="tooltip" data-placement="bottom" data-original-title="Профиль пользователя"><i class="fa fa-user" aria-hidden="true"></i></button></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>Информация о заказе</h1>
                <button class="btn btn-default save-one-order circle" data-id="{$data["group"]["OrdersGroup_id"]}" data-toggle="tooltip" data-placement="left" data-original-title="Сохранить изменения"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <tbody>
                    <tr><th class="strong" width="200">Номер заказа</th><td>{$data["group"]["OrdersGroup_id"]}</td></tr>
                    <tr><th class="strong">Название заказа</th><td>{$data["group"]["OrdersGroup_name"]}</td></tr>
                    <tr><th class="strong">Сумма</th><td>{$sum} (Доставка: {$deliveryMoney})</td></tr>
                    <tr><th class="strong">Доставка</th><td>{$delivery["CityIndex"]}, {$delivery["CountryName"]}, {$delivery["StateName"]}, {$delivery["CityName"]}, {$delivery["Street"]}</td></tr>
                    <!--<tr><th class="strong">Способ оплаты</th><td>{$payment["PaymentTypeName"]}</td></tr>-->
                    <tr><th class="strong">Дата добавления</th><td>{$data["group"]["OrdersGroup_date"]}</td></tr>
                    <tr><th class="strong">Комментарий</th><td>{$comment}</td></tr>
                    <tr><th class="strong">Статус</th><td>{$status}</td></tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Count</th>
                        <th>Prop</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>{$tr}</tbody>
            </table>
        </div>
    </div>
</div>
EOF;
