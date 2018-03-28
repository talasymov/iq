<?php
class UserMainController extends Controller
{
    public function IndexAction($params = null)
    {
        BF::RedirectUser("login/", 0);

        if(BF::ReturnInfoUser(BF::permissionUser) == 777)
        {
            BF::RedirectUser("dashboard/", 1);
        }

        $command = BF::ClearCode($params["child"], "str");

        if($command == "information")
        {
            $data["user"] = ShopFn::GetUserInfo();
            $data["delivery"] = ShopFn::GetListDelivery();

            $this->view->GetTemplate("UserPage.php", "/User/UserInformationView.php", $data);
        }
        else if($command == "orders")
        {
            $data = ShopFn::GetOrders();

            $this->view->GetTemplate("UserPage.php", "/User/UserOrdersView.php", $data);
        }
        else if($command == "wish")
        {
            $data = $this->model->GetData($params);

            $this->view->GetTemplate("UserPage.php", "/User/UserWishView.php", $data);
        }
        else if($command == "reviews")
        {
            $data = $this->model->GetNews($params);

            $this->view->GetTemplate("UserPage.php", "/User/UserReviewsView.php", $data);
        }
        else if($command == "partner")
        {
            $data = $this->model->GetPartnerInfo();

            $this->view->GetTemplate("UserPage.php", "/User/UserPartnerView.php", $data);
        }
        else if($command == "payment")
        {
            $this->view->GetTemplate("ClearPage.php", "/User/UserPaymentView.php");
        }
        else
        {
            $data = $this->model->GetData($params);

            $this->view->GetTemplate("UserPage.php", "/User/UserMainView.php", $data);
        }
    }

    public function OrdersAction($params = null)
    {
        BF::RedirectUser("login/", 0);

        $data = ShopFn::GetProductsFromOrderGroup(BF::ClearCode($params["child"], "str"));

        $this->view->GetTemplate("UserPage.php", "/User/UserOrderOneView.php", $data);
    }
}