<?php
class DataBase
{
    /*
     * Header
     */
    public static function GetMenu()
    {
        return R::getAll("SELECT * FROM Header");
    }
    public static function GetContacts()
    {
        return R::getAll("SELECT * FROM Phones");
    }
    public static function GetShares()
    {
        return R::getAll("SELECT * FROM Shares WHERE shares_view = 1 AND shares_category = 0");
    }
    public static function GetRootCategory()
    {
        return R::getAll("SELECT * FROM Categories WHERE Categories_parent = 0");
    }
    public static function GetPopularProducts()
    {
        return R::getAll("SELECT * FROM Products WHERE ProductPopular = 1 LIMIT 8");
    }
    public static function GetLastProducts()
    {
        return R::getAll("SELECT * FROM Products ORDER BY ProductAddDate DESC LIMIT 8");
    }
    public static function GetSalesProducts()
    {
        return R::getAll("SELECT * FROM Products WHERE ProductLastPrice <> 0 LIMIT 8");
    }
    public static function GetViewedProducts()
    {
        $prepare = [];

        foreach (ShopFn::GetIdFromViewed() as $key => $product)
        {
            if($key != null)
            {
                $prepare[$key] = R::getRow("SELECT * FROM Products WHERE ID_product = ?", [
                    intval($key)
                ]);
            }
        }

        return $prepare;
    }
    public static function GetNews()
    {
        return R::getAll("SELECT * FROM News ORDER BY news_id DESC LIMIT 3");
    }
}