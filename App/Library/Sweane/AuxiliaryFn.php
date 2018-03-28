<?php
/**
 * Created by PhpStorm.
 * User: Change World
 * Date: 30.01.2017
 * Time: 19:28
 */
class AuxiliaryFn
{
    protected $statusText = array();

    public function AddStatus($text)
    {
        $this->statusText[] = $text;
    }

    public function GetStatus()
    {
        return var_dump($this->statusText);
    }

    public static function StylePrint($data)
    {
        echo "<pre style='z-index: 99999; position: relative;'>";
        echo var_dump($data);
        echo "</pre>";
    }

    public function JustText($text)
    {
        $text = strtr($text, [
            "/" => "",
            "\\" => ""
        ]);

        return $text;
    }

    public function ExplodeParams($link)
    {
        $paramsBase = explode("&", $link);
        $paramsFinal = [];

        foreach($paramsBase as $value)
        {
            $paramsUnSet = explode("=", $value);
            $paramsFinal[$paramsUnSet[0]] = $paramsUnSet[1];
        }
        return $paramsFinal;
    }

    public function CheckNull($value, $default = null)
    {
        if(isset($value))
        {
            return $value;
        }
        else if(isset($default))
        {
            return $default;
        }
        return false;
    }
    //( ( ( Функция для выдачи массива со значениями исходя из ссылки ) ) )

    public static function CheckAndRequire($pathToFile)
    {
        if(file_exists($pathToFile))
        {
            require_once($pathToFile);
            return true;
        }

        return false;
    }

    public static function ArrayToSelect($data, $classSelect, $idOption, $textOption, $nameFirstOption, $default = null)
    {
        $option = "";

        foreach($data as $key => $value)
        {
            $id = $value[$idOption];
            $text = $value[$textOption];

            if($id == $default)
            {
                $option .= "<option value='{$id}' selected>{$text}</option>";
            }
            else
            {
                $option .= "<option value='{$id}'>{$text}</option>";
            }
        }

        $select = "<select class='{$classSelect}' name='select'><option value='0'>{$nameFirstOption}</option>" . $option . "</select>";

        return $select;
    }

    public static function ArrayToSelectSimple($data, $classSelect, $nameFirstOption, $default = null)
    {
        $option = '';

        foreach ($data as $key => $value)
        {
            if($key == $default)
            {
                $option .= '<option value="' . $key . '" selected>' . $value . '</option>';
            }
            else
            {
                $option .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }

        $select = '<select class="' . $classSelect . '" style="margin-bottom: 10px;"><option value="null">' . $nameFirstOption . '</option>' . $option . '</select>';

        return $select;
    }

    public static function PaginationGenerate($tableName, $countList, $linkData, $thisOffset = null)
    {
        $countAll = count($tableName);

        $countLink = $countAll / $countList;

        if( (is_float($countLink)) && ($countLink - intval($countLink)) < 0)
        {
            $countLink += 1;
        }

        $links = '<ul class="pagination-carrot">';

        for($i = 0; $i < $countLink; $i++)
        {
            if($i * $countList == $thisOffset)
            {
                $links .= "<li class='active'><a href='" . $linkData . ($i * $countList) . "'>" . ($i + 1) . "</a></li>";
            }
            else
            {
                $links .= "<li><a href='" . $linkData . ($i * $countList) . "'>" . ($i + 1) . "</a></li>";
            }
        }

        $links .= '</ul>';

        $result["countAll"] = $countAll;
        $result["pagination"] = $links;

        return $result;
    }
}