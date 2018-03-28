<?php
IncludesFn::printHeader("В один клик", "grey");

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
        <span class="header-blue">Название заказа</span> <input class="in-one-click-name design-input" value="1" />
        <span class="header-blue">Куда доставляем?</span> <input class="in-one-click-country design-input" data-placeholder="Страна"/><br />
        <input class="in-one-click-region design-input" data-placeholder="Регион"/><br />
        <input class="in-one-click-city design-input" data-placeholder="Город"/><br />
        <input class="in-one-click-street design-input" data-placeholder="Улица"/><br />
        <input class="in-one-click-build design-input" data-placeholder="Номер дома"/><br />
        <input class="in-one-click-porch design-input" data-placeholder="Подъезд"/><br />
        <input class="in-one-click-apartment design-input" data-placeholder="Квартира"/><br />
        <span class="header-blue">Способ оплаты</span> {$selectPayment}
        <span class="header-blue">Комментарий</span> <textarea class="checkout-comment design-textarea"></textarea>
EOF;

        $buttonsCheckOut = '<button class="btn btn-success checkout-confirm">Купить в один клик</button>';
    }
    else
    {
        $buttons = 'Извините, но для оформления заказа <a href="#" class="login-show">Войдите</a> или <a href="/register/">Зарегистрируйтесь</a>!';
    }
}

$bodyText = <<<EOF
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-md-offset-1">
                <div class="product big-padding">
                    <h2 class="ta-c">В один клик</h2>
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
