<?php
IncludesFn::printHeader("Account", "customer grey");

$user = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
    BF::ReturnInfoUser(BF::idUser)
]);

$language = new Languages;

$name = $user["Users_name"];
$surName = $user["Users_surname"];
$email = $user["Users_email"];

$bodyText = <<<EOF
<div class="messages">           
</div>
<div class="page-header-iq clear ta-l mobile-top">
    <h1>{$language->Translate('my_account')}</h1>
</div>
    
<div class="area-box">
    <p class="norm-p">{$language->Translate('first_name')}: {$name}</p>
    <p class="norm-p">{$language->Translate('last_name')}: {$surName}</p>
    <p class="norm-p">{$language->Translate('e-mail')}: {$email}</p>
    <p class="norm-p">{$language->Translate('password')}: <a class="link-under h-p" href="/user/information">{$language->Translate('change_password')}</a></p>
    <div class="edit"><a class="link-under h-p" href="/user/information">{$language->Translate('edit_information')}</a></div>
</div>
EOF;


$bodyTextOld = <<<EOF
<h2 class="ta-c">Главная</h2>
<div class="container-fluid">
    <div class="row">
        {$wish}
    </div>
</div>
EOF;
