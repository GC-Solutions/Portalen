<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use APP\Models\Execute;
use App\Controllers\DataTableHelper;
use App\Models\Products;

/**
 * GraphDataHighChart controller
 *
 * PHP version 7.0
 This File contain the function to generate a high chart .
 */

class GraphDataHighChart extends \Core\Controller
{
    function generateGraphDataHighChartAction() {
        // Set the number of seconds a script is allowed to run to infinity 
        set_time_limit(0);
        // Memory Limit for the script 
        ini_set('memory_limit', '2G');
        // Variable declaration and initialization 
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        // get placeholder detail for Graph .
        $getPlaceholderDetails = Page::getDatasourceGraphDetails($placeholderId);
        $getUserDetails = User::getUserDetails($_SESSION['UserID']); // Get User Detail 
        if ($getUserDetails && $getPlaceholderDetails) {
            // Processing for Axis and other info that will be used by Graph 
            $graphType = $getPlaceholderDetails[0]['GraphType'];
            $filterColumn = trim($getPlaceholderDetails[0]['Filters']);
            $getColumnsList = array();
            $graphTitle = '';
            $getColumnsList['xAxis'] = $getPlaceholderDetails[0]['XField'];
            $getColumnsList['yAxis'] = $getPlaceholderDetails[0]['YField'];
            if (isset($getPlaceholderDetails[0]['ZField']) && !empty($getPlaceholderDetails[0]['ZField'])) {
                $getColumnsList[''] = $getPlaceholderDetails[0]['ZField'];
            }
            $graphLabels['xAxis'] = $getPlaceholderDetails[0]['XFieldLabel'];
            $graphLabels['yAxis'] = $getPlaceholderDetails[0]['YFieldLabel'];
            if (isset($getPlaceholderDetails[0]['ZFieldLabel']) && !empty($getPlaceholderDetails[0]['ZFieldLabel'])) {
                $graphLabels['zAxis'] = $getPlaceholderDetails[0]['ZFieldLabel'];
            }
            $graphTitle = $getPlaceholderDetails[0]['HeadersText'];
            echo json_encode(array('graph_title' => $graphTitle, 'graph_labels' => $graphLabels, 'filter_column' => $filterColumn,
                'graph_data' => '', 'graph_type' => $graphType,));
        }
    }
}

?>