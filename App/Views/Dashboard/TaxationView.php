<?php
$pageName = "Налоги";

IncludesFn::printHeader($pageName, "grey");

$taxation = BF::GenerateList($data, "<tr><td>?</td><td>?</td><td>?</td><td class=\"ta-c\"><button class='btn btn-default circle'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button><button class='btn btn-default circle'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td></tr>", ["Taxation_name", "TaxationTypes_name", "Taxation_value"]);

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <button class="add-taxation btn btn-default circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Название налога</th><th>Тип налога</th><th>Значение</th><th width="140" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$taxation}
                </tbody>
            </table>
        </div>
    <div>
<div>
EOF;
