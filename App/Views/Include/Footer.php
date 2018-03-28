<?php
global $currentYear;

$language = new Languages;

$insta = 'https://www.instagram.com/iq.intimatequestion/';

if(USER_LANG == '_ru')
{
    $insta = 'https://www.instagram.com/iq.lingerie/';
}

$Footer = <<<EOF
<footer class="footer">
<div class="clearfix">
    <div class="footer-links">
        <ul class="customer-service">
            <li class="footer-list-title">{$language->Translate('customer_service')}</li>
            <li><a title="" href="/content/faq">{$language->Translate('faq')}</a></li>
            <li><a title="" href="/content/delivery">{$language->Translate('delivery')}</a></li>
            <li><a title="" href="/contacts-us/">{$language->Translate('contact_us')}</a></li>
        </ul>
        <ul class="services">
            <li class="footer-list-title">{$language->Translate('we_accept')}</li>
            <li><img src="/img/visa-mastercard.png" width="140" alt="Мы принимаем Visa"></li>
        </ul>
        <ul class="follow-us">
            <li class="footer-list-title">{$language->Translate('follow_us')}</li>
            <li><a title="Instagram" href="{$insta}" target="_blank">Instagram</a></li>
            <li><a title="Facebook" href="https://www.facebook.com/IQ.INTIMATEQUESTION/" target="_blank">Facebook</a></li>
        </ul>
    </div>
    <div class="footer-newsletter">
        <form name="newsletter-footer" class="newsletter-validate form-vertical">
            <div class="messages hidden">Thank you for your subscription.</div>
            <div class="control-group input-append">
                <label class="control-label" for="newsletter">{$language->Translate('newsletter')}</label>
                <p>{$language->Translate('newsletter_description')}</p>
                <div class="controls">
                    <input type="text" name="email" id="newsletter" placeholder="{$language->Translate('enter_email')}" title="{$language->Translate('enter_email')}" class="check-invalid-data input-large required email" />
                    <button class="btn btn-primary check-invalid-data add-new-email" data-loading-text="..." title="OK" type="button">OK</button>
                    <span class="help-inline"></span>
                </div>
            </div>
        </form>
    </div>
</div>
    <div class="copyright"><span class="copy">&copy; Intimate Question {$currentYear}</span>
    <span class="legals"><a href="http://highweb.com.ua/" target="_blank" >{$language->Translate('developed_hw')} - HW</a></span></div>
</footer>
<div class="bg-grey"></div>
<div id='fb-root'></div>
</div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112014550-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112014550-1');
</script>
<script type='text/javascript'>
(function(){ var widget_id = '7KIRDXQdil';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<!-- Код тега ремаркетинга Google -->
<!--------------------------------------------------
С помощью тега ремаркетинга запрещается собирать информацию, по которой можно идентифицировать личность пользователя. Также запрещается размещать тег на страницах с контентом деликатного характера. Подробнее об этих требованиях и о настройке тега читайте на странице http://google.com/ads/remarketingsetup.
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 816634229;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/816634229/?guid=ON&amp;script=0"/>
</div>
</noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/821413805/?guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>
EOF;

$FooterOld = <<<EOF
<footer id="footer">
        <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="footer-col-1">
                    <p class="strong">Интернет магазин компании "Champion Group" <br> 2013-{$currentYear}</p>
                    <br>
                    <p class="strong">График работы Call-центра:</p>
                    <p>Пн-Пт с 8:00 до 20:00</p>
                    <p>Сб-Вс с 9:00 до 18:00</p>
                    <p class="strong">Наши контакты:</p>
                    <p>+38 (048) 736 26 49</p>
                </div>
            </div>
            <div class="col-md-2">
                <ul class="footer-links-ul">
                    <li class="footer-link-li"><a href="/delivery/">Доставка и оплата</a></li>
                    <li class="footer-link-li"><a href="/contacts/">Обратная связь</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2">
                <ul class="footer-links-ul">
                    <li class="footer-link-li"><a href="/aboutus/">О нас</a></li>
                    <li class="footer-link-li"><a href="/news/">Новости</a></li>
                    <li class="footer-link-li"><a href="/faq/">FAQ</a></li>
                    <li class="footer-link-li"><a href="/contacts/">Контакты</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <p class="strong">Подпишитесь и получайте новости об акциях и выгодных предложениях</p>
                <div class="footer-subscribe">
                    <input type="text" placeholder="Введите e-mail" class="design-input" id="subscribe-email">
                    <button id="subscribe-btn" class="btn btn-info">Подписаться</button>
                </div>
                <div class="social-links">
                    <div class="social">
                        <a href="https://www.facebook.com/%D0%A0%D0%B5%D0%BA%D0%BB%D0%B0%D0%BC%D0%BD%D0%BE%D0%B5-%D0%B0%D0%B3%D0%B5%D0%BD%D1%82%D1%81%D1%82%D0%B2%D0%BE-%D0%A7%D0%B5%D0%BC%D0%BF%D0%B8%D0%BE%D0%BD-437677686285200/"><span class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></span></a>
                        <a href="http://www.google.com/"><span class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></span></a>
                        <a href="https://www.instagram.com/groupchampion/"><span class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span></a>
                        <a href="https://vk.com/ra_chempion_group"><span class="vk"><i class="fa fa-vk" aria-hidden="true"></i></span></a>
                        <a href="https://twitter.com/ChempionGroup"><span class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="pay-type-footer">
                    <img src="/Images/Home/visa.svg" alt="Мы принимаем Visa">
                    <img src="/Images/Home/mastercard.svg" alt="Мы принимаем Master Card">
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
</body>
</html>

<div class="product_img_container mobile">
                    <div class="product-media">

                        <div class="simple price_label_300887 price-label">

                        </div>

                        <div class="simple price_label_300885 price-label hidden">

                        </div>

                        <div class="product-img">
                            <div id="product_slider" class="swiper-container product-img-slider swiper-container-horizontal" data-product-image-slide="swiper" data-slides-per-view="1">
                                <a class="prev" href="#"><span>prev</span></a>
                                
                                <a class="next" href="#"><span>Next</span></a>
                            </div>
                        </div>
                    </div>
                </div> 
EOF;

BF::IncludeScripts([
    "jquery/jquery-3.1.0.min",
    "owl/owl.carousel",
    "bootstrap-3.3.7/js/bootstrap",
    "core/bootbox.min",
    "core/ui-slider",
    "swiper/js/swiper",
    "numeral",
    "core/core"
]);

print($script);

print($Footer);
