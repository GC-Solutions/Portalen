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
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class PanelPlaceholder extends \Core\Controller
{

	// this Function Loades the Add panel form 
	public function addPanelAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $getDataTable = TablePlaceholders::getAllDataTable();
        View::render('administrator/placeholder/add_panel.php', ['getDataSource' => $getDataSource,'getDataTable' => $getDataTable]);
    }
    // Saves the data in DB 
    public function savePanelAction()
    {

        $saveData = $_REQUEST;
        $columns = (isset($saveData['Columns'])) ? $saveData['Columns'] : "";
        $id = (isset($saveData['id'])) ? $saveData['id'] : "";
        if ($columns) {
            $columns = implode(',', $columns);
        }
       
        if(!empty($saveData['TableId'])){
            $datasource = Page::getDataTableDatasource($saveData['TableId']);
            $saveData['DataSourceId'] = $datasource[0]['DataSourceId'];
        }
        
        $panelImageName = (isset($saveData['ImageName'])) ? $saveData['ImageName'] : "";
        $saveData['Columns'] = $columns;
        $saveData['ImageName'] = $panelImageName;
        PanelPlaceholders::addPanel($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }
    // Add Panel Action 
     public function addPanelActionsAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $getAllPages = User::getAllPagesAsList();
        View::render('administrator/placeholder/add_actions_panel.php', ['getDataSource' => $getDataSource, 'getAllPages' => $getAllPages]);
    }
    public function savePanelActionsAction()
    {
        $saveData = $_REQUEST;
        PanelPlaceholders::addPanelActions($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }

}