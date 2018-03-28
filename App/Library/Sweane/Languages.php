<?php
class Languages
{
    public static function Translate($text, $language = "en")
    {
//        if (BF::ClearCode("language", "str", "cookie") != null) {
//            $language = BF::ClearCode("language", "str", "cookie");
//        }
        if (USER_LANG != null) {
            $language = str_replace('_', '', USER_LANG);
        }

        $translator = [];

        if (file_exists(DIR_APP . "Languages/Carrot" . strtoupper($language) . ".php")) {
            include DIR_APP . "Languages/Carrot" . strtoupper($language) . ".php";

            if (array_key_exists($text, $translator)) {
                return $translator[$text];
            }

        }

        return $text;

    }

    public static function LanguageSwitch($class)
    {
        $language = new Languages();

        $html = <<<EOF
        <div class="dropdown switch-language {$class}">
          <button class="login-button clear-button" type="button" data-toggle="dropdown">
          <i class="fa fa-globe" aria-hidden="true"></i><span class="text">{$language->ReturnLanguage()}</span>
          <span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right shadow-none">
            <li><a href="#" data-lang="ru">{$language->Translate("lang_ru")}</a></li>
            <li><a href="#" data-lang="ua">{$language->Translate("lang_ua")}</a></li>
            <li><a href="#" data-lang="bg">{$language->Translate("lang_bg")}</a></li>
            <li><a href="#" data-lang="en">{$language->Translate("lang_en")}</a></li>
          </ul>
        </div>
EOF;
        return $html;
    }

    public static function ReturnLanguage()
    {
        if(!BF::ClearCode("language", "str", "cookie"))
        {
            return "ru";
        }

        return BF::ClearCode("language", "str", "cookie");
    }
}