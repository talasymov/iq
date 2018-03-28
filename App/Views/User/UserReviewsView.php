<?php
IncludesFn::printHeader("Wish", "grey");

//AuxiliaryFn::StylePrint($data);

//$wish = ShopFn::DrawProduct($data, 4);

$productOne = '';

if($col == null)
{
    $col = 4;
}

foreach ($data as $key => $value)
{
    $balance = '';
    $heartClass = '';
    $lastPrice = '';
    $discount = '';
    $reviewManager = '<strong class="center strong">Извините, но Вы уже оставили отзыв!</strong>';
    $heart = 'fa-heart-o';

    $buttonCart = '<button data-id="'.$value["ID_product"].'" class="review-product btn btn-info" data-id="' . $value["ID_product"] . '"><i class="fa fa-comment" aria-hidden="true"></i> Оставить отзыв</button>';

    if($value["ProductLastPrice"] != null)
    {
        $lastPrice = '<span class="last-price">' . $value["ProductLastPrice"] . '</span>';

        $discount = '<span class="discount">%</span>';
    }

    if($value["ReviewText"] == null)
    {
        $reviewManager = '<textarea placeholder="Ваш отзыв" class="design-textarea review-text">'.$value["ReviewText"].'</textarea>
            <div class="center">'.$buttonCart.'</div>';
    }

    $productOne .= '
    <div class="col-md-'.$col.'">
        <div class="one-product">
            '.$discount.'
            <a href="/product/'.$value["ID_product"].'">
                <img src="'.$value["ProductImagesPreview"].'" />
                <strong>'.$value["ProductName"].'</strong>
            </a>
            <span class="money"><b>'.$value["ProductPrice"].'</b>'.$lastPrice.' грн</span><br />
            '.$reviewManager.'
        </div>
    </div>';

}

$bodyText = <<<EOF
<h2 class="ta-l strong">Мои отзывы</h2><br />
<div class="container-fluid">
    <div class="row">
        {$productOne}
    </div>
</div>
EOF;
