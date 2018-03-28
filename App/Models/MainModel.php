<?php
class MainModel
{
    public function GetData($params = null)
    {
        return true;
    }

    public function GetNews($params = null)
    {
        $result["products"] = R::getAll("SELECT * FROM News LIMIT ?, ?", [
            BF::ClearCode($params["offset"], "int"),
            BF::ClearCode($params["limit"], "int")
        ]);

        $arrayLink = AuxiliaryFn::PaginationGenerate(R::getAll("SELECT * FROM News"), $params["limit"], $params["link"], BF::ClearCode($params["offset"], "int"));

        $result["links"] = $arrayLink["pagination"];

        return  $result;
    }

    public function GetEmails($params = null)
    {
        $result["emails"] = R::getAll("SELECT * FROM Email LIMIT ?, ?", [
            BF::ClearCode($params["offset"], "int"),
            BF::ClearCode($params["limit"], "int")
        ]);

        $arrayLink = AuxiliaryFn::PaginationGenerate(R::getAll("SELECT * FROM Email"), $params["limit"], $params["link"], BF::ClearCode($params["offset"], "int"));

        $result["links"] = $arrayLink["pagination"];

        return  $result;
    }

    public function GetNewsForId($params = null)
    {
        $news = R::getRow("SELECT * FROM News WHERE news_id = ?", [
            $params
        ]);

        return $news;
    }

    public function GetCharacteristicsCategory($params = null)
    {
        $data["values"] = R::getAll("SELECT * FROM CharacteristicsSchema WHERE cSchema_Category_FK = ?", [$params]);

        $data["category"] = $params;

        return $data;
    }

    public function GetCharacteristicsValue($params = null)
    {
        $data["values"] = R::getAll("SELECT * FROM CharacteristicsValue WHERE cValueSchema_FK = ?", [$params]);

        $data["idScheme"] = $params;

        return $data;
    }

    public function GetTaxations()
    {
        return R::getAll("SELECT * FROM Taxation INNER JOIN TaxationTypes ON  Taxation.Taxation_type = TaxationTypes.TaxationTypes_id");
    }

    public function GetCurrency()
    {
        return R::getAll("SELECT * FROM Currency");
    }

    public function GetBanners()
    {
        return R::getAll("SELECT * FROM Shares");
    }

}