<?php
$pageName = "Страницы";

Dashboard::printHeader($pageName, "grey");

//$products = BF::GenerateList($data["products"], "<tr><td  class=\"ta-c\">?</td><td>?</td><td><a href=\"/dashboard/news/edit/?\"><button class='btn btn-default circle'><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></button></a></td></tr>", ["news_id", "news_title", "news_id"]);

$products = '';

foreach ($data["products"] as $product)
{
    $products .= <<<EOF
<tr>
    <td>{$product["news_title"]}</td>
    <td class="ta-c"><a href="/dashboard/news/edit/{$product["news_id"]}?lang=ru"><button class="btn btn-default circle"><i class="fa fa-cog" aria-hidden="true"></i></button></a></td>
    <td class="ta-c"><a href="/dashboard/news/edit/{$product["news_id"]}"><button class="btn btn-default circle"><i class="fa fa-cog" aria-hidden="true"></i></button></a></td>
</tr>
EOF;

}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <span style="height: 40px;display: inline-block"></span>
                <!--<a href="/dashboard/news/create/">-->
                    <!--<button class="edit-product btn btn-default circle">-->
                        <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
                    <!--</button>-->
                <!--</a>-->
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Заголовок</th><th width="100" class="ta-c">Русский</th><th width="100" class="ta-c">Английский</th></tr>
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
