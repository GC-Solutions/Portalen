<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Images extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    // Get all Images
    public static function getAllImages()
    {
        $db = static::getDB();
        $sql = "SELECT * FROM Images";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

     // Get Specific  Images
    public static function getImages($id)
    {
        $db = static::getDB();
        $sql = "SELECT * FROM Images where ID = '".$id."'";

        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        return $data;
    }

    //  Save  Or edit  Images
    public static function saveImages()
    {
        $db = static::getDB();

        if (isset($_REQUEST['ID']) && !empty($_REQUEST['ID'])) {
           
            $sql = "UPDATE AdminDB SET Name = :Name , CompanyName = :CompanyName , UserName = :UserName, ImageName = :ImageName   WHERE ID= :ID";
            
            $stmt = $db->prepare($sql);
           $Imagepath= '';
            if(!empty($_FILES)){
                $Image=$_FILES['ImagePath']['name']; 
                $expImg=explode('.',$Image);
                $imgexptype=$expImg[1];
                 
                $Imagename=$_REQUEST['ImageName'].'.'.$imgexptype;
                $Imagepath= $CompanyUserDir.$Imagename;
                move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$Imagepath);
             }
            $_REQUEST['ImagePath'] = $Imagepath;
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':CompanyName', $_REQUEST['CompanyName'], PDO::PARAM_STR);
            $stmt->bindParam(':UserName', $_REQUEST['UserName'], PDO::PARAM_STR);
             $stmt->bindParam(':ImageName', $_REQUEST['ImageName'], PDO::PARAM_STR);
            //$stmt->bindParam(':ImagePath', $_REQUEST['ImagePath'], PDO::PARAM_STR);

            $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);

            $stmt->execute();

        }else{

            $sql = "INSERT INTO Images(Name, CompanyName, UserName, ImageName , ImagePath) VALUES (:Name, :CompanyName,  :UserName , :ImageName, :ImagePath)";

            
            $stmt = $db->prepare($sql);

            $CompanyId = explode('-', $_REQUEST['CompanyName']);
            $dir = dirname( __FILE__ );
           
            if(baseUrl == 'http://www.babcnew.com/')
            {
                $dir = explode('BP', $dir);
            }else{
                $dir = explode('bpu', $dir);
            }

            $CompanyDir = $dir[0].'API-IMG/'.trim($CompanyId[1]).'/';
            $CompanyUserDir = $dir[0].'API-IMG/'.trim($CompanyId[1]).'/'.$_REQUEST['UserName'].'/';
         
            if( is_dir($CompanyDir) === false )
            {
               
                mkdir($CompanyDir);
            }
            if(is_dir($CompanyUserDir) === false){
                mkdir($CompanyUserDir);
            }
            $Imagepath= '';
            if(!empty($_FILES)){
                $Image=$_FILES['ImagePath']['name']; 
                $expImg=explode('.',$Image);
                $imgexptype=$expImg[1];
                 
                $Imagename=$_REQUEST['ImageName'].'.'.$imgexptype;
                $Imagepath= $CompanyUserDir.$Imagename;
                move_uploaded_file($_FILES["ImagePath"]["tmp_name"],$Imagepath);
             }
            $_REQUEST['ImagePath'] = $Imagepath;
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':CompanyName', $_REQUEST['CompanyName'], PDO::PARAM_STR);
            $stmt->bindParam(':UserName', $_REQUEST['UserName'], PDO::PARAM_STR);
             $stmt->bindParam(':ImageName', $_REQUEST['ImageName'], PDO::PARAM_STR);
            $stmt->bindParam(':ImagePath', $_REQUEST['ImagePath'], PDO::PARAM_STR);
           
            $stmt->execute();
           
        }
        return;
    }

    // Delete 
    public static function deleteImage($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM Images WHERE ID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
}