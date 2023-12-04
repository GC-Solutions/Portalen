<?php

namespace App\Controllers\Admin\adminGeneral;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\DataSources;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\TablePlaceholders;
/**
 * FetchDataAdmin controller
 *
 * PHP version 7.0
 */
class FetchDataAdmin extends \Core\Controller
{
	// This function is called as an ajax request from admin side when we need to get the all the present dataSoucrce at the admin side 
	public function getDataSourceColumnsAction()
    {
        // variable Declaration 
        $dataSourceId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
        $tableType = (isset($_REQUEST['TableType'])) ? $_REQUEST['TableType'] : "1";
        $responnse = array();
        $responnse['status'] = true;
        //(Start) if dataSource ID is present 
        if ($dataSourceId) {
            //(start) In case we receive multiple dataSource Id  
            if(strpos($dataSourceId, ',') !== false)
            {
                $tempArr = array();
                // separate multiple Ids   
                $dataSourceId = explode(',', $dataSourceId);
                //(start) For loop  for multiple Ids 
                foreach ($dataSourceId as $key => $value) {
                   $getDataSourceColumns = Placeholder::getColumns($value); // get column Name
                    // (Start) for join table 
                    if($tableType == '3'){
                        if ($getDataSourceColumns) {
                            // For multiple node 
                            if($getDataSourceColumns[0]['ApiType']== '2')
                            {
                                $displayColumn = explode(',', $getDataSourceColumns[0]['DisplayColumnName']);
                                foreach ($displayColumn as $k => $val) {
                                   $displayColumn[$k] = $getDataSourceColumns[0]['Name'].'-'.$val;
                                }
                                $getDataSourceColumns[0]['DisplayColumnName'] = implode(',', $displayColumn);
                                $data =$getDataSourceColumns[0]['DisplayColumnName'];
                            }else
                            {
                                $displayColumn = explode(',', $getDataSourceColumns[0]['Columns']);
                                foreach ($displayColumn as $k => $val) {
                                    $val = trim($val);
                                    $displayColumn[$k] = $getDataSourceColumns[0]['Name'].'-'.$val;
                                }
                                $getDataSourceColumns[0]['Columns'] = implode(',', $displayColumn);
                                $data = $getDataSourceColumns[0]['Columns'];
                            }    
                        } 
                    }
                    // (End) for join table 
                    else{
                         if ($getDataSourceColumns) {
                            if($getDataSourceColumns[0]['ApiType']== '2') 
                            {
                                $data = $getDataSourceColumns[0]['DisplayColumnName'];
                            }else{
                                $data = $getDataSourceColumns[0]['Columns'];
                                
                            }
                        }
                    }
                    // concatnating the data 
                    array_push($tempArr, $data);
                }
                //(End) For loop  for multiple Ids 
                $responnse['data'] = implode(',', $tempArr);
            }
            //(end) In case we receive multiple dataSource Id for join Table
            else{
                $getDataSourceColumns = Placeholder::getColumns($dataSourceId); // get column Name
                 // (Start) for join table 
                if($tableType == '3'){
                    if ($getDataSourceColumns) {
                        // For multiple node 
                        if($getDataSourceColumns[0]['ApiType']== '2')
                        {
                            $displayColumn = explode(',', $getDataSourceColumns[0]['DisplayColumnName']);
                            foreach ($displayColumn as $k => $val) {
                               $displayColumn[$k] = $getDataSourceColumns[0]['Name'].'-'.$val;
                            }
                            $getDataSourceColumns[0]['DisplayColumnName'] = implode(',', $displayColumn);
                            $data = $getDataSourceColumns[0]['DisplayColumnName'];
                        }else
                        {
                            $displayColumn = explode(',', $getDataSourceColumns[0]['Columns']);
                            foreach ($displayColumn as $k => $val) {
                               $displayColumn[$k] = $getDataSourceColumns[0]['Name'].'-'.$val;
                            }
                            $getDataSourceColumns[0]['Columns'] = implode(',', $displayColumn);
                            $data = $getDataSourceColumns[0]['Columns'];
                        }
                        
                        $responnse['data'] = $data;
                    }
                }
                 // (Start) for join table 
                else{
                        if ($getDataSourceColumns) {
                            if($getDataSourceColumns[0]['ApiType']== '2')
                            {
                                $data = $getDataSourceColumns[0]['DisplayColumnName'];
                            }else{
                                $data = $getDataSourceColumns[0]['Columns'];
                            }
                             $responnse['data'] = $data;
                        }
                    }
            }
        } 
        //(end) if dataSource ID is present 
        else {
            $responnse['data'] = '';
        }
        echo json_encode($responnse);
        exit;
    }
    // This function return the data source  
    public function getallDataSource(){
        // Variable declaration 
        $tableType = (isset($_REQUEST['TableType'])) ? $_REQUEST['TableType'] : "1";
        $responnse = array();
        $responnse['status'] = true;
        // fetch data Sources 
        if($tableType == '2')
        {
            $getDataSource = DataSources::getAllDataSourceEdit(); 
        }else{
            $getDataSource = DataSources::getAllDataSource();
        }
        $responnse['data'] =  $getDataSource;
        echo json_encode($responnse);
        exit;

    }
    // This function is called as an ajax request from admin side when we need to get the all the present Tables at the admin side 
    public function getDataTableColumnsAction()
    {
        //Variable Declaration 
        $dataTableId = (isset($_REQUEST['dataTableId'])) ? $_REQUEST['dataTableId'] : "";
        $responnse = array();
        $responnse['status'] = true;
        if ($dataTableId) {
            //fetch table column Name 
            $getDataTableColumns = TablePlaceholders::getTableColumns($dataTableId);
            if ($getDataTableColumns) {
                $data = $getDataTableColumns[0]['Columns'];
                $responnse['data'] = $data;
            }
        } else {
            $responnse['data'] = '';
        }
        echo json_encode($responnse);
        exit;
    }
    // This function is called as an ajax request from admin side when we need to get the all the present Templates at the admin side 
    public function getDataSourceTableTemplates()
    {
        $dataSourceId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
        $responnse = array();
        $responnse['status'] = true;
        if ($dataSourceId) {
            $getDataSourceTables = Placeholder::getDataSourceTableData('Tables', $dataSourceId);
            if ($getDataSourceTables) {
                $tablesAndColumns = '';
                foreach ($getDataSourceTables as $key => $value) {
                    $tablesAndColumns .= $value['ID'] . '_##_' . $value['Name'] . '_##_' . $value['Columns'] . '_###_';
                }
                $responnse['data'] = $tablesAndColumns;
            } else {
                $responnse['data'] = '';
            }
        } else {
            $responnse['data'] = '';
        }
        echo json_encode($responnse);
        exit;
    }
    // This function is called as an ajax request from admin side when we need to get the all the present Panels at the admin side 
    public function getDataSourcePanelTemplates()
    {
        $dataSourceId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
        $responnse = array();
        $responnse['status'] = true;
        if ($dataSourceId) {
            $getDataSourcePanels = Placeholder::getDataSourceTableData('Panels', $dataSourceId);
            if ($getDataSourcePanels) {
                $panelsAndColumns = '';
                foreach ($getDataSourcePanels as $key => $value) {
                    $panelsAndColumns .= $value['ID'] . '_##_' . $value['Name'] . '_##_' . $value['Columns'] . '_###_';
                }
                $responnse['data'] = $panelsAndColumns;
            } else {
                $responnse['data'] = '';
            }
        } else {
            $responnse['data'] = '';
        }
        echo json_encode($responnse);
        exit;
    }
    // function to get user of a company
    public function getCompanyUserAction()
    {
        $CompanyId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
        $responnse = array();
        if ($CompanyId) {
            $CompanyId = explode('-', $CompanyId);
            $CompanyUsers = Companies::getCompanyUsers($CompanyId[0]);
            if ($CompanyUsers) {
                $users = '';
                foreach ($CompanyUsers as $key => $value) {
                    $users .= $value['UserEmail'] .',';
                }
                $responnse['data'] = ltrim($users , ',');
            } else {
                $responnse['data'] = '';
            }
        } else {
            $responnse['data'] = '';
        }
        echo json_encode($responnse);
        exit;

    }


}