<?php
$pageName = "Настройки магазина";

IncludesFn::printHeader($pageName, "grey");

$user = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
    BF::ReturnInfoUser(BF::idUser)
]);

//AuxiliaryFn::StylePrint($user);

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
                <tr>
                    <th class="strong">Название компании</th>
                    <td><input class="design-input name" data-placeholder="Название комании" value="{$user["Users_company_name"]}"></td>
                </tr>
                <tr>
                    <th class="strong">Логотип</th>
                    <td>{$file}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
EOF;
