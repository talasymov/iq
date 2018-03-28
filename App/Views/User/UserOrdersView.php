<?php
IncludesFn::printHeader("Orders", "customer grey");

$listOrders = '';
$i = 0;

$language = new Languages;

foreach ($data as $key => $value)
{
    $listOrders .= '<tr><td>' . $value["OrdersGroup_date"] . '</td>
<td>' . $value["OrdersGroup_id"] . '</td>
<td>' . BF::ReturnInfoUser(BF::nameUser) . '</td>
<td>' . $value["OrdersStatus_name"] . '</td>
<td>' . $value["OrdersGroup_comment_payment"] . '</td>
<td>$' . number_format($value["OrdersGroup_sum"], 2, ",", "") . '</td>
<td><a href="/user/orders/' . $value["OrdersGroup_id"] . '" class="link-under">'.$language->Translate('view_detail').'</a></td></tr>';

    $i++;
}

$bodyText = <<<EOF
<div class="messages">           
</div>
<div class="page-header-iq clear ta-l mobile-top">
    <h1>{$language->Translate('orders')}</h1>
</div>
    
<div class="area-box">
    <table class="table order-table">
        <thead>
            <tr>
                <th>{$language->Translate('order_date')}</th>
                <th>{$language->Translate('order_order_num')}</th>
                <th>{$language->Translate('order_user')}</th>
                <th><span class="nobr">{$language->Translate('order_status')}</span></th>
                <th><span class="nobr">{$language->Translate('order_payment')}</span></th>
                <th><span class="nobr">{$language->Translate('order_total')}</span></th>
            </tr>
        </thead>
        <tbody>
            {$listOrders}
        </tbody>
    </table>
</div>
EOF;


$bodyTextOld = <<<EOF
<h2 class="ta-l strong">Мои заказы</h2><br />
 <table class="table">
    <thead>
        <tr class="strong"><th>Номер заказа</th><th>Название заказа</th><th>Сумма</th><th>Дата добавления</th><th>Статус</th><th></th></tr>
    </thead>
    <tbody>
        {$listOrders}
    </tbody>
 </table>
EOF;
