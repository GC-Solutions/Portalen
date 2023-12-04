<?php

namespace App\GoogleAPI;

use PDO;

/**
 * Example GoogleAPI model
 *
 * PHP version 7.0
 */
class GoogleAPI extends \Core\Model
{

    //FUnction to Insert an AccessToken for making a connection with Google Api.
    public static function AddAccessToken()
    {
        $db = static::getDB();
        $sql = "INSERT INTO Company(CompanyName,CompanyGISKey,CompanyGISToken,CompanyBABCDb,CompanyBPDb,CompanyStartDate,
                CompanyEndDate,CompanyEmail) VALUES (:CompanyName,:CompanyGISKey,
                :CompanyGISToken,:CompanyBABCDb,:CompanyBPDb,:CompanyStartDate,:CompanyEndDate,:CompanyEmail)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':CompanyName', $_REQUEST['CompanyName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISKey', $_REQUEST['CompanyGISKey'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISToken', $_REQUEST['CompanyGISToken'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBABCDb', $_REQUEST['CompanyBABCDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBPDb', $_REQUEST['CompanyBPDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyStartDate', $_REQUEST['CompanyStartDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEndDate', $_REQUEST['CompanyEndDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEmail', $_REQUEST['CompanyEmail'], PDO::PARAM_STR);
        $stmt->execute();
        return;
    }

}
