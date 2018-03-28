<?php
class TableCreator
{
    /**
     * @param $params
     * Рисование таблицы, с входящими параметрами (заголовки, элементы и т.д.)
     */
    public static function DrawTable($params)
    {
        $debugMode = AuxiliaryFn::CheckNull($params["debug"]); //Check DebugMode On OR Off
        $searchMode = AuxiliaryFn::CheckNull($params["search"]); //Check SearchMode On OR Off
        $paginationMode = AuxiliaryFn::CheckNull($params["pagination"]); //Check PaginationMode On OR Off

        $sql = $params["sql"];
        $nameTable = $params["nameTable"];
        $nameTableAlias = $params["nameTableAlias"];
        $shell = AuxiliaryFn::CheckNull($params["shell"]); //Check SearchMode On OR Off

        $th = '';
        $tr = '';
        $a = '';
        $paginationDiv = "";

        if($paginationMode)
        {
            $countOnPage = BF::ClearCode($params["pagination"]["count"], "int");
            $thisPaginationPage = $params["pagination"]["this"];
            $thisPaginationNum = $params["pagination"]["this"] / $countOnPage;
            $sqlPagination = " LIMIT {$thisPaginationPage}, {$countOnPage}";

            $sql = $params["sql"];

            $data = R::getALL($sql);

            $countRows = count($data);

            $countPages = $countRows / $countOnPage;

            if(isset($params["pagination"]))
            {
                $sql = $params["sql"] . $sqlPagination;
            }

            if(is_float($countPages))
            {
                $countPages = intval($countPages) + 1;
            }

            //Create Pagination
            for ($i = 0; $i < $countPages; $i++)
            {
                $url = AuxiliaryFn::CheckUriParams("start=", $thisPaginationPage, $i * $countOnPage);

                if($i == 0)
                {
                    $a .= "<li><a href='{$url}'><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i></a></li>";
                }

                if($i > $thisPaginationNum - 10 && $i < $thisPaginationNum + 10)
                {
                    if($i * $countOnPage == $thisPaginationPage)
                    {
                        $a .= "<li class='active'><a href='{$url}'>{$i}</a></li>";
                    }
                    else
                    {
                        $a .= "<li><a href='{$url}'>{$i}</a></li>";
                    }
                }

                if($i == $countPages - 1)
                {
                    $a .= "<li><a href='{$url}'><i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a></li>";
                }
            }

            $paginationDiv = <<<EOF
            <ul class="pagination">
                {$a}
            </ul>
EOF;
        }

        $data = R::getALL($sql);

        $header = $params["header"];

        foreach ($header as $key => $value) {
            if(strpos($key, "none") === 0)
            {
                $th .= '<th></th>';
            }
            else
            {
                $key = Languages::Translate($key);

                $th .= '<th>' . $key . '</th>';
            }
        }

        foreach ($data as $key => $value) {
            $td = '';

            foreach ($header as $subkey => $subvalue)
            {
                if ($subvalue == "sql")
                {
                    $td .= '<td>' . Languages::Translate($value[$subkey]) . '</td>';
                }
                else
                {
                    if($subvalue["type"] == "button")
                    {
                        $td .= '<td>' . Sweane::GeTElement($subvalue, $value[$subvalue["dataId"]]) . '</td>';
                    }
                    else if($subvalue["type"] == "drop")
                    {
                        $td .= '<td>' . Sweane::GeTElement($subvalue, $value[$subvalue["dataId"]]) . '</td>';
                    }
                }
            }

            $tr .= '<tr>' . $td . '</tr>';
        }
        if($searchMode)
        {
            $input = Sweane::GetElement(["type" => "input", "placeholder" => "Поиск"]);
            $button = Sweane::GetElement([
                "type" => "button",
                "class" => "btn btn-primary table-search-button",
                "icon" => "search",
                "attr" => "data-page='{$nameTableAlias}'"
            ]);

            $search = <<<EOF
        <div class="table-search">
            {$input}
            {$button}
        </div>
EOF;
        }

        if($debugMode)
        {
            $debug = <<<EOF
            <p>
                Info about table:<br />
                Count rows: {$countRows}
            </p>
EOF;
        }

        $out = <<<EOF
        <div class="table-shell">
            {$search}
            {$debug}
            <h3 class="table-header">{$nameTable}</h3>
            <table class="table">
                <thead>
                    <tr>{$th}</tr>
                </thead>
                <tbody>
                    {$tr}
                </tbody>
            </table>
            {$paginationDiv}
        </div>
EOF;
//        if($shell)
//        {
//            $out = <<<EOF
//
//EOF;
//
//        }
        return $out;
    }
}

class Sweane
{
    /**
     * @param $element
     * @param null $params
     * @return string
     * Рисование элементов управления (кнопки, dropdown и т.д.)
     */
    public static function GetElement($element, $params = null)
    {
        $type = $element["type"];
        $parameters = $element["parameters"];
        $value = $element["value"];
        $text = Languages::Translate($element["text"]);
        $class = $element["class"];
        $action = $element["action"];
        $placeholder = $element["placeholder"];
        $attr = $element["attr"];
        $icon = "";

        if($element["icon"])
        {
            $icon = "<i class='fa fa-" . AuxiliaryFn::CheckNull($element["icon"], "cog") . "' aria-hidden='true'></i>";
        }

        if ($type == "drop") {
            return Sweane::$parameters($params);
        } else if ($type == "button") {
            $button = "<button class='{$class} {$action}'  data-id='{$params}' {$attr}>{$text}{$icon}</button>";

            if(is_array($element["link"]))
            {
                $button = "<a href='" . $element["link"]["url"] . $params . "'>$button</a>";
            }

            return $button;
        }
        else if($type == "input")
        {
            return "<input class='form-control' placeholder='{$placeholder}'>";
        }
    }

    /**
     * @param $numLi
     * @return string
     * Функция для вывода выпадающего меню, с иконкой выбранного id
     */
    public static function DropLead($numLi)
    {
        $list = [
            "1" => [
                "icon" => "clock-o",
                "text" => "Не обработан",
                "id" => 1
            ],
            "2" => [
                "icon" => "phone",
                "text" => "Нужно перезвонить",
                "id" => 2
            ],
            "3" => [
                "icon" => "shopping-cart",
                "text" => "Готов к покупке",
                "id" => 3
            ],
            "4" => [
                "type" => "separator"
            ],
            "5" => [
                "icon" => "lightbulb-o",
                "text" => "Заинтерисован",
                "id" => 4
            ],
            "6" => [
                "icon" => "deaf",
                "text" => "Не заинтерисован",
                "id" => 5
            ],
            "7" => [
                "icon" => "times",
                "text" => "Заказ отменен",
                "id" => 6
            ]
        ];

        $li = "";
        $selectLi = "";

        foreach ($list as $key => $value)
        {
            if(isset($value["type"]) && $value["type"] == "separator")
            {
                $li .= '<li role="separator" class="divider"></li>';
            }
            else
            {
                $li .= '<li data-id="' . $value["id"] . '"><a href="#"><span class="status-0">
                    <i class="fa fa-' . $value["icon"] . '" aria-hidden="true"></i>
                    </span> ' . $value["text"] . '</a></li>';
            }

            if($value["id"] == $numLi)
            {
                $selectLi = $value["icon"];
            }
        }

        $return = <<<EOF
        <div class="dropdown status-lead-select">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <span class="status-0">
                <i class="fa fa-$selectLi" aria-hidden="true"></i>
              </span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <a href="#"></a>
              {$li}
            </ul>
        </div>
EOF;

        return $return;
    }
}