<?php
Dashboard::printHeader("Настройки", "grey");

//$data = R::getAll("SELECT * FROM Settings");
$data = R::getRow("SELECT * FROM Settings WHERE Settings_id = 1");

$dataJson = json_decode($data["Settings_json"]);
//
//$dataGenerate = [];
//
//foreach ($data as $key => $item)
//{
//    $dataGenerate[$item["Settings_id"]] = $item["Settings_value"];
//}

//AuxiliaryFn::StylePrint($dataJson);

$constansData = R::getAll("SELECT * FROM ConstantData");

$tr = "";

foreach ($constansData as $item)
{
    $tr .= <<<EOF
<tr>
    <th><strong class="header-blue">Имя</strong></th>
    <th><strong class="header-blue">Данные</strong></th>
    <th><strong class="header-blue">Управление</strong></th>
</tr>
<tr>
    <td>
        <div class="d-ib f-l" style="padding: 10px;">EN: </div><input class="const-name list-data design-input" value="{$item["ConstantData_name"]}" /><br />
        <div class="d-ib f-l" style="padding: 10px;">RU: </div><input class="const-name-ru list-data design-input" value="{$item["ConstantData_name_ru"]}" />
    </td>
    <td>
        EN: <textarea class="const-content list-data design-textarea">{$item["ConstantData_data"]}</textarea>
        RU: <textarea class="const-content-ru list-data design-textarea">{$item["ConstantData_data_ru"]}</textarea>
    </td>
    <td>
        <button class="btn btn-default edit-constant circle" data-id="{$item["ConstantData_id"]}" data-toggle="tooltip" data-placement="left" data-original-title="Сохранить изменения"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
    </td>
</tr>
EOF;
}

$currency = R::getAll("SELECT * FROM Currency");

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>Настройки</h1>
                <button class="btn btn-default edit-settings circle" data-toggle="tooltip" data-placement="left" data-original-title="Сохранить изменения"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-product">
                <ul class="tab-manager">
                    <li data-class="1" class="active">Основные настройки</li>
                    <li data-class="2" class="">Константы</li>
                    <li data-class="3" class="">Новая константа</li>
                    <li data-class="4" class="">Курс</li>
                </ul>
            </div>
            <div class="one-tab tab-1 view">
            <table>
                <tr>
                    <td><span class="header-blue">SEO Title на главной</span></td>
                    <td><textarea class="data-title list-data design-textarea" data-name="seoTitle">{$dataJson->seoTitle}</textarea></td>
                </tr>
                <tr>
                    <td><span class="header-blue">SEO Описание на главной</span></td>
                    <td><textarea class="data-desc list-data design-textarea" data-name="seoDescription">{$dataJson->seoDescription}</textarea></td>
                </tr>
                <tr> 
                    <td><span class="header-blue">SEO Ключевые слова на главной</span><span>Через запятую</span></td>
                    <td><textarea class="data-keywords list-data design-textarea"  data-name="seoKeywords">{$dataJson->seoKeywords}</textarea></td>
                </tr>
                <tr> 
                    <td><span class="header-blue">Почта для уведомлений</span><span>Через запятую</span></td>
                    <td><input class="data-email-admin list-data design-input" data-name="emailAdmin" value="{$dataJson->emailAdmin}"></td>
                </tr>
            </table>
            </div>
            <div class="one-tab tab-2 ">
            <table>
                {$tr}
            </table>
            </div>
            <div class="one-tab tab-3 ">
                <table>
                    <tr>
                        <th><strong class="header-blue">Название</strong></th>
                        <th><strong class="header-blue">Имя</strong></th>
                        <th><strong class="header-blue">Данные</strong></th>
                    </tr>
                    <tr>
                        <td>
                            <span class="header-blue">Новая константа</span>
                            <button class="btn btn-success add-const-data">Создать константу</button>
                        </td>
                        <td><input class="data-const-name list-data design-input" /></td>
                        <td><textarea class="data-const-content list-data design-textarea"></textarea></td>
                    </tr>
                </table>
            </div>
            <div class="one-tab tab-4 ">
                <table>
                    <tr>
                        <th><strong class="header-blue">Валюта</strong></th>
                        <th><strong class="header-blue">Значение</strong></th>
                        <th><strong class="header-blue">Символ слева</strong></th>
                        <th><strong class="header-blue">Символ справа</strong></th>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-ib f-l" style="padding: 10px;">Рубль</div>
                        </td>
                        <td><input class="data-money-ru design-input" value="{$currency[1]['Currency_value']}" /></td>
                        <td><input class="data-money-left-ru design-input" value="{$currency[1]['Currency_symbol_left']}" /></td>
                        <td><input class="data-money-right-ru design-input" value="{$currency[1]['Currency_symbol_right']}" /></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-ib f-l" style="padding: 10px;">Гривна</div>
                        </td>
                        <td><input class="data-money-ua design-input" value="{$currency[0]['Currency_value']}" /></td>
                        <td><input class="data-money-left-ua design-input" value="{$currency[0]['Currency_symbol_left']}" /></td>
                        <td><input class="data-money-right-ua design-input" value="{$currency[0]['Currency_symbol_right']}" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-success save-money-currency">Сохранить курс</button>
                        </td>
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
<!--<script src="/Libs/FrontEnd/ckeditor/ckeditor.js"></script>-->
<!--<script src="/Libs/FrontEnd/core/admin.js"></script>-->
EOF;

