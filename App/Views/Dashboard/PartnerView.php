<?php
$pageName = "Партнеры";

IncludesFn::printHeader($pageName, "grey");

$partners = R::getAll("SELECT * FROM Partners
INNER JOIN Users ON Partners.Partners_user = Users.Users_id
ORDER BY Partners_status DESC, Partners_date DESC");

$array = [
    0 => [
        "value" => 0,
        "text" => "На рассмотрении"
    ],
    1 => [
        "value" => 1,
        "text" => "Подтвержден аккаунт"
    ],
    2 => [
        "value" => 2,
        "text" => "Бан"
    ],
    3 => [
        "value" => 3,
        "text" => "Приостановлен"
    ]
];

$partnersHtml = "";

foreach ($partners as $value)
{
    $select = AuxiliaryFn::ArrayToSelect($array, "design-input status-partner", "value", "text", "Статус",$value["Partners_status"]);

    $partnersHtml .= "<tr><td>" . $value["Partners_id"] . "</td><td>" . $value["Users_company_name"] . "</td><td>" . $value["Partners_date"] . "</td><td>" . $select . "<input type='hidden' value='" . $value["Partners_id"] . "'></td></tr>";
}

//$partnersHtml = BF::GenerateList($partners, "<tr><td>?</td><td>?</td><td>?</td></tr>", ["", "", ""]);

$file = Draw::SelectFile($user["Users_image"], "image");

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <button class="save-settings-shop btn btn-default circle"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr>
                        <th>#</th><th>Название компании</th><th>Дата добавления</th><th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    {$partnersHtml}
                </tbody>
            </table>
        </div>
    </div>
</div>
EOF;
