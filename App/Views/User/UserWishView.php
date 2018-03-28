<?php
IncludesFn::printHeader("Wish", "customer grey");

$wish = ShopFn::DrawProduct(ShopFn::GetProductsFromWish(), 4);

$language = new Languages;

$bodyText = <<<EOF
<div class="page-header-iq clear ta-l mobile-top">
    <h1>{$language->Translate('my_wishlist')}</h1>
</div>

<ul class="whish-list-user">
    {$wish}
</ul>
<div class="wishlist-empty" style="display: none">
    <p class="norm-p">You have no items in your wishlist.</p>
    <p class="norm-p"><a href="/" class="link-under">Shopping</a></p>
</div>
EOF;


$bodyTextOld = <<<EOF
<div class="page-header">
    <h1>My Wishlist</h1>
</div><br />
<div class="container-fluid">
    <div class="row">
        {$wish}
    </div>
</div>
EOF;

$script = <<<EOF
<script>
$(document).ready(function(){
    $(".whish-list-user li .del").show();
    
    if($(".item").length == 0)
    {
        $(".wishlist-empty").show();
    }
});

$("body").on("click", ".whish-list-user li .del", function() {
    id = $(this).parents(".item").attr("data-id");
    
    parent = $(this);
    
    $.ajax({
        url: ajaxDir + "Dispatcher",
        type: "POST",
        method: "post",
        data: {
            "query": "DeleteWish",
            "idProduct": id
        },
        success: function ()
        {
            parent.parents(".item").fadeOut();
    
            setTimeout(function() {
                parent.parents(".item").remove();
            
                if($(".item").length == 0)
                {
                    $(".wishlist-empty").show();
                }
            }, 500);
        }
    });
});
</script>
EOF;

