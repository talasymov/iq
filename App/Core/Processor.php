<?php
require_once("../config/define.php");

class Processor
{
  public function GetThisCommand($command)
  {
    switch($command)
    {
      case("showMyName"):
        require_once(DIR_AJAX . "Hello.php");
        InitHere();
        break;
      default:
        return ;
        break;
    }

  }
}

$processor = new Processor();

$processor->GetThisCommand($_GET["command"]);