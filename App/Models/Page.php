<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Page extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function deletePageAccess($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM UserPageAccess WHERE ID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }

    public static function getCustomVariable()
    {
        $db = static::getDB();
        $sql = "Select * from Parameters ";
        $q = $db->prepare($sql);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function getUneditableKeys($dataSourceId , $pageId ,$tableId)
    {
        $db = static::getDB();
        $sql = "SELECT UneditableColumns from TableActions WHERE DataSourceId = :dsID and PageTargetId = :page and tableTemplateId = :tableId";
       
        $q = $db->prepare($sql);
        $q->bindParam(':dsID', $dataSourceId , PDO::PARAM_STR);
        $q->bindParam(':page', $pageId , PDO::PARAM_STR);
        $q->bindParam(':tableId', $tableId , PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function getPredefinedVals()
    {
        $db = static::getDB();
        $sql = " select ActionButtonText from TableActions where PredefinedUpdate = '1'";
        $q = $db->prepare($sql);
        $q->execute();
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
   
    public static function deleteUserPagePlaceholders($userPageAccessId)
    {
        $db = static::getDB();
        $sql = "DELETE FROM UserPagePlaceholders WHERE UserPageAccessId = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($userPageAccessId));
        return $response;
    }

    public static function getPagePlaceholders($pageId, $userId, $pageText)
    {
        $db = static::getDB();
        $sql = "select UserPageAccess.*, UserPagePlaceholders.*
                from UserPageAccess, UserPagePlaceholders
                WHERE
                UserPageAccess.ID = UserPagePlaceholders.UserPageAccessId
                AND UserPageAccess.PageId =" . $pageId . "
                AND UserPageAccess.UserId =" . $userId . "
                AND UserPageAccess.PageMenuText ='" .$pageText . "'";
        //echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function GetPageSearchFilter($pageId, $userId, $pageText , $holderValue  )
    {
       
        $db = Self::getUserDB('BP_Admin10');
        $sql = "select UserPagePlaceholders.SearchFilter from UserPageAccess, UserPagePlaceholders
                WHERE
                UserPageAccess.ID = UserPagePlaceholders.UserPageAccessId
                AND UserPageAccess.PageId =" . $pageId . "
                AND UserPageAccess.UserId =" . $userId . "
                AND UserPageAccess.PageMenuText ='" .$pageText . "'
                AND PlaceholderValue = '".$holderValue."'";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$data = isset($data[0])?$data[0]:array();
        return $data ;
    }
    public static function AddPageSearchFilter($pageId, $userId, $pageText , $holderValue , $setValue )
    {
       
        $db = Self::getUserDB('BP_Admin10');
    
        $sql = "update UserPagePlaceholders set UserPagePlaceholders.SearchFilter = '". $setValue."'
                from  UserPageAccess
                WHERE
                UserPageAccess.ID = UserPagePlaceholders.UserPageAccessId
                AND UserPageAccess.PageId =" . $pageId . "
                AND UserPageAccess.UserId =" . $userId . "
                AND UserPageAccess.PageMenuText ='" .$pageText . "'
                AND PlaceholderValue = '".$holderValue."'";
        //echo $sql; exit;
        $data = $db->exec($sql);
        return $data ;
    }
   

    public static function getPagePanelGraph($pageId, $userId, $pageText)
    {
        $db = static::getDB();
        $sql = "select UserPageAccess.ID, UserPagePlaceholders.PlaceholderId,UserPagePlaceholders.PlaceholderType,UserPagePlaceholders.PlaceholderValue
                from UserPageAccess, UserPagePlaceholders
                WHERE
                UserPageAccess.ID = UserPagePlaceholders.UserPageAccessId
                AND UserPageAccess.PageId =" . $pageId . "
                AND UserPageAccess.UserId =" . $userId . "
                AND UserPageAccess.PageMenuText ='" .$pageText . "'";
        //echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getDatasourceTableDetails($id)
    {
        try {

            $db = static::getDB();
            $sql = "select TableType , DataSourceId from Tables
                    where Tables.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $res= $stmt->fetchAll();
           
            if( isset($res[0]) && $res[0]['TableType'] == '3')
                {
                    $Ids = '';
                    $DataSourceId = explode(',',  $res[0]['DataSourceId']);
                    foreach ($DataSourceId as $key => $value) {
                        if(empty($Ids)){
                            $Ids = "'". $value ."',";
                        }else{
                            $Ids = $Ids."'". $value ."',";
                        }
                    }
                    $Ids = trim($Ids , ',');

                    $sql = "select Tables.*, DataSource.*, Tables.Columns as tableColumns
                    from Tables, DataSource
                    WHERE
                    DataSource.ID IN (".$Ids.")
                    AND Tables.ID =" . $id . "";
                    
                    
                }else{
                      $sql = "select Tables.*, DataSource.*, Tables.Columns as tableColumns
                        from Tables, DataSource
                        WHERE
                        DataSource.ID IN (Tables.DataSourceId)
                        AND Tables.ID =" . $id . "";
                }

            
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDatasourceDetailsById($id)
    {
        try {
            $db = static::getDB();
            $sql = "select * from DataSource
                WHERE DataSource.ID = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDatasourcePanelDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Panels.*, DataSource.*, Panels.Columns as penalColumns
                from Panels, DataSource
                WHERE
                Panels.DataSourceId = DataSource.ID
                AND Panels.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDataTablePanelDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = " select Panels.*,  DataSource.*, Panels.Columns as penalColumns
                from Panels, Tables , DataSource
                WHERE
                Panels.TableId = Tables.ID AND 
                DataSource.ID = Tables.DataSourceID 
                AND Panels.ID = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getDataTableDatasource($id)
    {
        try {
            $db = static::getDB();
            $sql = " SELECT  ID,DataSourceId from Tables WHERE ID = '". $id ."' ";
               
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
        }
    }

    public static function getDatasourceGraphDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Graphs.*, DataSource.*
                from Graphs, DataSource
                WHERE
                Graphs.DataSourceId = DataSource.ID
                AND Graphs.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getDatasourceMapsDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Maps.*, DataSource.*
                from Maps, DataSource
                WHERE
                Maps.DataSourceId = DataSource.ID
                AND Maps.ID = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDatasourcePieChartDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select PieCharts.*, DataSource.*
                from PieCharts, DataSource
                WHERE
                PieCharts.DataSourceId = DataSource.ID
                AND PieCharts.ID = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDataTableGraphDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Graphs.*, Tables.*
                from Graphs, Tables
                WHERE
                Graphs.TableId = Tables.ID
                AND Graphs.ID = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getPanelActionDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select PanelActions.*, UserPagePlaceholders.*
                from PanelActions, UserPagePlaceholders
                WHERE
                PanelActions.ID = UserPagePlaceholders.PlaceholderActionIds
                AND UserPagePlaceholders.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getGraphActionDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select GraphActions.*, UserPagePlaceholders.*
                from GraphActions, UserPagePlaceholders
                WHERE
                GraphActions.ID = UserPagePlaceholders.PlaceholderActionIds
                AND UserPagePlaceholders.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getTableActionDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select TableActions.*, UserPagePlaceholders.*
                from TableActions, UserPagePlaceholders
                WHERE UserPagePlaceholders.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getTableColumnsNew($id)
    {
        try {
            $db = static::getDB();
            $sql = "select DisplayColumnNames, Columns from Tables WHERE ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getChildRow($id)
    {
        try {
            $db = static::getDB();
            $sql = "select * from ChildRowAction
                WHERE  DataSourceId =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getTableActionDetailsAPI($id)
    {

        try {
            $db = static::getDB();
            $sql = "select TableActions.*, UserPagePlaceholders.*
                from TableActions, UserPagePlaceholders
                WHERE UserPagePlaceholders.PlaceholderActionIds = '" . $id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getTableActionDetailsById($id){
        try {
            $db = static::getDB();
            $sql = "select TableActions.*, DataSource.* from DataSource, TableActions
                WHERE DataSource.ID = TableActions.DataSourceId AND TableActions.ID =" . $id . "";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    // New ftn
    public static function getTableActionDetailsByIdIN($id){
        try {
            $db = static::getDB();
            $sql = "select TableActions.*, DataSource.* from DataSource, TableActions
                WHERE DataSource.ID = TableActions.DataSourceId AND TableActions.ID IN (" . $id . ")";
            
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function deletePlaceholderAccess($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM UserPanelAndPlaceholder WHERE ID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
    public static function deleteFormAccess($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM SendOrders WHERE ID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
    

    public static function deleteByTableAndColumnInfo($tableName, $columnName, $value)
    {
        $db = static::getDB();
        $sql = "DELETE FROM $tableName WHERE $columnName = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($value));
        return $response;
    }

    public static function getDataByTableName($tableName)
    {
        $db = static::getDB();
        $sql = "select * from {$tableName}";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function addPlaceholderAccess()
    {
        $db = static::getDB();
        $sql = "INSERT INTO UserPanelAndPlaceholder(PanelID,PlaceholderID,UserID,PageID) VALUES (:PanelID,:PlaceholderID,:UserID,:PageID)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':PanelID', $_REQUEST['PanelID'], PDO::PARAM_INT);
        $stmt->bindParam(':PlaceholderID', $_REQUEST['PlaceholderID'], PDO::PARAM_INT);
        $stmt->bindParam(':UserID', $_REQUEST['UserID'], PDO::PARAM_INT);
        $stmt->bindParam(':PageID', $_REQUEST['PageID'], PDO::PARAM_INT);
        $stmt->execute();
        return;
    }

    public static function addUserPageAccess($data)
    {
        
        $db = static::getDB();
        if (!empty($_REQUEST['id'])) {
            $sql = "UPDATE UserPageAccess SET PageMenuText = :PageMenuText,
            PageId = :PageId,
            PageMenuOrder = :PageMenuOrder,
            ParentPages = :ParentPages,
            ParentPageText = :ParentPageText,
            UserId = :UserId,
            ShowAsMenu = :ShowAsMenu,
            LiveSyncTime = :LiveSyncTime,
            LiveSyncFlag = :LiveSyncFlag,
            SecondaryPageMenuOrder = :SecondaryPageMenuOrder,
            SecondaryChildPageMenuOrder = :SecondaryChildPageMenuOrder,
            ParentLinkFlag = :ParentLinkFlag,
            DefaultFirstPage = :DefaultFirstPage, 
            EnableTicketMenuLabel = :EnableTicketMenuLabel ,
            onClickNoti = :onClickNoti , 
            EnableFixedHeader = :EnableFixedHeader,
            EnableFixedLeftColumn =:EnableFixedLeftColumn
            WHERE ID = :ID";
            $getParentPages = (isset($data['ParentPages'])) ? $data['ParentPages'] : NULL;
            $parentPageId = '';
            $parentPageText = '';
            if (!empty($getParentPages)) {
                foreach($getParentPages as $value) {
                    if(isset($value)) {
                        $value = explode('_',$value);
                        $parentPageId .= $value[0].',';
                        $parentPageText .= $value[1].',';
                    }
                }
                //$getParentPages = implode(',', $getParentPages);
            }
            $parentPageId = rtrim($parentPageId, ',');
            $parentPageText = rtrim($parentPageText, ',');
            if(empty($data['LiveSyncFlag'])){
                 $data['LiveSyncFlag'] = '0' ;
                 $data['LiveSyncTime'] = '';
            }
            /*echo '<pre>';
            print_r($parentPageId);
            echo '<pre>';
            print_r($parentPageText);

            die;*/

            try {
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':PageId', $data['PageId'], PDO::PARAM_STR);
                $stmt->bindParam(':PageMenuText', $data['PageMenuText'], PDO::PARAM_STR);
                $stmt->bindParam(':PageMenuOrder', $data['PageMenuOrder'], PDO::PARAM_STR);
                $stmt->bindParam(':ParentPages', $parentPageId, PDO::PARAM_STR);
                $stmt->bindParam(':ParentPageText', $parentPageText, PDO::PARAM_STR);
                $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
                $stmt->bindParam(':ShowAsMenu', $data['ShowAsMenu'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncFlag', $data['LiveSyncFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncTime', $data['LiveSyncTime'], PDO::PARAM_STR);
                $stmt->bindParam(':SecondaryPageMenuOrder', $data['SecondaryPageMenuOrder'], PDO::PARAM_STR);
                $stmt->bindParam(':SecondaryChildPageMenuOrder', $data['SecondaryChildPageMenuOrder'], PDO::PARAM_STR);
                $stmt->bindParam(':ParentLinkFlag', $data['ParentLinkFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':DefaultFirstPage', $data['DefaultFirstPage'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableTicketMenuLabel', $data['EnableTicketMenuLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':onClickNoti', $data['onClickNoti'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFixedHeader', $data['EnableFixedHeader'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFixedLeftColumn', $data['EnableFixedLeftColumn'], PDO::PARAM_STR);
               
                
                
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $exc) {
                echo $exc->getMessage();exit;
            }

        } else {
           
            $sql = "INSERT INTO UserPageAccess(PageId,ParentPages,PageMenuText,PageMenuOrder,UserId,ShowAsMenu,LiveSyncTime ,LiveSyncFlag, ParentPageText, SecondaryPageMenuOrder, SecondaryChildPageMenuOrder , ParentLinkFlag , DefaultFirstPage , EnableTicketMenuLabel , onClickNoti , EnableFixedHeader , EnableFixedLeftColumn ) VALUES (:PageId,:ParentPages,
                :PageMenuText,:PageMenuOrder,:UserId,:ShowAsMenu ,:LiveSyncTime ,:LiveSyncFlag , :ParentPageText, :SecondaryPageMenuOrder,  :SecondaryChildPageMenuOrder, :ParentLinkFlag , :DefaultFirstPage , :EnableTicketMenuLabel , :onClickNoti , :EnableFixedHeader ,:EnableFixedLeftColumn )";
            $getParentPages = (!empty($data['ParentPages'][0])) ? $data['ParentPages'] :'';
            $parentPageId = '';
            $parentPageText ='';
            if(isset($data['ParentPageText']) && !empty($data['ParentPageText']))
            {
             $parentPageText = (!empty($data['ParentPageText'])) ? $data['ParentPageText'] :'';
            }

            if (!empty($getParentPages)) {
                //$parentPageText =  $data['ParentPageText'];
            
                foreach($getParentPages as $value) {
                    $parentPageText = '';
                 
                    if(isset($value)) {
                        $val = explode('_',$value);
                        
                        if(count($val) > 1){
                            $parentPageId .= $val[0].',';
                            $parentPageText .= $val[1].',';
                        }else
                        {
                            $parentPageId .= $value.',';
                            $parentPageText =  $data['ParentPageText'];
            
                        }
                    }
                }
                   
                //$getParentPages = implode(',', $getParentPages);
            }

            $parentPageId = rtrim($parentPageId, ',');
            $parentPageText = rtrim($parentPageText, ',');
            
            if(empty($data['LiveSyncFlag'])){
                 $data['LiveSyncFlag'] = '0' ;
                 $data['LiveSyncTime'] = '';
            }
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':PageId', $data['PageId'], PDO::PARAM_STR);
            $stmt->bindParam(':PageMenuText', $data['PageMenuText'], PDO::PARAM_STR);
            $stmt->bindParam(':PageMenuOrder', $data['PageMenuOrder'], PDO::PARAM_STR);
            $stmt->bindParam(':ParentPages', $parentPageId, PDO::PARAM_STR);
            $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
            $stmt->bindParam(':ShowAsMenu', $data['ShowAsMenu'], PDO::PARAM_STR);
            $stmt->bindParam(':LiveSyncFlag', $data['LiveSyncFlag'], PDO::PARAM_STR);
            $stmt->bindParam(':LiveSyncTime', $data['LiveSyncTime'], PDO::PARAM_STR);
            $stmt->bindParam(':SecondaryPageMenuOrder', $data['SecondaryPageMenuOrder'], PDO::PARAM_STR);
            $stmt->bindParam(':SecondaryChildPageMenuOrder', $data['SecondaryChildPageMenuOrder'], PDO::PARAM_STR);
            $stmt->bindParam(':ParentPageText', $parentPageText, PDO::PARAM_STR);
            $stmt->bindParam(':ParentLinkFlag', $data['ParentLinkFlag'], PDO::PARAM_STR);
            $stmt->bindParam(':DefaultFirstPage', $data['DefaultFirstPage'], PDO::PARAM_STR);
            $stmt->bindParam(':EnableTicketMenuLabel', $data['EnableTicketMenuLabel'], PDO::PARAM_STR);
            $stmt->bindParam(':onClickNoti', $data['onClickNoti'], PDO::PARAM_STR);
            $stmt->bindParam(':EnableFixedHeader', $data['EnableFixedHeader'], PDO::PARAM_STR);
            $stmt->bindParam(':EnableFixedLeftColumn', $data['EnableFixedLeftColumn'], PDO::PARAM_STR);
           
            

            $stmt->execute();
            return $db->lastInsertId();
        }

        return;
    }

    public static function getPageDetails($id)
    {
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }

        $sql = "SELECT * FROM Pages";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
       
        return $data;
    }

    public static function getPageLiveSyncStatus($pageId , $userId )
    {
        $db = static::getDB();
        $sql = "SELECT LiveSyncFlag , LiveSyncTime , ShowAsMenu
                FROM UserPageAccess
                WHERE UserPageAccess.PageId = '" . $pageId . "' AND UserPageAccess.UserId ='" . $userId . "' AND UserPageAccess.ShowAsMenu = '1'";
        $stmt = $db->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function getUserAccessPageDetails($id)
    {
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM UserPageAccess";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getSubmenus($pageId, $userId, $pageText)
    {

        try {
            //echo "SELECT * FROM UserPageAccess WHERE  (',' + RTRIM(ParentPages) + ',') LIKE '%,' + '" . $pageId . "' + ',%' AND (',' + RTRIM(ParentPageText) + ',') LIKE '%,' + '" . $pageText . "' + ',%' AND UserId='" . $userId . "'";
            //die;
            $db = static::getDB();
            $stmt = $db->query("SELECT * FROM UserPageAccess WHERE  (',' + RTRIM(ParentPages) + ',') LIKE '%,' + '" . $pageId . "' + ',%' AND (',' + RTRIM(ParentPageText) + ',') LIKE '%,' + '" . $pageText . "' + ',%' AND UserId='" . $userId . "'");
            //$stmt = $db->query("SELECT * FROM UserPageAccess WHERE  (',' + RTRIM(ParentPages) + ',') LIKE '%,' + '" . $pageId . "' + ',%' AND UserId='" . $userId . "'");
            $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }

        return $data;
    }

    public static function getPageText($pageId, $userId)
    {
        /*echo "SELECT UserPageAccess.PageMenuText FROM UserPageAccess WHERE PageId='" . $pageId . "' AND UserId='".$userId."'";
        die;*/
        try {
            $db = static::getDB();
            $stmt = $db->query("SELECT UserPageAccess.PageMenuText FROM UserPageAccess WHERE PageId='" . $pageId . "' AND UserId='".$userId."'");
            $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }

        return $data;
    }

    public static function updateDataSourceBody($id, $requestBody)
    {
        if(!empty($id)){
            $db = static::getDB();
            $sql = "UPDATE DataSource SET Body = :Body
            WHERE ID = :ID";

            try{
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':Body', $requestBody, PDO::PARAM_STR);
                $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
                $stmt->execute();
            }catch (Exception $exc){

            }

        }



        /*try {
            $db = static::getDB();
            $sql = "select Tables.*, DataSource.*, Tables.Columns as tableColumns
                from Tables, DataSource
                WHERE
                Tables.DataSourceId = DataSource.ID
                AND Tables.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }*/
    }

    public static function getGraphDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Graphs.*, DataSource.ID
                from Graphs, DataSource
                WHERE
                Graphs.DataSourceId = DataSource.ID
                AND Graphs.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getGraphDetailsTable($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Graphs.*, Tables.ID
                from Graphs, Tables
                WHERE
                Graphs.TableId = Tables.ID
                AND Graphs.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getPieDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select PieCharts.*, DataSource.ID
                from PieCharts, DataSource
                WHERE
                PieCharts.DataSourceId = DataSource.ID
                AND PieCharts.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

     public static function getMapsDetails($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Maps.*, DataSource.ID
                from Maps, DataSource
                WHERE
                Maps.DataSourceId = DataSource.ID
                AND Maps.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getMapsDetailsTable($id)
    {
        try {
            $db = static::getDB();
            $sql = "select Maps.*, Tables.ID
                from Maps, Tables
                WHERE
                Maps.TableId = Tables.ID
                AND Maps.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getPieDetailsTable($id)
    {
        try {
            $db = static::getDB();
            $sql = "select PieCharts.*, Tables.ID
                from PieCharts, Tables
                WHERE
                PieCharts.TableId = Tables.ID
                AND PieCharts.ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }

    public static function getDynamicFormData($id)
    {
        try {
            $db = static::getDB();
            $sql = "select * from SendOrders WHERE ID =" . $id . "";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getSlidertableD1($PId,$Id,$UserId)
    {
        try {
            $db = static::getDB();
            $sql = "  select TS.TableSideBar , TS.TabAction ,TS.TableSideBar2 , TS.TabAction2 
            from TableSilder TS
            Inner join UserPagePlaceholders UPP on  TS.ID = UPP.SliderDesign
            where Upp.PlaceholderId = '".$PId."' and UPP.ID = '".$Id."' and Upp.UserId = '".$UserId."'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getSlidertableD2($PId,$Id,$UserId)
    {
        try {
            $db = static::getDB();
            $sql = "  select TS.TableSideBar , TS.TabAction ,TS.TableSideBar2 , TS.TabAction2 
            from TableSilder TS
            Inner join UserPagePlaceholders UPP on  TS.ID = UPP.SliderDesign2
            where Upp.PlaceholderId = '".$PId."' and Upp.ID = '".$Id."' and Upp.UserId = '".$UserId."'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getAllAgents($databaseName)
    {
        try {
            $db = Self::getUserDB($databaseName);
            $sql = "Select agent_id , contact_name from Agents order by updated_at DESC ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getAllGroups($databaseName)
    {
        try {
            $db = Self::getUserDB($databaseName);
            $sql = " Select group_id , group_name from Groups order by updated_at DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getCompanyFreshDesk($databaseName, $cId)
    {
        try {
            $db = Self::getUserDB($databaseName);
            $sql = " SELECT company_id FROM Contacts where contact_id IN (".$cId.") group by company_id ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getNotiLogs()
    {
       
        try {
            $db = static::getDB();
            $UID = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:$_SESSION['UserID'];
		
			// Old Query 
            /*$sql = " select noti.* , UPA.PageMenuText , UPA.PageId
            from NotiLog noti 
            left join  UserPageAccess UPA on UPA.onClickNoti =  noti.NotiId
            where noti.DisplayStatus = '1' and noti.UserID = '".$UID."' ";*/
			
			$sql  = " select noti.* , UPA.PageMenuText , UPA.PageId
            from NotiLog noti 
            left join  UserPageAccess as UPA on  UPA.UserID = '".$_SESSION['UserID']."' 
            where noti.DisplayStatus = '1' and noti.UserID = '".$UID."'  and UPA.onClickNoti != ''";
			
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
	public static function getSpecficNotificationLogs($id)
    {
       
        try {
            $db = static::getDB();
            $sql = " select * from NotiLog where ID = '$id' ";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function getSpecficNotiLogs($id)
    {
       
        try {
            $db = static::getDB();
            $sql = " select * from PushNotification  where ID = '$id' ";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $data = $stmt->fetchAll();
        } catch (Exception $exc) {
        }
    }
    public static function updateNotiLogs($id)
    {
        if(!empty($id)){
            $db = static::getDB();
            $sql = "UPDATE NotiLog  SET DisplayStatus = :DisplayStatus
            WHERE ID = :ID";

            try{
                $stmt = $db->prepare($sql);
                $requestBody = 0;
                $stmt->bindParam(':DisplayStatus', $requestBody, PDO::PARAM_STR);
                $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
                $stmt->execute();
            }catch (Exception $exc){

            }

        }
    }

}

