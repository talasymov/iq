<?php
$pageName = "Баннера";

Dashboard::printHeader($pageName, "grey");

$category = R::getAll("SELECT * FROM Categories WHERE Categories_parent = 0");

$tr = "";

foreach ($data as $value)
{
    $img = Draw::SelectFile($value["shares_img"]);

    if($value["shares_view"] == 0)
    {
        $eye = "-slash";
    }

    $select = AuxiliaryFn::ArrayToSelect($category, "design-input category-partner", "Categories_id", "Categories_name", "Не указана", $value["shares_category"]);

    $tr .= <<<EOF
    <tr>
        <td>
            <div class="d-ib f-l" style="padding: 10px;">АНГЛ:</div> <input class="design-input title" value="{$value["shares_title"]}" /><br />
            <div class="d-ib f-l" style="padding: 10px 17px 10px 10px;">РУС:</div> <input class="design-input title ru" value="{$value["shares_title_ru"]}" />
        </td>
        <td>
            <div class="d-ib f-l" style="padding: 10px;">АНГЛ:</div> <input class="design-input desc" value="{$value["shares_desc"]}" /><br />
            <div class="d-ib f-l" style="padding: 10px 17px 10px 10px;">РУС:</div> <input class="design-input desc ru" value="{$value["shares_desc_ru"]}" />
        </td>
        <td><input class="design-input url" value="{$value["shares_url"]}" /></td>
        <td>{$img}</td>
        <!--<td>{$select}</td>-->
        <td>
            <!--<button class='view-banner btn btn-default circle' data-id="{$value["shares_id"]}"><i class="fa fa-eye{$eye}" aria-hidden="true"></i></button>-->
            <button class='save-banner btn btn-default circle' data-id="{$value["shares_id"]}"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            <!--<button class='btn btn-default circle' data-id="{$value["shares_id"]}"><i class="fa fa-cog" aria-hidden="true"></i></button>-->
        </td>
    </tr>
EOF;
}

//$products = BF::GenerateList($data, "<tr><td>?</td><td>?</td><td><button class='btn btn-default circle'><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></button></td></tr>", ["shares_title", "shares_img"]);

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <span style="height: 40px;display: inline-block"></span>
                <!--<button class="add-banner btn btn-default circle">-->
                    <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
                <!--</button>-->
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Заголовок</th><th>Описание</th><th>Ссылка</th><th>Изображение</th><th width="90"></th></tr>
                </thead>
                <tbody>
                    {$tr}
                </tbody>
            </table>
        </div>
        <div class="col-md-12 ta-c">
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
