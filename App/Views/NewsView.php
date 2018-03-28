<?php
IncludesFn::printHeader("News", "grey");

$news = BF::GenerateList($data["products"],
    '<div class="col-md-4">
        <div class="one-news">
            <img src="/Images/News/?">
            <strong>?</strong><span class="date"><i class="fa fa-clock-o" aria-hidden="true"></i> ?</span><br />
            <a href="/news/?"><button class="btn btn-info"><i class="fa fa-book" aria-hidden="true"></i> Читать</button></a>
        </div>
    </div>',
    ["news_img", "news_title", "news_date", "news_id"]);

$bodyText = <<<EOF
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="ta-c">Новость</h2>
            </div>
        </div>
        <div class="row">
            {$news}
        </div>
        <div class="row">
            <div class="col-md-12 ta-c">
                {$data["links"]}
            </div>
        </div>
    </div>
EOF;
