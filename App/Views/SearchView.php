<?php
IncludesFn::printHeader("Search", "search-body grey");

$echoProduct = ShopFn::DrawProduct($data["result"]["products"], 3);

$language = new Languages;

$query = BF::ClearCode("q", "str", "get");

if(count($data["result"]["products"]) == 0)
{
    $bodyText = <<<EOF
<div class="wrap">
    <div class="container col1-layout">
        <div class="main">
            <div class="col-main">
                <div class="messages"></div>  						
                <div class="category-view" style="opacity: 1;">
                    <div class="page-header"><h1>{$language->Translate('search_results_for')} '{$query}'</h1></div>
                    <p class="note-msg">{$language->Translate('your_search_results_no')}.</p>
                </div>						
            </div>
        </div>
    </div>
    <div class="global-site-notice">
    </div>
</div>
EOF;
}
else
{
    $bodyText = <<<EOF
<div class="page-header-iq">
    <h1>{$language->Translate('search_results_for')} '{$query}'</h1>
</div>
<br />
<div class="wrap">
    <div class="container col1-layout">
        <div class="main category-view-main">
            <div class="col-main">
                <ul>
                    {$echoProduct}	
                </ul>
            </div>
        </div>
    </div>
</div>
EOF;
}

$bodyTextOld = <<<EOF
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid popular-parent">
                <div class="row">
                    <div class="col-md-12 ta-c">
                        <h3>По запросу "{$query}"</h3>
                        Найдено совпадений: {$data["result"]["links"]["countAll"]}
                    </div>
                </div>
                <div class="row">
                    {$echoProduct}
                </div>
                <div class="row ta-c">
                    {$data["result"]["links"]["pagination"]}
                </div>
            </div>
        </div>
    </div>
</div>
EOF;

