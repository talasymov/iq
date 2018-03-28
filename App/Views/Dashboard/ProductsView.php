<?php
$pageName = "Товары";

Dashboard::printHeader($pageName, "grey");

$products = BF::GenerateList($data["products"], "<tr><td class='ta-c'>?</td><td class='ta-c'><img src='?' class='img-in-table'></td><td>?</td><td><input type='number' class='design-input mini change-position' min='0' data-id='?' value='?' /></td><td>?</td><td class='ta-c'><a href=\"/dashboard/products/edit/?\"><button class='btn btn-default circle'><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></button></a><button class='btn btn-default circle delete-product' data-id='?'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td></tr>", ["ID_product", "ProductImagesPreview", "ProductName", "ID_product", "ProductPosition", "Categories_name", "ID_product", "ID_product"]);

$categories = R::getAll("SELECT * FROM Categories");

$categoriesArray = AuxiliaryFn::ArrayToSelect($categories, "design-input filter-category dashed", "Categories_id", "Categories_name", "Выберите категорию");

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <!--<form action="/dashboard/products" class="d-ib" method="get">{$categoriesArray}</form>-->
                {$categoriesArray}
                <form action="/dashboard/products" class="d-ib" method="get"><input class="design-input dashed input-search" name="search" data-path="products" data-placeholder="Какой товар найти?"> <button class="search-button btn btn-default circle"><i class="fa fa-search" aria-hidden="true"></i></button></form>
                <a href="/dashboard/products/create/"><button class="edit-product btn btn-default circle"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
            </div>
        </div>
        <div class="col-md-12">
            <!--<div class="council-div"><i class="fa fa-info-circle" aria-hidden="true"></i>Заполняйте пожалуйста всю информацию
            товара!</div>-->
            <table class="table">
                <thead class="strong">
                    <tr><th class='ta-c' width="50">ID</th><th class='ta-c' width="120">Изображение</th><th>Название товара</th><th>Позиция</th><th>Категория</th><th width="125" class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                    {$products}
                </tbody>
            </table>
        </div>
        <div class="col-md-12 ta-c">
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
