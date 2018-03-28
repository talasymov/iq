<?php
class CategoryModel
{
    public function GetData($params = null)
    {
        $listVar = BF::ClearCode("listVar", "str", "get");
        $listPrice = BF::ClearCode("listPrice", "str", "get");
        $sortProducts = BF::ClearCode("sortProducts", "str", "get");
        $listCount = BF::ClearCode("listCount", "int", "get");
        $view = BF::ClearCode("view", "str", "get");

        if(!$listCount)
        {
            $listCount = 20;
        }

        if($listVar || $listPrice || $sortProducts || $view)
        {
            if($listVar)
            {
                $listVar = 'AND cOutput_id_Value IN ('.$listVar.')';
            }
            else
            {
                $listVar = '';
            }

            if($listPrice)
            {
                $explodePrice = explode(",", $listPrice);

                $priceStart = intval($explodePrice[0]);
                $priceEnd = intval($explodePrice[1]);

                if($priceStart == 0)
                {
                    $priceStart = 0;
                }

                if($priceEnd == 0)
                {
                    $priceEnd = 9999999;
                }

                $listPrice = ' AND (Products.ProductPrice BETWEEN ' . $priceStart . ' AND  ' . $priceEnd . ')';
            }

            if($sortProducts)
            {
                if($sortProducts == 2)
                {
                    $sortProducts = " ORDER BY ProductPrice ";
                }
                else if($sortProducts == 3)
                {
                    $sortProducts = " ORDER BY ProductPrice DESC ";
                }
                else if($sortProducts == 4)
                {
                    $sortProducts = " ORDER BY ID_product DESC ";
                }
                else
                {
                    $sortProducts = " ORDER BY ProductRating DESC ";
                }
            }
            else
            {
                $sortProducts = "";
            }

            $products["products"] = R::getAll("SELECT *  FROM Products

            LEFT JOIN CharacteristicsOutput ON CharacteristicsOutput.cOutput_id_Product = Products.ID_product

            WHERE cOutput_id_SubCategory = ? " . $listVar . " " . $listPrice . "

            GROUP BY Products.ID_product " . $sortProducts . " ORDER BY ProductPosition LIMIT ?, ?", [
                BF::ClearCode($params["child"], "int"),
                BF::ClearCode($params["arguments"]["start"], "int"),
                $listCount
            ]);

            $productsCount = R::getAll("SELECT *  FROM Products

            LEFT JOIN CharacteristicsOutput ON CharacteristicsOutput.cOutput_id_Product = Products.ID_product

            WHERE cOutput_id_SubCategory = ? " . $listVar . " " . $listPrice . "

            GROUP BY Products.ID_product " . $sortProducts, [
                BF::ClearCode($params["child"], "int")
            ]);

            $arrayLink = AuxiliaryFn::PaginationGenerate($productsCount,
                $listCount,
                "/category/" . BF::ClearCode($params["child"], "int") . "?listVar=" . BF::ClearCode("listVar", "str", "get") . "&sortProducts=" . BF::ClearCode("sortProducts", "str", "get") . "&listPrice=" . BF::ClearCode("listPrice", "str", "get") . "&listCount=" . $listCount . "&start=", BF::ClearCode($params["arguments"]["start"], "int"));
        }
        else
        {
            $products["products"] = R::getAll("SELECT * FROM Products
            
            INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory
            
            WHERE ProductCategory = ? ORDER BY ProductPosition LIMIT ?, ?", [
                BF::ClearCode($params["child"], "int"),
                BF::ClearCode($params["arguments"]["start"], "int"),
                $listCount
            ]);

            $productsCount = R::getAll("SELECT * FROM Products
            
            INNER JOIN Categories ON Categories.Categories_id = Products.ProductCategory
            
            WHERE ProductCategory = ?", [
                BF::ClearCode($params["child"], "int")
            ]);

            $arrayLink = AuxiliaryFn::PaginationGenerate($productsCount, $listCount, "/category/" . BF::ClearCode($params["child"], "int") . "?start=", BF::ClearCode($params["arguments"]["start"], "int"));
        }

        $products["links"] = $arrayLink["pagination"];

        $filter = R::getAll("SELECT * FROM CharacteristicsSchema
        WHERE cSchema_Category_FK = ?", [BF::ClearCode($params["child"], "int")]);

        $subFilter = [];

        foreach ($filter as $value)
        {
            $subFilter[$value["cSchema_Name"]] = R::getAll("SELECT * FROM CharacteristicsValue
            WHERE cValueSchema_FK = ?", [BF::ClearCode($value["ID_cSchema"], "int")]);
        }

        $data["products"] = $products;
        $data["view"] = $view;
        $data["filters"] = $subFilter;
        $data["listVar"] = explode(",", BF::ClearCode("listVar", "str", "get"));
        $data["categoryId"] = BF::ClearCode($params["child"], "int");
        $data["categoryInfo"] = R::getRow("SELECT * FROM Categories WHERE Categories_id = ?", [
            BF::ClearCode($params["child"], "int")
        ]);
        $data["categoryData"] = R::getAll("SELECT * FROM Categories WHERE Categories_parent = ?", [
            BF::ClearCode($params["child"], "int")
        ]);

        return $data;
    }
}