<?php

namespace App\Controllers\Admin\adminPlaceholder;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\DataSources;
use \App\Models\TablePlaceholders;
use \App\Models\GraphPlaceholders;
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class PieChartPlaceholder extends \Core\Controller
{
    public function addPiechartAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $getDataTable = TablePlaceholders::getAllDataTable();
        View::render('administrator/placeholder/add_piechart.php', ['getDataSource' => $getDataSource,'getDataTable' => $getDataTable]);
    }


    public function savePiechart()
    {
        $saveData = $_REQUEST;
        $columns = (isset($saveData['Columns'])) ? $saveData['Columns'] : "";
        $cityColumn = (isset($saveData['Fields'])) ? $saveData['Fields'] : "";
        
        if ($columns) {
            $columns = implode(',', $columns);
        }
        if ($cityColumn) {
            $cityColumn = implode(',', $cityColumn);
        }
        
        $saveData['Columns'] = $columns;
        $saveData['Fields'] = $cityColumn;

        if(isset($saveData['TableId']) && !empty($saveData['TableId']) && !isset($saveData['DataSourceId']))
        {
               $val = placeholder::getDataTableDescription($saveData['TableId']);
               $saveData['DataSourceId'] = $val[0]['DataSourceId'];
        }   
        GraphPlaceholders::addPieChart($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }
}