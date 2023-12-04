<?php

namespace App\Controllers\Admin\adminPlaceholder;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\DataSources;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\TablePlaceholders;
use \App\Models\GraphPlaceholders;


/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class GraphPlaceholder extends \Core\Controller
{
    //(Start) Functioo to route to form for addding new graph
    public function addGraphAction()
    {
        // Get all Data Source that will be shown on graph placeholder form at admin panel 
        $getDataSource = DataSources::getAllDataSource();
        // Get all Data Table that will be shown on graph placeholder form at admin panel 
        $getDataTable = TablePlaceholders::getAllDataTable();
        View::render('administrator/placeholder/add_graph.php', ['getDataSource' => $getDataSource,'getDataTable' => $getDataTable]);
    }
    // (start)FUnction to update and edit graph placeholders
    public function saveGraph()
    {
        $saveData = $_REQUEST; // fetch all data that's being posted
        GraphPlaceholders::addGraph($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }
    //(Start) function to route to add graph actions
    public function addGraphActionsAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $getAllPages = User::getAllPagesAsList();
        View::render('administrator/placeholder/add_actions_graph.php', ['getDataSource' => $getDataSource, 'getAllPages' => $getAllPages]);
    }
    //(Start) FUnction to add a new entry or update ir 
    public function saveGraphActionsAction()
    {
        $saveData = $_REQUEST;
        Placeholder::addGraphActions($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }
}