<?php
$shares = BF::GenerateList(DataBase::GetShares(), '<div class="item"><a href="?"><img src="?" /></a></div>', ["shares_url", "shares_img"]);
$news = BF::GenerateList(DataBase::GetNews(), '<div class="col-md-3 one-news-home"><div class="one-news-home-div"><a href="/news/?"><img src="/Images/Products/?" /><strong>?</strong></a><span>?</span></div></div>', ["news_id", "news_img", "news_title", "news_description"]);

$popular = ShopFn::DrawProduct(DataBase::GetPopularProducts(), 3);
$sales = ShopFn::DrawProduct(DataBase::GetSalesProducts(), 3);
$last = ShopFn::DrawProduct(DataBase::GetLastProducts(), 3);
$viewed = ShopFn::DrawProduct(DataBase::GetViewedProducts(), 3);

$menu = IncludesFn::GenerateCategoryMenu();

$data = R::getRow("SELECT * FROM Settings WHERE Settings_id = 1");

$dataJson = json_decode($data["Settings_json"]);

$meta = <<<EOF
<meta name="keywords" content="{$dataJson->seoKeywords}" />
<meta name="description" content="{$dataJson->seoDescription}" />
EOF;

//AuxiliaryFn::StylePrint(ShopFn::GetIdFromViewed());

IncludesFn::printHeader($dataJson->seoTitle, "", $meta);

$banner1 = R::getRow("SELECT * FROM Shares WHERE shares_id = 2");
$banner2 = R::getRow("SELECT * FROM Shares WHERE shares_id = 3");
$banner3 = R::getRow("SELECT * FROM Shares WHERE shares_id = 4");
$banner4 = R::getRow("SELECT * FROM Shares WHERE shares_id = 5");

$banner1Link = $banner1["shares_url"];
$banner1Image = $banner1["shares_img"];
$banner1Title = $banner1["shares_title" . USER_LANG];
$banner1Desc = $banner1["shares_desc" . USER_LANG];

$banner2Link = $banner2["shares_url"];
$banner2Image = $banner2["shares_img"];
$banner2Title = $banner2["shares_title" . USER_LANG];
$banner2Desc = $banner2["shares_desc" . USER_LANG];

$banner3Link = $banner3["shares_url"];
$banner3Image = $banner3["shares_img"];
$banner3Title = $banner3["shares_title" . USER_LANG];
$banner3Desc = $banner3["shares_desc" . USER_LANG];

$banner4Link = $banner4["shares_url"];
$banner4Image = $banner4["shares_img"];
$banner4Title = $banner4["shares_title" . USER_LANG];
$banner4Desc = $banner4["shares_desc" . USER_LANG];


if($banner4Image != "")
{
    $banner4Content = <<<EOF
<div class="home-bloc-full">
    <a href="{$banner4Link}">
    <img src="{$banner4Image}" alt="" />
    <span class="home-bloc-title white">{$banner4Title}</span>
    <span class="home-bloc-cta">{$banner4Desc}</span>
</div>
EOF;

}

//$public_key = "i94249257993";
//$private_key = "oGK7ySfbjQ4cjzSsLRFqTFrf5UozkmvZdNHGsd7t";
//
//$liqpay = new LiqPay($public_key, $private_key);
//
//$html = $liqpay->cnb_form(array(
//    'action'         => 'pay',
//    'amount'         => '1',
//    'currency'       => 'USD',
//    'description'    => 'description text',
//    'order_id'       => 'order_id_1',
//    'version'        => '3',
//    'sandbox'        => '1'
//));

//print($html);

$bodyText = <<<EOF
<div class="body-collapse">
    <div class="container col1-layout">
        <div class="main">
            <div class="col-main">
                <div class="std">
                    <div class="home-version-1">
                        <div class="home-bloc-1 clearfix">
                            <div class="img-left">
                                <a href="{$banner1Link}" class="block-b-1">
                                    <img src="{$banner1Image}" alt="" />
                                    <span class="home-bloc-title white">{$banner1Title}</span>
                                    <span class="home-bloc-cta">{$banner1Desc}</span>
                                </a>
                                
                                <a href="{$banner2Link}" class="block-m-1">
                                    <img src="{$banner2Image}" alt="" />
                                    <span class="home-bloc-title white">{$banner2Title}</span>
                                    <span class="home-bloc-cta">{$banner2Desc}</span>
                                </a>
                            </div>
                            <div class="img-right">
                                <a href="{$banner3Link}" class="block-b-2">
                                    <img src="{$banner3Image}" alt="" />
                                    <span class="home-bloc-title white">{$banner3Title}</span>
                                    <span class="home-bloc-cta">{$banner3Desc}</span>
                                </a>
                            </div>
                        </div>
                        {$banner4Content}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id='fb-root'></div>
<!--</div>-->
EOF;

//AuxiliaryFn::StylePrint(BF::GeneratePass("admin"));
//AuxiliaryFn::StylePrint(BF::GeneratePass("bgteuk"));

$bodyTextOld = <<<EOF
<div class="bg-menu-black"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="menu-top">
                <div class="menu-home">
                    <strong><i class="fa fa-cog" aria-hidden="true"></i> Каталог товаров</strong>
                    {$menu}
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="main-slider" class="class="owl-carousel owl-theme"">{$shares}</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="home-header-list">Популярные товары</h3>
        </div>
    </div>
    {$popular}
    <div class="row perspective">
        <div class="col-md-12">
            <h3 class="home-header-list">Скидки</h3>
        </div>
    </div>
    {$sales}
    <div class="row">
        <div class="col-md-12">
            <h3 class="home-header-list">Последние товары</h3>
        </div>
    </div>
    {$last}
    <div class="row">
        <div class="col-md-12">
            <h3 class="home-header-list">Просмотренные товары</h3>
        </div>
    </div>
    {$viewed}
    <div class="row">
        <div class="col-md-12">
            <h3 class="home-header-list">Новости, советы, статьи</h3>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="news-request home-c">
                            <strong>Узнавай о новых акциях!</strong>
                            <input placeholder="Введите e-mail">
                            <button>Подписаться</button>
                            <div class="social">
                                <a href="https://www.facebook.com/%D0%A0%D0%B5%D0%BA%D0%BB%D0%B0%D0%BC%D0%BD%D0%BE%D0%B5-%D0%B0%D0%B3%D0%B5%D0%BD%D1%82%D1%81%D1%82%D0%B2%D0%BE-%D0%A7%D0%B5%D0%BC%D0%BF%D0%B8%D0%BE%D0%BD-437677686285200/"><span class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></span></a>
                                <a href="http://www.google.com/"><span class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></span></a>
                                <a href="https://www.instagram.com/groupchampion/"><span class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span></a>
                                <a href="https://vk.com/ra_chempion_group"><span class="vk"><i class="fa fa-vk" aria-hidden="true"></i></span></a>
                                <a href="https://twitter.com/ChempionGroup"><span class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></span></a>
                            </div>
                        </div>
                    </div>
                    {$news}
                </div>
                <div class="row">
                    <div class="col-md-12 ta-r">
                        <a href="/news/" class="arrow-link">Все новости, советы, статьи <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
EOF;
