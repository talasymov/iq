<?php
$pageName = "Контакты";

IncludesFn::printHeader($pageName, "grey");

$li = '';

foreach ($data["users"] as $value)
{
    $li .= '<tr><td><a href="/dashboard/contacts/' . $value["Users_id"] . '">' . $value["Users_surname"] . ' ' . $value["Users_name"] . ' ' . $value["Users_patronymic"] . '</a></td><td>' . $value["Users_phone"] . '</td><td>' . $value["Users_email"] . '</td></tr>';
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>ФИО</th><th>Телефон</th><th>Почта</th></tr>
                </thead>
                <tbody>
                    {$li}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
