<?php
class Elements
{
    public static function Button($text, $class = null, $id = null, $icon = null)
    {
        $text = Languages::Translate($text);

        return "<button id='$id' class='$class'>$text $icon</button>";
    }
}