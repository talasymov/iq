<?php
$pageName = "Управление характеристиками";

IncludesFn::printHeader($pageName, "grey");

$tr = '';

foreach ($data["values"] as $value)
{
    $tr .= '<tr>
        <td><input class="design-input edit-val-schema' . $value["ID_cSchema"] . '" value="' . $value["cSchema_Name"] . '" /></td>
        <td class="ta-c">
            <a href="/dashboard/characteristics/value/' . $value["ID_cSchema"] . '"><button class="btn btn-default circle"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
            <button class="save-schema btn btn-default circle" data-id="' . $value["ID_cSchema"] . '"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            <button class="delete-schema btn btn-default circle" data-id="' . $value["ID_cSchema"] . '"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
    </tr>';
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <input class="design-input name-characteristic" data-placeholder="Название" /> <button class="add-characteristic btn btn-default circle" data-id="{$data["category"]}"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Название характеристики</th><th width="190" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$tr}
                </tbody>
            </table>
        </div>
    </div>
</div>
EOF;
