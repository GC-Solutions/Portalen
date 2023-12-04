<?php

namespace App\Controllers\Admin\adminPlaceholder;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\DataSources;
use \App\Models\TablePlaceholders;
use \App\Models\PanelPlaceholders;
use \App\Models\MapPlaceholders;
use \App\Models\GraphPlaceholders;
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class Placeholders extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    // This function shows all the placeholder like Maps , tables , graphs etc
    public function show()
    {
        // fetch all data from different placeholders 
        $getAllPanels = Placeholder::getAllTableData("Panels");
        $getAllTables = Placeholder::getAllTableData("Tables");
        $getAllGraphs = Placeholder::getAllTableData("Graphs");
        $getAllMaps = Placeholder::getAllTableData("Maps");
        $getAllPCharts = Placeholder::getAllTableData("PieCharts");
        $getAllTableActions = Placeholder::getAllTableData("TableActions");
        $getAllPanelActions = Placeholder::getAllTableData("PanelActions");
        $getAllGraphActions = Placeholder::getAllTableData("GraphActions");
        $getAllProductActions = Placeholder::getAllTableData("MongoTables");
        $getAllSliderTables = Placeholder::getAllTableData("TableSilder");
        $getDynamicForm = Placeholder::GetDynamicForm();
        $getAllCustomSetting = Placeholder::getAllCustomSetting();
        $getAllTableDataNew = Placeholder::getAllTableDataNew("Tables");
        // view call to show all the placholder .
        View::render('administrator/placeholder/show.php', ['getAllTableDataNew' => $getAllTableDataNew , 'getAllPanels' => $getAllPanels, 'getAllTables' => $getAllTables,
            "getAllGraphs" => $getAllGraphs, "getAllTableActions" => $getAllTableActions,
            'getAllPanelActions' => $getAllPanelActions, 'getAllGraphActions' => $getAllGraphActions , 'getAllMaps' => $getAllMaps, 'getAllPCharts' => $getAllPCharts , 'getAllProductActions' => $getAllProductActions , 'getDynamicForm' => $getDynamicForm , 'getAllSliderTables' => $getAllSliderTables , 'getAllCustomSetting' => $getAllCustomSetting]);
    }
    //(Start) FUnction not used 
    public function addAction()
    {
        View::render('administrator/placeholder/add.php', []);
    }
    //(Start) FUnction not used 
    //(Start) FUnction to delete placeholder  
    public function deleteAction()
    {
        Placeholder::deletePlacebolder($_REQUEST['id']);
        header('Location: ' . baseUrl . 'placeholders');
    }
     //(End) FUnction to delete placeholder  
    //Save the data in DB 
    public function saveAction()
    {
        Placeholder::addPlaceholder();
        header('Location: ' . baseUrl . 'placeholders');
    }
    // get the data for an Edited Placeholder
    public function editAction()
    {
        $getPlaceholderDetails = Placeholder::getPlaceholderDetails($_REQUEST['id']);
        View::render('administrator/placeholder/edit.php', ['getPlaceholderDetails' => $getPlaceholderDetails]);
    }

    public function updateAction()
    {
        Placeholder::updatePlaceholder();
        header('Location: ' . baseUrl . 'placeholders');
    }
        // This Function Allows you to delete the placeholder
    public function deleteplaceholderAction()
    {
        Page::deletePlaceholderAccess($_REQUEST['id']);
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['pageId'] . '&userAccessId=' . $_REQUEST['userAccessId']);
    }
    // get data to open the Add form 
    public function addplaceholderaccessAction()
    {
        $allPanels = Page::getDataByTableName('Panel');
        $allPlaceholders = Page::getDataByTableName('Placeholder');
        View::render('administrator/pageaccess/add_placeholder_access.php', ['allPanels' => $allPanels, 'allPlaceholders' => $allPlaceholders]);
    }
    ///////////////////////  NOt Used ////////////////////////////////////////////////////////////////
    // Edit Place Holders
    public function editplaceholderAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";

        if ($id && $type) {
            $getDataSource = DataSources::getAllDataSource();
            if ($type == 1) {
                $getPanelDetails = Placeholder::getTableDetails("Panels", $id);
                if ($getPanelDetails) {
                    $getPanelDetails = $getPanelDetails[0];
                }
                $getDataTable = TablePlaceholders::getAllDataTable();
                View::render('administrator/placeholder/add_panel.php', ['getDataSource' => $getDataSource, 'getDataTable' => $getDataTable, 'getPanelDetails' => $getPanelDetails]);
            } else if ($type == 2) {
                $getTableDetails = Placeholder::getTableDetails("Tables", $id);
                //print_r($getTableDetails); exit;
                if ($getTableDetails) {
                    $getTableDetails = $getTableDetails[0];
                }
                $getAllTable = Placeholder::getAllTableData("Tables");
                $getAllTableActions = Placeholder::getAllTableData("TableActions");
                $GetDynamicForm = Placeholder::GetDynamicForm();
                $getPredefinedVal = Page::getPredefinedVals();
       
                View::render('administrator/placeholder/add_table.php', ['getDataSource' => $getDataSource, 'getTableDetails' => $getTableDetails , 'GetDynamicForm' => $GetDynamicForm , 'getAllTable' =>  $getAllTable , 'getAllTableActions' => $getAllTableActions , 'getPredefinedVal' => $getPredefinedVal]);
            } else if ($type == 3) {
                $getGraphDetails = Placeholder::getTableDetails("Graphs", $id);
                if ($getGraphDetails) {
                    $getGraphDetails = $getGraphDetails[0];
                }
                $getDataTable = TablePlaceholders::getAllDataTable();
                View::render('administrator/placeholder/add_graph.php', ['getDataSource' => $getDataSource, 'getGraphDetails' => $getGraphDetails, 'getDataTable' => $getDataTable]);
            } else if ($type == 4) {
                $getTableActionDetails = Placeholder::getTableDetails("TableActions", $id);
                $getAllPages = User::getAllPagesAsList();
                $getDataSourceTables = "";
                if ($getTableActionDetails) {
                    $getTableActionDetails = $getTableActionDetails[0];
                    $getDataSourceTables = Placeholder::getDataSourceTableData('Tables', $getTableActionDetails['DataSourceId']);
                }
                View::render('administrator/placeholder/add_actions_tables.php', ['getDataSource' => $getDataSource,
                    'getTableActionDetails' => $getTableActionDetails, 'getDataSourceTables' => $getDataSourceTables, "getAllPages" => $getAllPages]);
            } else if ($type == 5) {
                $getPanelActionDetails = Placeholder::getTableDetails("PanelActions", $id);
                $getAllPages = User::getAllPagesAsList();
                $getDataSourcePanels = "";
                if ($getPanelActionDetails) {
                    $getPanelActionDetails = $getPanelActionDetails[0];
                    $getDataSourcePanels = Placeholder::getDataSourceTableData('Panels', $getPanelActionDetails['DataSourceId']);
                }
                View::render('administrator/placeholder/add_actions_panel.php', ['getDataSource' => $getDataSource,
                    'getPanelActionDetails' => $getPanelActionDetails, 'getDataSourcePanels' => $getDataSourcePanels, "getAllPages" => $getAllPages]);
            } else if ($type == 6) {
                $getGraphActionDetails = Placeholder::getTableDetails("GraphActions", $id);
                $getAllPages = User::getAllPagesAsList();
                $getDataSourcePanels = "";
                if ($getGraphActionDetails) {
                    $getGraphActionDetails = $getGraphActionDetails[0];
                    $getDataSourceGraphs = Placeholder::getDataSourceTableData('Graphs', $getGraphActionDetails['DataSourceId']);
                }
                View::render('administrator/placeholder/add_actions_graph.php', ['getDataSource' => $getDataSource,
                    'getGraphActionDetails' => $getGraphActionDetails, 'getDataSourceGraphs' => $getDataSourceGraphs, "getAllPages" => $getAllPages]);
            }else if ($type == 7) {
                $getMapsDetails = Placeholder::getTableDetails("Maps", $id);
                if ($getMapsDetails) {
                    $getMapsDetails = $getMapsDetails[0];
                }
                $getDataTable = TablePlaceholders::getAllDataTable();
                View::render('administrator/placeholder/add_maps.php', ['getDataSource' => $getDataSource, 'getMapsDetails' => $getMapsDetails, 'getDataTable' => $getDataTable]);
            }else if ($type == 8) {
                $getPieChartDetails = Placeholder::getTableDetails("PieCharts", $id);
                if ($getPieChartDetails) {
                    $getPieChartDetails = $getPieChartDetails[0];
                }

                $getDataTable = TablePlaceholders::getAllDataTable();
                View::render('administrator/placeholder/add_piechart.php', ['getDataSource' => $getDataSource, 'getPieChartDetails' => $getPieChartDetails, 'getDataTable' => $getDataTable]);
            }else if ($type == 10) {
                $getDynamicFormDetails = Placeholder::getTableDetails("SendOrders", $id);
                if ($getDynamicFormDetails) {
                    $getDynamicFormDetails = $getDynamicFormDetails[0];
                }
                $getAllTable = Placeholder::getAllTableData("Tables");
                View::render('administrator/placeholder/add_dynamic_form.php', ['getTableDetails' => $getDynamicFormDetails  ,  'getAllTable' =>  $getAllTable]);
            }else if ($type == 11) {
                $getTableDetails = Placeholder::getTableDetails("TableSilder", $id);
                if ($getTableDetails) {
                    $getTableDetails = $getTableDetails[0];
                }
                $getAllTable = Placeholder::getAllTableData("Tables");
                $getAllTableActions = Placeholder::getAllTableData("TableActions");
                View::render('administrator/placeholder/add_dynamic_form.php', ['getTableDetails' => $getTableDetails ,  'getAllTable' =>  $getAllTable , 'getAllTableActions' => $getAllTableActions]);
            }else if ($type == 12) {
                $getTableDetails = Placeholder::getTableDetailsNew("Tables", $id);
                if ($getTableDetails) {
                    $getTableDetails = $getTableDetails[0];
                }
                $getAllTable = Placeholder::getAllTableData("Tables");
                $getAllTableActions = Placeholder::getAllTableData("TableActions");
                $GetDynamicForm = Placeholder::GetDynamicForm();
                View::render('administrator/placeholder/add_new_table.php', ['getDataSource' => $getDataSource, 'getTableDetails' => $getTableDetails , 'GetDynamicForm' => $GetDynamicForm , 'getAllTable' =>  $getAllTable , 'getAllTableActions' => $getAllTableActions]);
            } 
        }
    }

    // New function for Clone the placeholder
    public function copyplaceholderAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
       
        if ($id && $type) {
            //$getDataSource = Placeholder::getAllDataSource();
            if ($type == 1) {
                // for PaneL
                $getPanelDetails = Placeholder::getTableDetails("Panels", $id);
                if ($getPanelDetails) {
                    $saveData = $getPanelDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);

                PanelPlaceholders::addPanel($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
            } else if ($type == 2) {
                // For Table
                $getTableDetails = Placeholder::getTableDetails("Tables", $id);
                
                if ($getTableDetails) {
                    $saveData = $getTableDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                
                unset($saveData['ID']);
                unset($saveData['0']);
                
                TablePlaceholders::addTable($saveData , '');
                header('Location: ' . baseUrl . 'placeholders');
                exit;

            } else if ($type == 3) {
                // for Graph
                $getGraphDetails = Placeholder::getTableDetails("Graphs", $id);
                if ($getGraphDetails) {
                    $saveData = $getGraphDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
                
                GraphPlaceholders::addGraph($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
                
            } else if ($type == 4) {

                $getTableActionDetails = Placeholder::getTableDetails("TableActions", $id);
               
                if ($getTableActionDetails) {
                    $saveData = $getTableActionDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
                
                TablePlaceholders::addTableActions($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;

            } else if ($type == 5) {
                $getPanelActionDetails = Placeholder::getTableDetails("PanelActions", $id);
                 
                if ($getPanelActionDetails) {
                    $saveData = $getPanelActionDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
               
                PanelPlaceholders::addPanelActions($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
                
            } else if ($type == 6) {
                $getGraphActionDetails = Placeholder::getTableDetails("GraphActions", $id);
               
                if ($getGraphActionDetails) {
                    $saveData = $getGraphActionDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
                
                GraphPlaceholders::addGraphActions($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
               
            }else if ($type == 7) {
                $getMapsDetails = Placeholder::getTableDetails("Maps", $id);
               
                if ($getMapsDetails) {
                    $saveData = $getMapsDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
                
                MapPlaceholders::addMaps($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
               
            }else if ($type == 8) {
                $getPieChartDetails = Placeholder::getTableDetails("PieCharts", $id);
               
                if ($getPieChartDetails) {
                    $saveData = $getPieChartDetails[0];
                    $saveData['Name'] = $saveData['Name'] . '-(copy)';
                }
                unset($saveData['ID']);
                unset($saveData['0']);
                
                GraphPlaceholders::addPieChart($saveData);
                header('Location: ' . baseUrl . 'placeholders');
                exit;
               
            }
        }
    }

    // FUnction to delet the PLaceHlder
    public function deletePlaceholdersAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
        if (!empty($id) && !empty($type)) {
            if ($type == 1) {
                Placeholder::deleteDataFromTable("Panels", $id);
            } else if ($type == 2) {
                Placeholder::deleteDataFromTable("Tables", $id);
            } else if ($type == 3) {
                Placeholder::deleteDataFromTable("Graphs", $id);
            } else if ($type == 4) {
                Placeholder::deleteDataFromTable("TableActions", $id);
            } else if ($type == 5) {
                Placeholder::deleteDataFromTable("PanelActions", $id);
            } else if ($type == 6) {
                Placeholder::deleteDataFromTable("GraphActions", $id);
            }else if ($type == 7) {
                Placeholder::deleteDataFromTable("Maps", $id);
            }else if ($type == 8) {
                Placeholder::deleteDataFromTable("PieCharts", $id);
            }else if ($type == 11) {
                Placeholder::deleteDataFromTable("TableSilder", $id);
            }
        }
        header('Location: ' . baseUrl . 'placeholders');
    }
    
}
