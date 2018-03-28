<?php
//require_once (DIR_INCLUDE . "Header.php");
$files = Files::StyleFiles(DIR_IMAGES_NON_ROOT);

$permissionUser = BF::ReturnInfoUser(BF::permissionUser);

if($permissionUser == 777)
{
    $menu = <<<EOF
<ul>
    <li><a href="/dashboard/"><i class="fa fa-pie-chart" aria-hidden="true"></i> Статистика</a></li>
    <li><a href="/dashboard/orders"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Заказы</a></li>
    <li><a href="/dashboard/products"><i class="fa fa-cube" aria-hidden="true"></i> Товары</a></li>
    <!--<li><a href="/dashboard/set"><i class="fa fa-briefcase" aria-hidden="true"></i> Наборы</a></li>-->
    <li><a href="/dashboard/properties"><i class="fa fa-tags" aria-hidden="true"></i> Свойства</a></li>
    <li><a href="/dashboard/category"><i class="fa fa-list" aria-hidden="true"></i> Категории</a></li>
    <!--<li><a href="/dashboard/characteristics"><i class="fa fa-th" aria-hidden="true"></i> Характеристики</a></li>-->
    <!--<li><a href="/dashboard/reviews"><i class="fa fa-comments" aria-hidden="true"></i> Отзывы</a></li>-->
    <li><a href="/dashboard/blog"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Страницы</a></li>
    <!--<li class="drop-menu"><a><i class="fa fa-cog" aria-hidden="true"></i> Настройки магазина  <i class="fa fa-chevron-right f-r" aria-hidden="true"></i></a>-->
        <!--<ul>-->
            <!--<li><a href="/dashboard/company-settings"><i class="fa fa-cog" aria-hidden="true"></i> Основное</a></li>-->
            <!--<li><a href="/dashboard/currency"><i class="fa fa-dollar" aria-hidden="true"></i> Валюты</a></li>-->
            <!--<li><a href="/dashboard/taxation"><i class="fa fa-percent" aria-hidden="true"></i> Налоги</a></li>-->
            <!--&lt;!&ndash;<li><a href="/dashboard/money"><i class="fa fa-sort" aria-hidden="true"></i> Единицы измерения</a></li>&ndash;&gt;-->
        <!--</ul>-->
    <!--</li>-->
        <!--<li><a href="/dashboard/shares-menu"><i class="fa fa-percent" aria-hidden="true"></i> Акции в меню</a></li>-->
    <li><a href="/dashboard/banners"><i class="fa fa-picture-o" aria-hidden="true"></i> Баннера</a></li>
            <!--<li><a href="/dashboard/info-blocks"><i class="fa fa-file-text" aria-hidden="true"></i> Информационные блоки</a></li>-->
    <li><a href="/dashboard/clients"><i class="fa fa-users" aria-hidden="true"></i> Клиенты</a></li>
    <!--<li><a href="/dashboard/group-clients"><i class="fa fa-users" aria-hidden="true"></i> Группы клиентов</a></li>-->
    <!--<li><a href="/dashboard/partner"><i class="fa fa-handshake-o" aria-hidden="true"></i> Партнеры</a></li>-->
    <li><a href="/dashboard/emails"><i class="fa fa-envelope" aria-hidden="true"></i> Emails</a></li>
    <li><a href="/dashboard/settings"><i class="fa fa-cog" aria-hidden="true"></i> Настройки</a></li>
        
    <!--<li><a href="/dashboard/reports"><i class="fa fa-table" aria-hidden="true"></i> Отчеты</a></li>-->
    <!--<li class="drop-menu"><a><i class="fa fa-shield" aria-hidden="true"></i> Безопасность <i class="fa fa-chevron-right f-r" aria-hidden="true"></i></a>-->
        <!--<ul>-->
            <!--<li><a href="/dashboard/my-account"><i class="fa fa-user" aria-hidden="true"></i> Мои данные</a></li>-->
            <!--<li><a href="/dashboard/users"><i class="fa fa-users" aria-hidden="true"></i> Пользователи</a></li>-->
        <!--</ul>-->
    <!--</li>-->
    <!--<li><a href="/dashboard/bell"><i class="fa fa-bell" aria-hidden="true"></i> Уведомления <span class="mini-info">3</span></a></li>-->
</ul>
EOF;
}
else if($permissionUser == 555)
{
    $menu = <<<EOF
<ul>
    <li><a href="/dashboard/products"><i class="fa fa-cube" aria-hidden="true"></i> Товары</a></li>
    <li><a href="/dashboard/company-settings"><i class="fa fa-cog" aria-hidden="true"></i> Настройка магазина</a></li>
</ul>
EOF;
}

