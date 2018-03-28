<?php
function InitHere()
{
    $login = $_POST["login"];
    $password = $_POST["password"];

    $checkUserInSystem = BF::CheckUserInSystem($login, $password);

    if($checkUserInSystem == 1)
    {
        BF::LoginUser($login, $password);
    }
    return $checkUserInSystem;
}
