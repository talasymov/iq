<?php
$meta = <<<EOF
<meta name="keywords" content="{$data["news_keywords"]}" />
<meta name="description" content="{$data["news_description"]}" />
EOF;

IncludesFn::printHeader("News", "grey", $meta);

$content = BF::ClearText($data["news_content"]);

$bodyText = <<<EOF
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="ta-c">{$data["news_title"]}</h2>
                <h5 class="ta-c"><i class="fa fa-clock-o" aria-hidden="true"></i> {$data["news_date"]}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 news-page">
                <img src="/Images/News/{$data["news_img"]}" />
                {$content}
            </div>
        </div>
    </div>
EOF;
