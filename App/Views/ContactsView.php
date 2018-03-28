<?php
IncludesFn::printHeader("Contacts Us", "contacts grey");

$language = new Languages;

$page = R::getRow("SELECT * FROM News WHERE news_id = 7");

$content = html_entity_decode($page["news_content" . USER_LANG]);

$bodyText = <<<EOF
<div class="page-header-iq">
    <h1>{$language->Translate('contact_us')}</h1>
</div>
<br />
<div id="ind-order" class="clearfix">
    <div class="form-order">
        {$content}
    </div>
    <div class="video">
        <img src="{$page["news_img"]}" class="width-100" alt="">
    </div>
</div>
<div class="contact-form">
    <h2 class="ta-c">{$language->Translate('contact_form')}</h2>
    <br />
    <div class="input ind-input">
        <label class="label required">{$language->Translate('contact_name')}<em>*</em></label>
        <input type="text" placeholder="{$language->Translate('contact_name')}" maxlength="255" class="check-invalid-data cont-name required">
        <span class="help-inline input-message"></span>
    </div>
    <div class="input ind-input">
        <label class="label required">{$language->Translate('contact_email')}<em>*</em></label>
        <input type="text" placeholder="{$language->Translate('contact_email')}" maxlength="255" class="check-invalid-data cont-email required">
        <span class="help-inline input-message"></span>
    </div>
    <div class="textarea ind-textarea">
        <label class="label required">{$language->Translate('contact_enquiry')}<em>*</em></label>
        <textarea type="text" placeholder="{$language->Translate('contact_enquiry')}" class="cont-enquiry check-invalid-data required"></textarea>
        <span class="help-inline input-message"></span>
    </div>
    <div class="cart">
        <button class="btn btn-checkout send-form-contact btn-express btn-primary">{$language->Translate('contact_submit')}</button> <div class="message">{$language->Translate('contact_thanks')}</div>
    </div>
</div>
EOF;

$bodyTextOld = <<<EOF
<h1>Контакты</h1><br />
<h4><span class="color-text"><i class="fa fa-phone" aria-hidden="true"></i></span> Консультации и заказ по телефонам</h4>
<table class="table">
    <tr>
        <td>
            <p class="strong">093 257 22 84<br />
            093 257 22 84<br />
            093 257 22 84<br />
            093 257 22 84<br />
            093 257 22 84</p>
            <span class="color-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span> 7362649@urk.net
        </td>
        <td>
            <p class="strong">График работы колл-центра:</p>
            <p><span class="color-text">с 8:00 до 19:00</span></p>
            <p>СБ с 9:00 до 19:00<br />
            ВС с 10:00 до 18:00</p>
        </td>
    </tr>
</table>
<h4><span class="color-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span> Адрес офиса</h4>
г. Одесса, ул. Новосельского, 5/3<br /><br />
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1154.8662187674126!2d30.72087051813547!3d46.493257603004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c631c3cc8646ed%3A0x7395b1e4b57ad3fa!2z0JrQvdGP0LfRltCy0YHRjNC60LAg0LLRg9C70LjRhtGPLCAzLCDQntC00LXRgdCwLCDQntC00LXRgdGM0LrQsCDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1sru!2sua!4v1474041424305" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
EOF;
