<?php
$pageName = "Заказы";

Dashboard::printHeader($pageName, "grey");

//$listOrders = '';
//$i = 0;
//
foreach ($data["orders"] as $key => $value)
{
    $listOrders .= '<tr><td>' . $value["OrdersGroup_id"] . '</td><td>' . $value["OrdersGroup_name"] . '</td><td>$' . number_format($value["OrdersGroup_sum"], 2, '.', ',') . '</td><td>' . $value["OrdersGroup_date"] . '</td><td>' . $value["OrdersStatus_name"] . '</td><td class="ta-c"><a href="/dashboard/clients/' . $value["Users_id"] . '"><button class="btn btn-default circle"><i class="fa fa-address-book" aria-hidden="true"></i></button></a></td><td><a href="/dashboard/orders/' . $value["OrdersGroup_id"] . '"><button class="btn btn-default circle"><i class="fa fa-eye" aria-hidden="true"></i></button></a><button class="btn delete-order btn-default circle" data-id="'. $value["OrdersGroup_id"] . '"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <span style="height: 40px;display: inline-block"></span>
            </div>
        </div>
        <div class="col-md-12">
            <!--<div class="council-div"><i class="fa fa-info-circle" aria-hidden="true"></i>Будьте внимательны и вовремя
            закрывайте сделки!</div>-->
            <div class="shell-table">
                <table class="table">
                    <thead class="strong">
                        <tr><th>Номер заказа</th><th>Название заказа</th><th>Сумма</th><th>Дата добавления</th><th>Статус</th><th class="ta-c">Контакт</th><th></th></tr>
                    </thead>
                    <tbody>
                        {$listOrders}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 ta-c">
            {$data["link"]}
        </div>
    </div>
</div>
EOF;
