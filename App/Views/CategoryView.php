<?php
//AuxiliaryFn::StylePrint($data);

$categoryId = $data["categoryId"];

$workCategory = $categoryId;

$minPrice = R::getRow("SELECT ProductPrice FROM Products WHERE ProductCategory = ? ORDER BY ProductPrice",[
    $workCategory
]);
$maxPrice = R::getRow("SELECT ProductPrice FROM Products WHERE ProductCategory = ? ORDER BY ProductPrice DESC",[
    $workCategory
]);

//$language = new Languages;

$listPrice = BF::ClearCode("listPrice", "str", "get");

$explodePrice = explode(",", $listPrice);

$priceStart = intval($explodePrice[0]);
$priceEnd = intval($explodePrice[1]);

if($priceStart == 0)
{
    $priceStart = $minPrice["ProductPrice"];
}

if($priceEnd == 0)
{
    $priceEnd = $maxPrice["ProductPrice"];
}

$sumPrice = $maxPrice["ProductPrice"] - $minPrice["ProductPrice"];

$mr = 12;

$thisCategoryName = R::getRow("SELECT Categories_name, Categories_name_ru FROM Categories WHERE Categories_id = ?", [
    $workCategory
]);

IncludesFn::printHeader($thisCategoryName["Categories_name" . USER_LANG]);

$res = ShopFn::PrintStyleRecurs(ShopFn::GetPath($workCategory, [
    $workCategory => [
        "name" => $thisCategoryName["Categories_name" . USER_LANG],
        "id" => $workCategory
    ]
]), $workCategory);

$sortArray = [
    1 => "По рейтингу",
    2 => "От дешевых к дорогим",
    3 => "От дорогих к дешевым",
    4 => "Недавно добавленные"
];

$listCount = [
    0 => 20,
    2 => 2,
    5 => 5,
    10 => 10,
    20 => 20,
    50 => 50,
    100 => 100
];

$sortArrayBuild = AuxiliaryFn::ArrayToSelectSimple($sortArray, "design-input list-sort", "Сортировка товара", BF::ClearCode("sortProducts", "int", "get"));
$listCountBuild = AuxiliaryFn::ArrayToSelectSimple($listCount, "design-input list-count", "Показать", BF::ClearCode("listCount", "int", "get"));

$echoFilter = "";
$selectedValue = '';

foreach ($data["filters"] as $key => $value)
{
    $header = "<strong>" . $key . "</strong>";

    $list = '';

    foreach ($value as $subValue)
    {
        $active = '';

        if(in_array($subValue["ID_cValue"], $data["listVar"])){
            $selectedValue .= "<span class='selected-filter' data-id='" . $subValue["ID_cValue"] . "'><button class='remove clear-button'><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>" . $subValue["cValueValue"] . "</span>";

            $active = "active";
        }

        $list .= '<span class="task-one-list" data-id="'.$subValue["ID_cValue"].'"><strong class="carrot-radio '.$active.'">'.$subValue["cValueValue"].'</strong></span>';
    }

    $echoFilter .= $header . $list;
}

if($selectedValue != '')
{
    $selectedValueStrong = '<strong class="strong header-filter-clear">Вы выбрали</strong>';

    $selectedValueButton = '<div class="center"><button class="clear-filter clear-button">Сбросить фильтры</button><hr /></div>';
}

$menu = IncludesFn::GenerateCategoryMenu();

$productOne = ShopFn::DrawProduct($data["products"]["products"], 4, 3, $data["view"]);

$explodePrice = explode(",", $listPrice);


$listCategory = BF::GenerateList($data["categoryData"], '<div class="col-md-3"><div class="one-product ta-c"><a href="/category/?"><img src="?"><strong class="strong">?</strong></a><button></button></div></div>', ["Categories_id", "Categories_image", "Categories_name"]);

$categoryName = $data["categoryInfo"]["Categories_name" . USER_LANG];

if($listCategory == "")
{
    $categoryName = "";
}

//$breadCrumbs = "Bread Crumbs";

$listVarGet = BF::ClearCode("listVar", "str", "get");
$listPriceGet = BF::ClearCode("listPrice", "str", "get");
$sortProductsGet = BF::ClearCode("sortProducts", "str", "get");
$listCountGet = BF::ClearCode("listCount", "str", "get");
$viewGet = BF::ClearCode("view", "str", "get");

$bodyText = <<<EOF
<div class="wrap margin-top-clear">
					    
		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						<div class="category-view" style="opacity: 1;">

    <div class="messages">           
  </div>          
            <div class="page-header category-header">
    <div class="wrap_title_cat">
        <h1 class="cat-title-classic">{$thisCategoryName["Categories_name" . USER_LANG]}</h1>
    </div>
</div>
                        
<div class="desktop currently">
</div>
        </div>
        <main class="category-view-main">
                        <div class="category-products row">
            <div>
<ol class="products-list unstyled thumbnails" id="products-list" data-featured="1" data-featured-container=".category-products" data-featured-item-class="item" data-featured-last-row-item-class="no-left-margin" data-featured-fade-in="1" style="visibility: visible;">
    {$productOne}
</ol>
</div>
</div>
        </main>
    </div>

<input type="hidden" name="created_at" value="2017-10-15 20:34:12">						<div class="visible-phone">
													</div>
					</div>
				</div>
			</div>
			<div class="global-site-notice">
    <noscript>
        &lt;div class="noscript alert alert-error"&gt;
            &lt;div class="notice-inner"&gt;
                &lt;p&gt;
                    &lt;strong&gt;JavaScript seems to be disabled in your browser.&lt;/strong&gt;&lt;br /&gt;
                    You must have JavaScript enabled in your browser to utilize the functionality of this website.                &lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    </noscript>
</div>
			<div class="push hidden-phone"></div>
		</div>
EOF;

$script = <<<EOF

EOF;
