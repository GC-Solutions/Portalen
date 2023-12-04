<?php

namespace App\Controllers\Admin\adminDatasource;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\DataSources;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\Addresses;
use \App\Models\AdminDBs;


/**
 * DataSource controller
 *
 * PHP version 7.0
 */
class DataSource extends \Core\Controller
{
	// Get all DataSouces 
	public function showDataSourceAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        View::render('administrator/placeholder/datasource_show.php', ['getDataSource' => $getDataSource]);
    }
    // show the form for dataSource add 
    public function addDataSourceAction()
    {
        $allExternalApiUrl = Addresses::getAllAddress();
       
        View::render('administrator/placeholder/add_source_api.php', ['allExternalApiUrl' => $allExternalApiUrl]);
    }
    // add function for database call in datasoucre .
    public function addDataSourceDatabaseAction()
    {
        $getAllAdminDB = AdminDBs::getAllAdminDB();
        View::render('administrator/placeholder/add_source_database.php', ['getAllAdminDB'=>$getAllAdminDB]);
    } 
    // New function when we create a datatsource for custom table in database .
    public function addDataSourceCustomDatabaseAction()
    {
        View::render('administrator/placeholder/add_source_custom_db.php', ['']);
    }
    // add function for get and post  call in datasoucre .
    public function addDataSourceGetPostAction()
    {
        View::render('administrator/placeholder/add_source_api_get_post.php', ['']);
    }
     // add function for post  call in datasoucre .
    public function addDataSourcePostAPIAction()
    {
        $allExternalApiUrl = Companies::getAll();
        View::render('administrator/placeholder/add_source_post_api.php', ['allExternalApiUrl' => $allExternalApiUrl]);
    }

    //Save the datasource
    public function saveDataSourceAction()
    {
        DataSources::addDataSource();
        header('Location: ' . baseUrl . 'data_source');
    }

    // show the form for adding the google api 
    public function addGoogleAPIAction()
    {
        View::render('administrator/placeholder/add_google_api.php', ['']);
    }
    // save google API Setting
    public function saveGoogleAPIAction()
    {
        Placeholder::addGoogleAPI();
        header('Location: ' . baseUrl . 'data_source');
    }
    // Function to Edit the dataSource
    public function editDataSourceAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getDataSourceDetails = DataSources::getDataSourceDetails($id);

        if ($getDataSourceDetails) {
            if ($getDataSourceDetails[0]['RequestType'] == 3) {
                 $getAllAdminDB = AdminDBs::getAllAdminDB();
                View::render('administrator/placeholder/add_source_database.php', ['dataSourceDetails' => $getDataSourceDetails[0] , 'getAllAdminDB' => $getAllAdminDB ] );
            }else  if ($getDataSourceDetails[0]['RequestType'] == 4) {
                View::render('administrator/placeholder/add_google_api.php', ['dataSourceDetails' => $getDataSourceDetails[0]]);
            }else if ($getDataSourceDetails[0]['updateDataSource'] == 1) {
                View::render('administrator/placeholder/add_source_api_get_post.php', ['dataSourceDetails' => $getDataSourceDetails[0]]);
            } else {
                $allExternalApiUrl = Addresses::getAllAddress();
                View::render('administrator/placeholder/add_source_api.php', ['dataSourceDetails' => $getDataSourceDetails[0] , 'allExternalApiUrl' => $allExternalApiUrl]);
            }
        } else {
            header('Location: ' . baseUrl . 'data_source');
        }

    }
    // Function for Copy dataSource
    public function copyDataSourceAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getDataSourceDetails = DataSources::getDataSourceDetails($id);
        $_REQUEST = $getDataSourceDetails;

        if ($getDataSourceDetails) {

            $_REQUEST = $getDataSourceDetails[0];
            $_REQUEST['Name'] =  $_REQUEST['Name'] . '-(copy)';
        }
        unset($_REQUEST['ID']);
        unset($_REQUEST['0']);
        DataSources::addDataSource();
        header('Location: ' . baseUrl . 'data_source');
    }
    //function to Delete the Datasource
    public function deleteDataSourceAction()
    {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        if ($id) {
            DataSources::deleteDataSource($id);
        }
        header('Location: ' . baseUrl . 'data_source');
    }

}