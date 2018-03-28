<?php
class UserMainModel extends Model
{
    public function GetData($params = null)
    {
        return true;
    }

    public function GetInformation($params = null)
    {
        return true;
    }

    public function GetNews($params = null)
    {
        return R::getAll("SELECT * FROM Products
        
        INNER JOIN Orders ON Orders.Orders_id_product = Products.ID_product
        
        INNER JOIN OrdersGroup ON OrdersGroup.OrdersGroup_id = Orders.Orders_id_group
        
        LEFT JOIN Review ON Review.ID_product_FK = Products.ID_product
        
        WHERE OrdersGroup.OrdersGroup_user = ?", [
            BF::ReturnInfoUser(BF::idUser)
        ]);
    }

    public static function GetPartnerInfo()
    {
        $data = R::getRow("SELECT * FROM Partners WHERE Partners_user = ?", [
            BF::ReturnInfoUser(BF::idUser)
        ]);

        if(intval($data["Partners_user"]) > 0)
        {
            return $data;
        }

        return false;
    }
}