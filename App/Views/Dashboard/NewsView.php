<?php
$pageName = "Новости";

IncludesFn::printHeader($pageName, "grey");

$products = BF::GenerateList($data["products"], "<tr><td>?</td><td>?</td><td><a href=\"/dashboard/news/edit/?\"><button class='btn btn-default'><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></button></a></td></tr>", ["news_id", "news_title", "news_id"]);

//$products = '';
//
//foreach ($data["products"] as $product)
//{
//    $products .= <<<EOF
//<tr>
//    <td>{$product["news_title"]}</td>
//    <td><a href="/dashboard/news/edit/{$product["news_id"]}?lang=ru"><button class="btn btn-default circle"><i class="fa fa-cog" aria-hidden="true"></i></button></a></td>
//    <td><a href="/dashboard/news/edit/{$product["news_id"]}"><button class="btn btn-default circle"><i class="fa fa-cog" aria-hidden="true"></i></button></a></td>
//</tr>
//EOF;
//
//}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12">
            <a href="/dashboard/news/create/">
            <button class="edit-product btn btn-info">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Добавить новость
            </button>
            </a>
            <table class="table">
                <thead>
                    <tr><th>Номер товара</th><th>Название товара</th><th></th></tr>
                </thead>
                <tbody>
                    {$products}
                </tbody>
            </table>
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
