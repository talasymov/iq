<?php
$pageName = "Валюты";

IncludesFn::printHeader($pageName, "grey");

$currency = BF::GenerateList($data, "<tr><td><input class='design-input name-currency' value='?' /></td><td><input class='design-input code-currency' value='?' /></td><td><input class='design-input left-currency' value='?' /></td><td><input class='design-input right-currency' value='?' /></td><td><input class='design-input value-currency' value='?' /></td><td class=\"ta-c\"><button class='btn btn-default circle save-currency' data-id='?'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button><button class='btn btn-default circle' data-id='?'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td></tr>", ["Currency_name", "Currency_code", "Currency_symbol_left", "Currency_symbol_right", "Currency_value", "Currency_id", "Currency_id"]);

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
                    <tr><th>Название валюты</th><th>Код</th><th>Символ слева</th><th>Символ справа</th><th>Значение</th><th width="140" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$currency}
                </tbody>
            </table>
        </div>
    <div>
<div>
EOF;
