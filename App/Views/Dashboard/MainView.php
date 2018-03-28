<?php
Dashboard::printHeader("Dashboard", "grey");

//AuxiliaryFn::StylePrint(BF::GeneratePass("admin"));
//AuxiliaryFn::StylePrint(BF::GeneratePass("bgteuk"));

$ordersStatus = R::getAll("SELECT * FROM OrdersStatus");

$countStatus = '';

$popularProductsLi = '';

$moneyShop = 0;
$moneyAll = 0;

$moneyShopYear = 0;
$moneyAllYear = 0;

foreach ($ordersStatus as $value)
{
    $baseCount = R::getRow("SELECT COUNT(*) as Count FROM OrdersGroup WHERE OrdersGroup_status = ?", [
        $value["OrdersStatus_id"]]);

    $info["count"] = $baseCount["Count"];
    $info["statusName"] = $baseCount["OrdersStatus_name"];

    $countStatus .= '<tr><td>'.$value["OrdersStatus_name"].'</td><td>'.number_format($baseCount["Count"], 0, '', ' ').'</td></tr>';
//    $countStatus[$value["OrdersStatus_id"]] = $info;
}

$popularProducts = R::getAll("
  SELECT Orders_id_product, COUNT(*) as Total, ProductName
  FROM Orders
  INNER JOIN Products ON Products.ID_product = Orders.Orders_id_product
  GROUP BY Orders_id_product
  ORDER BY Total DESC
  LIMIT 5");

$moneyFromProductsMonth = R::getAll("
SELECT Orders_id_product, ProductPrice, ProductPrice-ProductPurchasePrice AS ShopMoney, OrdersGroup_date FROM Orders
INNER JOIN Products ON Products.ID_product = Orders.Orders_id_product
LEFT JOIN OrdersGroup ON OrdersGroup.OrdersGroup_id = Orders.Orders_id_group
WHERE MONTH(OrdersGroup_date) = MONTH(CURDATE())");

foreach ($moneyFromProductsMonth as $value)
{
    $moneyShop += $value["ShopMoney"];
    $moneyAll += $value["ProductPrice"];
}

$moneyFromProductsYear = R::getAll("
SELECT Orders_id_product, ProductPrice, ProductPrice-ProductPurchasePrice AS ShopMoney, OrdersGroup_date FROM Orders
INNER JOIN Products ON Products.ID_product = Orders.Orders_id_product
LEFT JOIN OrdersGroup ON OrdersGroup.OrdersGroup_id = Orders.Orders_id_group
WHERE YEAR(OrdersGroup_date) = YEAR(CURDATE())");

foreach ($moneyFromProductsYear as $value)
{
    $moneyShopYear += $value["ShopMoney"];
    $moneyAllYear += $value["ProductPrice"];
}

foreach ($popularProducts as $value)
{
    $popularProductsLi .= '<tr><td><a href="/product/'.$value["Orders_id_product"].'" target="_blank">'.$value["ProductName"].'</a></td><td>'.number_format($value["Total"], 0, '', ' ').'</td></tr>';
}

$moneyShop = number_format($moneyShop, 0, "", " ");
$moneyAll = number_format($moneyAll, 0, "", " ");
$moneyShopYear = number_format($moneyShopYear, 0, "", " ");
$moneyAllYear = number_format($moneyAllYear, 0, "", " ");

$pageName = "Статистика";

$bodyText = <<<EOF
<h2>Статистика на сегодня</h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">По статусам</h3>
                <table class="table">
                    <thead class="strong">
                        <tr><th>Статус</th><th>Кол-во заказов</th></tr>
                    </thead>
                    <tbody>                
                        {$countStatus}
                    </tbody>                
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">Рейтинг продаж</h3>
                <table class="table">
                    <thead class="strong">
                        <tr><th>Названеи товара</th><th>Кол-во сделок</th></tr>
                    </thead>
                    <tbody>                
                        {$popularProductsLi}
                    </tbody>                
                </table>
            </div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-md-12">
            <h2>Статистика за месяц</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">Прибыль</h3>
                <strong class="center strong big-price">{$moneyShop} грн</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">Оборот</h3>
                <strong class="center strong big-price">{$moneyAll} грн</strong>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Статистика за год</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">Прибыль</h3>
                <strong class="center strong big-price">{$moneyShopYear} грн</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product">
                <h3 class="ta-c">Оборот</h3>
                <strong class="center strong big-price">{$moneyAllYear} грн</strong>
            </div>
        </div>
    </div>-->
</div>
EOF;
