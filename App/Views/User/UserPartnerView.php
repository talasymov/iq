<?php
IncludesFn::printHeader("Партнерская программа", "grey");

if($data["Partners_status"] == 0)
{
    $view = <<<EOF
    <p class="bg-primary" style="padding: 20px;">Вы уже оставили заявку на участие в партнерской программе: <b class="strong">{$data["Partners_date"]}</b>.<br />
    После проверки, Вам на почту должно прийти письмо с подтверждением аккаунта для участия в партнерской программе!</p>
EOF;
}
if($data["Partners_status"] == 1)
{
    $view = <<<EOF
    <a href="/dashboard/"><button class="send-partner-query btn btn-primary btn-sm">Войти в панель управления</button></a>
EOF;
}
else if($data === false)
{
    $view = <<<EOF
    Хотите стать партнером?<br /><br />
    <button class="send-partner-query btn btn-primary btn-sm">Оставить заявку</button>
EOF;
}

$bodyText = <<<EOF
<h2 class="ta-c">Партнерская программа</h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {$view}
        </div>
    </div>
</div>
EOF;
