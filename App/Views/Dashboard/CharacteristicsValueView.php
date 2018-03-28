<?php
$pageName = "Управление значениями";

IncludesFn::printHeader($pageName, "grey");

$tr = '';

foreach ($data["values"] as $value)
{
    $tr .= '<tr>
        <td><input class="design-input edit-val-s-schema' . $value["ID_cValue"] . '" value="' . $value["cValueValue"] . '" /></td>
        <td class="ta-c">
            <button class="save-schema-val btn btn-default circle" data-id="' . $value["ID_cValue"] . '"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            <button class="delete-schema-val btn btn-default circle" data-id="' . $value["ID_cValue"] . '"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
    </tr>';
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <input class="design-input value-characteristic" data-placeholder="Название" /> <button class="add-characteristic-value btn btn-default circle" data-id="{$data["idScheme"]}"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Значение</th><th width="140" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$tr}
                </tbody>
            </table>
        </div>
    </div>
</div>
EOF;
