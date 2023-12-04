<?php

namespace App\Controllers\Admin\adminGeneral;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\DataSources;
use \App\Models\Page;
use \App\Models\Companies;
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class GenerateForm extends \Core\Controller
{
	public function addsendOrdersAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        View::render('administrator/placeholder/send_orders.php', ['getDataSource'=> $getDataSource]);
    }
    public function saveSendOrdersAction()
    {
        $saveData = $_REQUEST;
        $datasource = isset($saveData['DataSourceId'])?$saveData['DataSourceId']:'';
        if($datasource)
        {
            $datasource = implode(',', $datasource);
        }
        $saveData['DataSourceId'] = $datasource;
        Placeholder::addSendOrdersTable($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }

}