$nameUser = BF::ReturnInfoUser(BF::nameUser);

$body = <<<EOF
<div class="modal-file-bg"></div>
<div class="modal-file">
    <div class="menu-file">
        <button class="check-file menu-file-button"><i class="fa fa-check" aria-hidden="true"></i></button>
        <button class="create-folder menu-file-button"><i class="fa fa-folder" aria-hidden="true"></i></button>
        <button class="menu-file-button"><label for="upload-file-image"><i class="fa fa-upload" aria-hidden="true"></i></label></button>
        <button class="delete-file-image menu-file-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <button class="close-file-m f-r menu-file-button"><i class="fa fa-times" aria-hidden="true"></i></button>
        <input id="upload-file-image" data-dir="Images/" type="file">
    </div>
    <div class="menu-file-under">
        <input class="design-input name-folder" data-placeholder="Имя папки"> <button class="menu-file-button-default">ОК</button>
    </div>
    <div class="preview-file"><img src=""></div>
    <div class="body-file meScroll-mini">
        {$files}
    </div>
</div>
<div class="d-top-menu">
    <div class="d-top-left-margin">
        <a class="logo-carrot" href="/dashboard/"></a>
    </div>
    <div class="d-top-left-menu">
        <button class="open-menu"><i class="fa fa-bars" aria-hidden="true"></i></button>
        <a href="/" target="_blank"><button data-toggle="tooltip" data-placement="bottom" data-original-title="Просмотреть сайт"><i class="fa fa-binoculars" aria-hidden="true"></i></button></a>
        <!--<button class="" data-toggle="tooltip" data-placement="bottom" data-original-title="Помо"><i class="fa fa-graduation-cap" aria-hidden="true"></i></button>-->
        <!--<button class="" data-toggle="tooltip" data-placement="bottom" data-original-title="Помощь"><i class="fa fa-life-ring" aria-hidden="true"></i></button>-->
        <!--<button class="" data-toggle="tooltip" data-placement="bottom" data-original-title="Уведомления"><i class="fa fa-bell" aria-hidden="true"></i></button>-->
        <button class="quit-user" data-toggle="tooltip" data-placement="bottom" data-original-title="Выйти из системы"><i class="fa fa-power-off" aria-hidden="true"></i></button>
        <div class="h3"><i class="fa fa-circle" aria-hidden="true"></i> {$pageName}</div>
    </div>
</div>
<div class="user-info">
    <i class="fa fa-user-circle" aria-hidden="true"></i>
    <strong class="strong">{$nameUser}</strong>
</div>
<div class="d-left-menu meScroll-mini">
{$menu}
<div class="black-logo-store ta-c">
<!--<img src="/Images/Icons/store-icon-black-01.svg">-->
</div>
</div>
<div class="d-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-bg">
                    {$bodyText}
                </div>
            </div>
        </div>
    </div>
</div>
EOF;

print($body);

BF::IncludeScripts([
    "jquery/jquery-3.1.0.min",
    "owl/owl.carousel",
    "bootstrap-3.3.7/js/bootstrap",
    "core/bootbox.min",
    "core/ui-slider",
    "core/core"
]);

print ($script);

//require_once (DIR_INCLUDE . "Footer.php");
