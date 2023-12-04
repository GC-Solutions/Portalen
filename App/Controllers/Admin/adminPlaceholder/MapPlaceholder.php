<?php

namespace App\Controllers\Admin\adminPlaceholder;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\DataSources;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\TablePlaceholders;
use \App\Models\MapPlaceholders;

/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class MapPlaceholder extends \Core\Controller
{
    // FUnction to call the Add new Map placeholder form 
    public function addMapsAction()
    {
        // get all Data source it will displayed at admin side on map placeholder form 
        $getDataSource = DataSources::getAllDataSource();
        // get all Data table it will displayed at admin side on map placeholder form 
        $getDataTable = TablePlaceholders::getAllDataTable();
        View::render('administrator/placeholder/add_maps.php', ['getDataSource' => $getDataSource,'getDataTable' => $getDataTable]);
    }

    //Function to update and add a new entry at tym of save .
    public function saveMaps()
    {
        $saveData = $_REQUEST; // get all Posted Data from admin side 
        $columns = (isset($saveData['Columns'])) ? $saveData['Columns'] : "";
        $cityColumn = (isset($saveData['Fields'])) ? $saveData['Fields'] : "";
        // combine all data by comma for multiple entries 
        if ($columns) {
            $columns = implode(',', $columns);
        }
        if ($cityColumn) {
            $cityColumn = implode(',', $cityColumn);
        }
        $saveData['Columns'] = $columns;
        $saveData['Fields'] = $cityColumn;
        // model function  call to save data .
        MapPlaceholders::addMaps($saveData);
        // Redriect  to placeholder again .
        header('Location: ' . baseUrl . 'placeholders');
    }
}