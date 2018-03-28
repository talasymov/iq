<?php
$pageName = "Клиенты";

Dashboard::printHeader($pageName, "grey");

$li = '';

foreach ($data["users"] as $value)
{
    $li .= '<tr><td>' . $value["Users_surname"] . ' ' . $value["Users_name"] . ' ' . $value["Users_patronymic"] . '</td><td>' . $value["Users_phone"] . '</td><td>' . $value["Users_email"] . '</td><td class="ta-c"><a href="/dashboard/clients/' . $value["Users_id"] . '"><button class=\'btn btn-default circle\'><i class="fa fa-eye" aria-hidden="true"></i></button></a></td></tr>';
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
            <table class="table">
                <thead class="strong">
                    <tr><th>ФИО</th><th>Телефон</th><th>Почта</th><th width="70" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$li}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ta-c">
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
