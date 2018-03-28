<?php
require_once ($_SERVER["DOCUMENT_ROOT"] . "/App/Library/Sweane/BF.php");

function InitHere($query)
{
    $oneState = "";
    $queryFrom = BF::CreateLikeQuery(["carrot_blog_content", "carrot_blog_title", "carrot_blog_description", "carrot_blog_keywords"], $query);

    $articles = R::getAll("SELECT * FROM carrot_blog WHERE {$queryFrom} ORDER BY carrot_blog_id DESC");

    foreach ($articles as $key => $value) {
        $id = $value["carrot_blog_id"];
        $title = $value["carrot_blog_title"];
        $views = $value["carrot_blog_views"];
        $reviews = $value["carrot_blog_reviews"];
        $images = $value["carrot_blog_images"];
        $description = $value["carrot_blog_description"];

        $oneState .= <<<EOF
<div class="col-md-3">
<div class="blog-block shadow-me">
<div class="blog-block-img"><img src="{$images}" alt="some seo text"></div>
<div class="blog-block-text-preview">
    <h3>{$title}</h3>
    <p>{$description}</p>
</div>
<div class="blog-block-bottom">
    <a href="/blog/{$id}" class="blog-bottom-a"><div class="read-more"><span>Читать</span></div></a>
    <a href="javascript:void(0);" class="blog-bottom-a"><div class="comment-count"><i class="fa fa-commenting-o" aria-hidden="true"></i><span>{$reviews}</span></div></a>
        <a href="javascript:void(0);" class="blog-bottom-a"><div class="see-count"><i class="fa fa-eye" aria-hidden="true"></i><span>{$views}</span></div></a>
    <div class="cb"></div>
</div>
</div>
</div>
EOF;
    }

    return $oneState;

}