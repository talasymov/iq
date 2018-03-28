<?php
class ProductModel extends Model
{
    public function GetData($params = null)
    {
        $product = R::getRow("SELECT * FROM Products
        
        WHERE ID_product = ?
        
        GROUP BY Products.ID_product", [BF::ClearCode($params["child"], "int")]);

        $data["product"] = $product;
        $data["rating"] = ShopFn::GetRatingProduct(BF::ClearCode($params["child"], "int"));
        $data["characteristics"] = $this->GetCharacteristics($product["ID_product"]);
        $data["characteristicsValue"] = $this->GetCharacteristicsValue($product["ID_product"]);
        $data["reviews"] = $this->GetReviews($product["ID_product"]);
        $data["reviewsLast"] = $this->GetReviewsLast($product["ID_product"]);
        $data["reviewsCount"] = count($this->GetReviewsLast($product["ID_product"]));
        $data["similarProducts"] = $this->GetSimilarReviews($product["ProductCategory_FK"]);

        return $data;
    }

    public static function GetCharacteristics($idProduct)
    {
        return R::getAll("SELECT * FROM CharacteristicsOutput

        INNER JOIN CharacteristicsSchema ON CharacteristicsSchema.ID_cSchema = CharacteristicsOutput.cOutput_id_Schema
        
        INNER JOIN CharacteristicsValue ON CharacteristicsValue.ID_cValue = CharacteristicsOutput.cOutput_id_Value
        
        WHERE CharacteristicsOutput.cOutput_id_Product = ?", [$idProduct]);
    }

    public static function GetCharacteristicsValue($idProduct)
    {
        return R::getAll("SELECT * FROM CharacteristicsOutput

        INNER JOIN CharacteristicsSchema ON CharacteristicsSchema.ID_cSchema = CharacteristicsOutput.cOutput_id_Schema

        WHERE CharacteristicsOutput.cOutput_id_Product = ? AND CharacteristicsOutput.cOutput_Value IS NOT NULL", [$idProduct]);
    }

    public static function GetReviewsLast($idProduct)
    {
        $reviews = R::getAll("SELECT * FROM Review

        INNER JOIN Users ON Users.Users_id = Review.ID_user_FK
        
        WHERE ID_product_FK = ? ORDER BY ID_review DESC LIMIT 3", [$idProduct]);

        return $reviews;
    }

    public static function GetReviews($idProduct)
    {
        $reviews = R::getAll("SELECT * FROM Review

        INNER JOIN Users ON Users.Users_id = Review.ID_user_FK
        
        WHERE ID_product_FK = ? ORDER BY ID_review DESC", [$idProduct]);

        return $reviews;
    }

    public static function GetSimilarReviews($idCategory)
    {
        $products = R::getAll("SELECT * FROM Products
        
        WHERE ProductCategory = ?
        
        GROUP BY Products.ID_product", [$idCategory]);

        return $products;
    }
}