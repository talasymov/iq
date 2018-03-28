<?php
function InitHere()
{
    $idContent = $_POST["idContent"];
    $result = "";

    $works = R::getAll("SELECT * FROM portfolio WHERE id_content = ?", [$idContent]);

    if(count($works) > 0)
    {
        foreach($works as $value)
        {
            $result .= "<div class=\"list-one-port\"><div class=\"one-port-bg\"></div><img src=\"" . $value["image_one"] . "\"></div>";
        }
    }

    return print($result);
}