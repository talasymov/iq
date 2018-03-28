<?php
Dashboard::printHeader("News", "grey");

if($data["news_id"] == 7)
{
    $photo = <<<EOF
<tr>
    <td><span class="header-blue">Фото</span></td>
    <td>
        <div class="slct-modal-div-image">
            <img src="{$data["news_img"]}">
            <span class="slct-name"><i class="fa fa-camera" aria-hidden="true"></i></span>
            <button class="clear-button news-image" data-url="{$data["news_img"]}"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
        </div>
    </td>
</tr>
EOF;
}

$lang = 'Английский';
$title = $data["news_title"];
$content = $data["news_content"];
$description = $data["news_description"];

if($data["lang"] == "ru")
{
    $lang = 'Русский';
    $title = $data["news_title_ru"];
    $content = $data["news_content_ru"];
    $description = $data["news_description_ru"];
//    $id = "-ru";
}

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>Редактирование страницы</h1>
                <button class="btn btn-default edit-news circle" data-lang="{$data["lang"]}" data-id="{$data["news_id"]}" data-toggle="tooltip" data-placement="left" data-original-title="Сохранить изменения"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="one-tab tab-1 view">
            <table>
                <tr>
                    <td><span class="header-blue">Язык</span></td>
                    <td><p style="padding: 10px 0;font-weight: bold;margin-bottom: 0;">{$lang}</p></td>  
                </tr>
                <tr>
                    <td><span class="header-blue">Заголовок</span></td>
                    <td><input class="news-name design-input" value="{$title}"></td>
                </tr>
                {$photo}
                <tr> 
                    <td><span class="header-blue">Контент</span></td>
                    <td><textarea id="text-content{$id}">{$content}</textarea></td>
                </tr>
                <tr>
                    <td><span class="header-blue">Описание</span></td>
                    <td><textarea class="news-desc design-textarea">{$description}</textarea></td>
                </tr>
                <tr> 
                    <td><span class="header-blue">Ключевые слова</span><span>Через запятую</span></td>
                    <td><textarea class="news-keywords design-textarea">{$data["news_keywords"]}</textarea></td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<!--<button class="edit-news btn btn-success">-->
<!--<i class="fa fa-check" aria-hidden="true"></i>-->
<!--Сохранить изменения-->
<!--</button>-->
<!--<button class="delete-news btn btn-danger">-->
<!--<i class="fa fa-times" aria-hidden="true"></i>-->
<!--Удалить новость-->
<!--</button>-->
EOF;

$script = <<<EOF
<script src="/Libs/FrontEnd/ckeditor/ckeditor.js"></script>
<script src="/Libs/FrontEnd/core/admin.js"></script>
EOF;

