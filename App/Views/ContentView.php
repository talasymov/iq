<?php
$meta = <<<EOF
<meta name="keywords" content="{$data["news_keywords"]}" />
<meta name="description" content="{$data["news_description"]}" />
EOF;

IncludesFn::printHeader($data["news_title" . USER_LANG], "checkout-cart-index content-page grey", $meta);

$content = BF::ClearText($data["news_content" . USER_LANG]);

$bodyText = <<<EOF
<div class="wrap mobile-padding">
    <div class="container col1-layout margin-top-min-10">
        <div class="main">
            <div class="col-main">
                    <div class="cart" style="opacity: 1;">
                        <div class="page-header-iq">
                            <h1>{$data["news_title" . USER_LANG]}</h1>
                        </div>
                        <div class="cart-empty">
                            {$content}
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
EOF;
