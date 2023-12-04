<?php

namespace App\Controllers\Admin\adminPagetemplate;

use \App\Models\PageTemplates;
use \Core\View;
use \App\Models\User;
use \App\Models\Menus;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class PageTemplate extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */


    public function showAction()
    {
        $getAllPages = PageTemplates::getPages();
        View::render('administrator/pagetemplates/show.php', ['getAllPages' => $getAllPages]);
    }

    public function addAction(){
        $pageId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getPageDetails = array();
        if ($pageId) {
            $getPageDetails = PageTemplates::getPageDetails($pageId);

            if($getPageDetails){
                $getPageDetails = $getPageDetails[0];
            }
        }
        View::render('administrator/pagetemplates/add.php', ['getPageDetails' => $getPageDetails]);
    }

    public function saveAction()
    {
        PageTemplates::savePage();
        header('Location: ' . baseUrl . 'pagetemplates');
    }

    public function deleteAction()
    {
        PageTemplates::deletePage($_REQUEST['id']);
        header('Location: ' . baseUrl . 'pagetemplates');
    }

    public function editAction()
    {
        $getUserDetails = User::getUserDetails($_REQUEST['id']);
        View::render('administrator/users/edit.php', ['getUserDetails' => $getUserDetails]);
    }

    public function updateAction(){
        User::updateUser();
        header('Location: ' . baseUrl . 'editcompany&id=' . $_REQUEST['CompanyID']);
    }


    public function pageAction()
    {
        echo "yes";
        exit;
    }
}
