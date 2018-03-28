<?php
class CategoryController extends Controller
{
    public function IndexAction($params = null)
    {
        $data = $this->model->GetData($params);

        $this->view->GetTemplate("DefaultPage.php", "CategoryView.php", $data);
    }
}