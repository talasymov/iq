<?php
class RequestsModel extends Model
{
  public function GetData($command = null)
  {
        switch($command["arguments"]["command"])
        {
            case("Dispatcher"):
              require_once(DIR_AJAX . "Dispatcher.php");
              return InitHere(BF::ClearCode("query", "str", "post"));
            case("command=checkUserInSystem"):
              require_once(DIR_AJAX . "CheckUserInSystem.php");
              return InitHere();
            case("command=searchArticles"):
              require_once(DIR_AJAX . "searchArticles.php");
              return InitHere(BF::ClearCode("query", "str", "post"));
            case("command=QuitFromSystem"):
              require_once(DIR_AJAX . "QuitFromSystem.php");
              return InitHere();
            case("command=Tasks"):
              require_once(DIR_AJAX . "Tasks.php");
              return InitHere(BF::ClearCode("query", "str", "post"));
            default:
              return "Default value";
              break;
        }
    }
}
