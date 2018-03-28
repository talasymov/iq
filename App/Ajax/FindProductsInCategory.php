<?php
function InitHere()
{
    $contents = R::getAll("SELECT title, id_text FROM content WHERE category = ?", [$_POST["idCategory"]]);

    $selectContent = AuxiliaryFn::ArrayToSelect($contents, "selectContent", "id_text", "title", "Выберите страницу");

    return print($selectContent);
}