<?php
$pageName = $data["Users_surname"] . ' ' . $data["Users_name"]. ' ' . $data["Users_patronymic"];

Dashboard::printHeader($pageName, "grey");

//$countDay = 4;
//
//$W_in = 28863000000;
//$W_all = 9720000;
//$F_all = 5400000;
//
//$num = 432 * 24 * $countDay * ( (1 + 0.5 * ($W_in/$W_all)) / $F_all );
//
//AuxiliaryFn::StylePrint($countDay / 360);
//AuxiliaryFn::StylePrint(24 * $countDay);
//AuxiliaryFn::StylePrint($num);
//AuxiliaryFn::StylePrint("Результат:");
//AuxiliaryFn::StylePrint(100 / $num);

$gender = BF::ReturnGender($data["Users_gender"]);

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
                <tbody>
                    <tr><th class="strong">ФИО:</th><td>{$data["Users_surname"]} {$data["Users_name"]} {$data["Users_patronymic"]}</td></tr>
                    <!--<tr><th class="strong">Дата рождения:</th><td>{$data["Users_birth"]}</td></tr>-->
                    <tr><th class="strong">Пол:</th><td>{$gender}</td></tr>
                    <!--<tr><th class="strong">Телефон:</th><td>{$data["Users_phone"]}</td></tr>-->
                    <tr><th class="strong">Почта:</th><td>{$data["Users_email"]}</td></tr>
                    <!--<tr><th class="strong">Откуда:</th><td>{$data["Users_from"]}</td></tr>-->
                </tbody>
            </table>
        </div>
    </div>
</div>
EOF;
