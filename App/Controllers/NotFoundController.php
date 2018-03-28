<?php
class NotFoundController extends Controller
{
    public function IndexAction($params = null)
    {
        $this->view->GetTemplate("DefaultPage.php", "NotFoundView.php");

//        var_dump(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    }
}