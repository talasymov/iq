<?php
require_once (DIR_INCLUDE . "Header.php");

$body = <<<EOF
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="menu-top information-page click-menu">
                <div class="menu-home">
                    <strong><i class="fa fa-bars" aria-hidden="true"></i> Меню</strong>
                    <ul>
                        <li><a href="">Доставка и оплата</a></li>
                        <li><a href="">Контакты</a></li>
                        <li><a href="">FAQ</a></li>
                        <li><a href="">О нас</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="product">
                {$bodyText}
            </div>
        </div>
    </div>
</div>
EOF;

print($body);

require_once (DIR_INCLUDE . "Footer.php");
