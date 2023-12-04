<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Core/Enviroment.php';

session_start();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

header('Access-Control-Allow-Origin: *'); 
/**
 * Routing
 */
$router = new Core\Router();
$client = new Google_Client();
$GLOBALS['client'] = $client;
$redis = new Redis();
$redis->pconnect('127.0.0.1', 32771);
$GLOBALS['redisClient'] =  $redis;
// Add the routes
$currentUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// RUle for API as it directly route it to Api.php page .
$router->add('portalAPI', ['controller' => 'Api', 'action' => 'ExternalAccess' , 'folder' => 'API']);
if ((strpos($currentUrl, 'portalAPI') !== false)) {
    $string = explode('/', $_SERVER['QUERY_STRING']);
    $router->add('{controller}/{action}');
    $router->dispatch($string[0]);
}

// Main 3 function that are called from home page 
$router->add('', ['controller' => 'Home', 'action' => 'index' , 'folder' => 'Home']);
$router->add('login', ['controller' => 'Login', 'action' => 'login' , 'folder' => 'Login']);
$router->add('logout', ['controller' => 'Login', 'action' => 'logout' , 'folder' => 'Login']);


$currentPageName = explode('&', urldecode($currentUrl));
$currentPageName = !empty($currentPageName[1])?$currentPageName[1]:'';
$currentPageName = explode('page_text=',$currentPageName);
$_SESSION['currentPageName'] = !empty($currentPageName[1])?$currentPageName[1]:'';
if ((strpos($currentUrl, 'login') !== false) || (strpos($currentUrl, 'logout') !== false)) {
    $router->add('{controller}/{action}');
    $router->dispatch($_SERVER['QUERY_STRING']);
}
// If user has logged in then the route .
if (isset($_SESSION) && isset($_SESSION['username']) && $_SESSION['password']) {
    $router->add('page', ['controller' => 'Home', 'action' => 'page' , 'folder' => 'Home']);
    $router->add('switchUser', ['controller' => 'Login', 'action' => 'switchUser' , 'folder' => 'Login']);
    $router->add('ImageSync', ['controller' => 'ImageSync', 'action' => 'SaveImageToDB' , 'folder' => 'Cron']);
    $router->add('ProductsCron', ['controller' => 'ProductsCron', 'action' => 'SaveProductsToDB' , 'folder' => 'Cron']);
    $router->add('dashboard', ['controller' => 'Home', 'action' => 'admindashboard' , 'folder' => 'Home']);
    $router->add('companies', ['controller' => 'Company', 'action' => 'show' , 'folder' => 'Admin\adminCompany']);
    $router->add('editcompany', ['controller' => 'Company', 'action' => 'edit' , 'folder' => 'Admin\adminCompany']);
    $router->add('updatecompany', ['controller' => 'Company', 'action' => 'update' , 'folder' => 'Admin\adminCompany']);
    $router->add('deletecompany', ['controller' => 'Company', 'action' => 'delete' , 'folder' => 'Admin\adminCompany']);
    $router->add('addcompany', ['controller' => 'Company', 'action' => 'add' , 'folder' => 'Admin\adminCompany']);
    $router->add('savecompany', ['controller' => 'Company', 'action' => 'save' , 'folder' => 'Admin\adminCompany']);

    $router->add('parameter', ['controller' => 'Parameters', 'action' => 'showParameter' , 'folder' => 'Admin\adminParameter']);

    $router->add('api', ['controller' => 'AdminApi', 'action' => 'showAllAPI' , 'folder' => 'API']);

    $router->add('address', ['controller' => 'Address', 'action' => 'showAddress' , 'folder' => 'Admin\adminAddress']);
    $router->add('addAddress', ['controller' => 'Address', 'action' => 'addAddress' , 'folder' => 'Admin\adminAddress']);
    $router->add('saveAddress', ['controller' => 'Address', 'action' => 'saveAddress' , 'folder' => 'Admin\adminAddress']);
    $router->add('deleteAddress', ['controller' => 'Address', 'action' => 'deleteAddress' , 'folder' => 'Admin\adminAddress']);

    $router->add('adminDB', ['controller' => 'AdminDB', 'action' => 'showAdminDB' , 'folder' => 'Admin\adminDB']);
    
    $router->add('addAdminDB', ['controller' => 'AdminDB', 'action' => 'addAdminDB' , 'folder' => 'Admin\adminDB']);

    $router->add('saveAdminDB', ['controller' => 'AdminDB', 'action' => 'saveAdminDB' , 'folder' => 'Admin\adminDB']);

    $router->add('deleteAdminDB', ['controller' => 'AdminDB', 'action' => 'deleteAdminDB' , 'folder' => 'Admin\adminDB']);


    $router->add('images', ['controller' => 'Image', 'action' => 'showImages' , 'folder' => 'Admin\adminImage']);

    $router->add('addImages', ['controller' => 'Image', 'action' => 'addImages' , 'folder' => 'Admin\adminImage']);

    $router->add('saveImage', ['controller' => 'Image', 'action' => 'saveImage' , 'folder' => 'Admin\adminImage']);

    $router->add('deleteImages', ['controller' => 'Image', 'action' => 'deleteImages' , 'folder' => 'Admin\adminImage']);
    
    $router->add('saveproduct', ['controller' => 'Product', 'action' => 'saveproduct' , 'folder' => 'Admin\adminProduct']);
    $router->add('addproduct', ['controller' => 'Product', 'action' => 'addproduct' , 'folder' => 'Admin\adminProduct']);


    $router->add('addparameter', ['controller' => 'Parameters', 'action' => 'add' , 'folder' => 'Admin\adminParameter']);
    $router->add('editparameter', ['controller' => 'Parameters', 'action' => 'add' , 'folder' => 'Admin\adminParameter']);
    $router->add('saveparameter', ['controller' => 'Parameters', 'action' => 'save' , 'folder' => 'Admin\adminParameter']);
    $router->add('deleteparameter', ['controller' => 'Parameters', 'action' => 'delete' , 'folder' => 'Admin\adminParameter']);
    
    $router->add('addApi', ['controller' => 'AdminApi', 'action' => 'addApi'  , 'folder' => 'API']);
    $router->add('saveApi', ['controller' => 'AdminApi', 'action' => 'saveApi' , 'folder' => 'API']);
    $router->add('deleteAPI', ['controller' => 'AdminApi', 'action' => 'delete' , 'folder' => 'API']);

    $router->add('dataTableDesign', ['controller' => 'DataTableDesign', 'action' => 'showdataTableDesign'  , 'folder' => 'DataTableDesign']);
    $router->add('saveFilterWidth', ['controller' => 'DataTableDesign', 'action' => 'saveFilterWidth' , 'folder' => 'DataTableDesign']);
    $router->add('addFilterWidth', ['controller' => 'DataTableDesign', 'action' => 'addFilterWidth' , 'folder' => 'DataTableDesign']);
    $router->add('deleteFilterWidth', ['controller' => 'DataTableDesign', 'action' => 'delete' , 'folder' => 'DataTableDesign']);


    
    $router->add('adduser', ['controller' => 'Users', 'action' => 'add' , 'folder' => 'Admin\adminUser']);
    $router->add('saveuser', ['controller' => 'Users', 'action' => 'save' , 'folder' => 'Admin\adminUser']);
    $router->add('deleteuser', ['controller' => 'Users', 'action' => 'delete' , 'folder' => 'Admin\adminUser']);
    $router->add('edituser', ['controller' => 'Users', 'action' => 'edit' , 'folder' => 'Admin\adminUser']);
    $router->add('updateUser', ['controller' => 'Users', 'action' => 'update' , 'folder' => 'Admin\adminUser']);
    $router->add('copyUserSettings', ['controller' => 'Users', 'action' => 'copyUserSettings' , 'folder' => 'Admin\adminUser']);

    $router->add('userpageaccess', ['controller' => 'PageAccess', 'action' => 'show' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('deleteuserpageaccess', ['controller' => 'PageAccess', 'action' => 'delete' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('pagepanels', ['controller' => 'PageAccess', 'action' => 'Pagepanels' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('deleteplaceholder', ['controller' => 'PageAccess', 'action' => 'deleteplaceholder' , 'folder' => 'Admin\adminPageaccess']);
    $router->add('deleteForm', ['controller' => 'PageAccess', 'action' => 'deleteForm' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('addplaceholderaccess', ['controller' => 'PageAccess', 'action' => 'addplaceholderaccess' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('saveplaceholderaccess', ['controller' => 'PageAccess', 'action' => 'saveplaceholderaccess' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('addnewpageaccess', ['controller' => 'PageAccess', 'action' => 'add', 'folder' => 'Admin\adminPageaccess']);

    $router->add('saveuserpageaccess', ['controller' => 'PageAccess', 'action' => 'save' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('addplaceholderbytype', ['controller' => 'PageAccess', 'action' => 'addPlaceHolderByType' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('saveuserpageplaceholders', ['controller' => 'PageAccess', 'action' => 'saveUserPagePlaceholders' , 'folder' => 'Admin\adminPageaccess']);

     $router->add('saveuserfiltertable', ['controller' => 'PageAccess', 'action' => 'saveUserFilterTable' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('deleteuserpageplaceholder', ['controller' => 'PageAccess', 'action' => 'deleteUserPagePlaceholder' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('edituserpageaccess', ['controller' => 'PageAccess', 'action' => 'editUserPageAccess' , 'folder' => 'Admin\adminPageaccess']);

    $router->add('edituserpageplaceholder', ['controller' => 'PageAccess', 'action' => 'editUserPagePlaceholder' , 'folder' => 'Admin\adminPageaccess']);
    
  
    $router->add('placeholders', ['controller' => 'Placeholders', 'action' => 'show' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('deleteplaceholder', ['controller' => 'Placeholders', 'action' => 'delete' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('addplaceholder', ['controller' => 'Placeholders', 'action' => 'add' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('saveplaceholder', ['controller' => 'Placeholders', 'action' => 'save' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('editplaceholder', ['controller' => 'Placeholders', 'action' => 'edit' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('copyplaceholder', ['controller' => 'Placeholders', 'action' => 'copyplaceholder' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('updateplaceholder', ['controller' => 'Placeholders', 'action' => 'update' , 'folder' => 'Admin\adminPlaceholder']);
    // $router->add('parameter', ['controller' => 'Parameter', 'action' => 'showDataSource']);
    $router->add('data_source', ['controller' => 'DataSource', 'action' => 'showDataSource' , 'folder' => 'Admin\adminDatasource']);
    $router->add('add_data_source', ['controller' => 'DataSource', 'action' => 'addDataSource' , 'folder' => 'Admin\adminDatasource']);
    $router->add('add_data_source_get_post', ['controller' => 'DataSource', 'action' => 'addDataSourceGetPost' , 'folder' => 'Admin\adminDatasource']);
    $router->add('add_data_source_post_api', ['controller' => 'DataSource', 'action' => 'addDataSourcePostAPI' , 'folder' => 'Admin\adminDatasource']);
    $router->add('add_google_api', ['controller' => 'DataSource', 'action' => 'addGoogleAPI' , 'folder' => 'Admin\adminDatasource']);
    $router->add('add_data_source_database', ['controller' => 'DataSource', 'action' => 'addDataSourceDatabase' , 'folder' => 'Admin\adminDatasource']);

    $router->add('add_data_source_custom_db', ['controller' => 'DataSource', 'action' => 'addDataSourceCustomDatabase' , 'folder' => 'Admin\adminDatasource']);

    $router->add('saveDataSource', ['controller' => 'DataSource', 'action' => 'saveDataSource' , 'folder' => 'Admin\adminDatasource']);
    $router->add('edit_data_source', ['controller' => 'DataSource', 'action' => 'editDataSource' , 'folder' => 'Admin\adminDatasource']);
    $router->add('copy_data_source', ['controller' => 'DataSource', 'action' => 'copyDataSource' , 'folder' => 'Admin\adminDatasource']);
    $router->add('delete_data_source', ['controller' => 'DataSource', 'action' => 'deleteDataSource' , 'folder' => 'Admin\adminDatasource']);

    $router->add('add_panel', ['controller' => 'PanelPlaceholder', 'action' => 'addPanel' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('savePanel', ['controller' => 'PanelPlaceholder', 'action' => 'savePanel' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('editplaceholder', ['controller' => 'Placeholders', 'action' => 'editplaceholder' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('deleteplaceholder', ['controller' => 'Placeholders', 'action' => 'deletePlaceholders' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_table', ['controller' => 'TablePlaceholder', 'action' => 'addTable' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_join_table', ['controller' => 'TablePlaceholder', 'action' => 'addJoinTable' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_table', ['controller' => 'TablePlaceholder', 'action' => 'saveTable' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_new_table', ['controller' => 'TablePlaceholder', 'action' => 'saveNewTable' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_graph', ['controller' => 'GraphPlaceholder', 'action' => 'addGraph' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_graph', ['controller' => 'GraphPlaceholder', 'action' => 'saveGraph' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_maps', ['controller' => 'MapPlaceholder', 'action' => 'addMaps' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_maps', ['controller' => 'MapPlaceholder', 'action' => 'saveMaps' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_piechart', ['controller' => 'PieChartPlaceholder', 'action' => 'addPiechart' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_piechart', ['controller' => 'PieChartPlaceholder', 'action' => 'savePiechart', 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_table_actions', ['controller' => 'TablePlaceholder', 'action' => 'addTableActions' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_table_actions', ['controller' => 'TablePlaceholder', 'action' => 'saveTableActions' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_panel_actions', ['controller' => 'PanelPlaceholder', 'action' => 'addPanelActions' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_panel_action', ['controller' => 'PanelPlaceholder', 'action' => 'savePanelActions' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_graph_actions', ['controller' => 'GraphPlaceholder', 'action' => 'addGraphActions' , 'folder' => 'Admin\adminPlaceholder']);
    
    $router->add('add_mongodb', ['controller' => 'ProductExtraInfoForm', 'action' => 'addMongodb' , 'folder' => 'Admin\adminGeneral']);

    $router->add('save_mongodb', ['controller' => 'ProductExtraInfoForm', 'action' => 'saveMongodb' , 'folder' => 'Admin\adminGeneral']);
    $router->add('add_sendOrders', ['controller' => 'GenerateForm', 'action' => 'addsendOrders' , 'folder' => 'Admin\adminGeneral']);
    $router->add('save_SendOrders', ['controller' => 'GenerateForm', 'action' => 'saveSendOrders' , 'folder' => 'Admin\adminGeneral']);
    $router->add('add_Childrow', ['controller' => 'TablePlaceholder', 'action' => 'addChildRow' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_Childrow', ['controller' => 'TablePlaceholder', 'action' => 'saveChildRow' , 'folder' => 'Admin\adminPlaceholder']);
    
    $router->add('add_dynamic_form', ['controller' => 'TablePlaceholder', 'action' => 'addDynamicForm' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_DynamicForm', ['controller' => 'TablePlaceholder', 'action' => 'saveDynamicForm' , 'folder' => 'Admin\adminPlaceholder']);
    
    $router->add('add_silder_table', ['controller' => 'TablePlaceholder', 'action' => 'addSliderTable' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('save_slider_table', ['controller' => 'TablePlaceholder', 'action' => 'saveSliderTable' , 'folder' => 'Admin\adminPlaceholder']);
    

    $router->add('getDataSourceColumns', ['controller' => 'FetchDataAdmin', 'action' => 'getDataSourceColumns' , 'folder' => 'Admin\adminGeneral']);

    $router->add('getCompanyUser', ['controller' => 'FetchDataAdmin', 'action' => 'getCompanyUser' , 'folder' => 'Admin\adminGeneral']);

    $router->add('getDataTableColumns', ['controller' => 'FetchDataAdmin', 'action' => 'getDataTableColumns' , 'folder' => 'Admin\adminGeneral']);
    $router->add('getDataSource', ['controller' => 'FetchDataAdmin', 'action' => 'getallDataSource' , 'folder' => 'Admin\adminGeneral']);
    $router->add('getDataSourceTableTemplates', ['controller' => 'FetchDataAdmin', 'action' => 'getDataSourceTableTemplates' , 'folder' => 'Admin\adminGeneral']);
    $router->add('getDataSourcePanelTemplates', ['controller' => 'FetchDataAdmin', 'action' => 'getDataSourcePanelTemplates' , 'folder' => 'Admin\adminGeneral']);

    $router->add('pagetemplates', ['controller' => 'PageTemplate', 'action' => 'show' , 'folder' => 'Admin\adminPagetemplate']);
    $router->add('addpagetemplate', ['controller' => 'PageTemplate', 'action' => 'add' , 'folder' => 'Admin\adminPagetemplate']);
    $router->add('savepagetemplate', ['controller' => 'PageTemplate', 'action' => 'save' , 'folder' => 'Admin\adminPagetemplate']);
    $router->add('deletepage', ['controller' => 'PageTemplate', 'action' => 'delete' , 'folder' => 'Admin\adminPagetemplate']);
    $router->add('ExcelUpload', ['controller' => 'UpdateForm', 'action' => 'ExcelUpload' , 'folder' => 'DataTables']);
    $router->add('PDFUpload', ['controller' => 'UpdateForm', 'action' => 'PDFUpload' , 'folder' => 'DataTables']);
	$router->add('FileDelete', ['controller' => 'UpdateForm', 'action' => 'FileDelete' , 'folder' => 'DataTables']);
  
   
    // Not used yet 
    $router->add('getPageText', ['controller' => 'DataTables', 'action' => 'getPageText']); // public link
    $router->add('getTableActionDetailsById', ['controller' => 'DataTables', 'action' => 'getTableActionDetailsById']); // public link

    
    $router->add('getTableColumns', ['controller' => 'DataTableColumn', 'action' => 'getTableColumns'  , 'folder' => 'DataTables']);

    $router->add('getPanelInformation', ['controller' => 'Panels', 'action' => 'getPanelInformation' , 'folder' => 'Panels']);
    $router->add('getPanelData', ['controller' => 'Panels', 'action' => 'getPanelData' , 'folder' => 'Panels']);
  
    $router->add('generateTable', ['controller' => 'DataTables', 'action' => 'generateTable' , 'folder' => 'DataTables']);

    $router->add('generateJoinTable', ['controller' => 'DataTableJoinTable', 'action' => 'generateJoinTable' , 'folder' => 'DataTables']);

    $router->add('csvupload', ['controller' => 'Csvupload', 'action' => 'csvUpload' , 'folder' => 'CsvUpload']);
    
    $router->add('generateReadTable', ['controller' => 'Product', 'action' => 'generateReadTable' , 'folder' => 'DataTables']);
    $router->add('generateMapData', ['controller' => 'Maps', 'action' => 'generateMapData' , 'folder' => 'Maps' ]);
    // Check if these function works 
    $router->add('addTable', ['controller' => 'OldCode', 'action' => 'addTable' , 'folder' => 'DataTables']);
    $router->add('updateTable', ['controller' => 'OldCode', 'action' => 'updateTable' , 'folder' => 'DataTables']);
    $router->add('createCustomer', ['controller' => 'OldCode', 'action' => 'createCustomer' ,  'folder' => 'DataTables']);
    $router->add('updateCustomers', ['controller' => 'OldCode', 'action' => 'updateCustomers' ,  'folder' => 'DataTables']);
    
    $router->add('objectDetails', ['controller' => 'OldCode', 'action' => 'objectDetails' , 'folder' => 'DataTables']);
    $router->add('executeQuery', ['controller' => 'OldCode', 'action' => 'executeQuery' , 'folder' => 'DataTables']);

    $router->add('dbDataTable', ['controller' => 'OldCode', 'action' => 'dbDataTable', 'folder' => 'DataTables']);
    $router->add('detailTable', ['controller' => 'OldCode', 'action' => 'detailTable', 'folder' => 'DataTables']);
    $router->add('dbTableDetails', ['controller' => 'OldCode', 'action' => 'dbTableDetails' , 'folder' => 'DataTables']);
    $router->add('TableDbChart', ['controller' => 'OldCode', 'action' => 'TableDbChart' , 'folder' => 'DataTables']);
    $router->add('TableApiChart', ['controller' => 'OldCode', 'action' => 'TableApiChart', 'folder' => 'DataTables']);
     //////////////////////////////////////
    $router->add('showMapDetails', ['controller' => 'Maps', 'action' => 'showMapDetails' , 'folder' => 'Maps' , 'folder' => 'Maps']);
    
    // Start call for updateform Data
    $router->add('getUpdateForm', ['controller' => 'UpdateForm', 'action' => 'getUpdateForm' , 'folder'=>'DataTables']);
    
    $router->add('placeholderUpdateForm', ['controller' => 'UpdateForm', 'action' => 'placeholderUpdateForm' , 'folder' => 'DataTables']);
   
    $router->add('updatePredefined', ['controller' => 'UpdateForm', 'action' => 'updatePredefined' , 'folder' => 'DataTables']);
   
    $router->add('updateDataSourceCall', ['controller' => 'UpdateForm', 'action' => 'updateDataSourceCall'  , 'folder' => 'DataTables']);
   
    // Start call for Download PDF
    $router->add('downloadPdf', ['controller' => 'DownloadPDF', 'action' => 'downloadPdf', 'folder' => 'DataTables']);
    // End call for Download PDF
   
    // Start call for Porducts 
    $router->add('AddMoreInfo', ['controller' => 'Product', 'action' => 'AddMoreInfo' , 'folder' => 'DataTables']);

 
    $router->add('saveDataToMongoDB', ['controller' => 'Product', 'action' => 'saveDataToMongoDB' ,  'folder' => 'DataTables' ]);
    // End call for Porducts 
     // Start call for Send Orders 
    $router->add('SendOrdersData', ['controller' => 'SendForm',  'action' => 'SendOrderData' ,'folder' => 'DataTables']);
    $router->add('generateSendOrdersData', ['controller' => 'SendForm', 'action' => 'generateSendOrdersData' , 'folder' => 'DataTables']);
     // Start call for Send Orders 
    
    $router->add('generateGraphDataHighChart', ['controller' => 'Graphs', 'action' => 'generateGraphDataHighChart' , 'folder' => 'Graphs']);
    $router->add('generatePieChartData', ['controller' => 'Graphs', 'action' => 'generatePieChartData' , 'folder' => 'Graphs']);
    $router->add('generateGraphData', ['controller' => 'Graphs', 'action' => 'generateGraphData' , 'folder' => 'Graphs']);
       // Start call for Google Api
    
    $router->add('generateAccessToken', ['controller' => 'GoogleAPI', 'action' => 'getAccessToken' , 'folder' => 'Google']);
    // start Part for 2 Tables Admin Side
    $router->add('twoTable', ['controller' => 'TwoTable', 'action' => 'showAllTwoTables' , 'folder' => 'Admin\adminTwotable']);
    $router->add('addtwotable', ['controller' => 'TwoTable', 'action' => 'addTwoTables' , 'folder' => 'Admin\adminTwotable']);

    $router->add('saveTwoTable', ['controller' => 'TwoTable', 'action' => 'saveTwoTables' , 'folder' => 'Admin\adminTwotable']);
    
    $router->add('deletetwotables', ['controller' => 'TwoTable', 'action' => 'deleteTwoTables' , 'folder' => 'Admin\adminTwotable']);
     // start  for Push Notification
     $router->add('pushNotification', ['controller' => 'PushNotification', 'action' => 'showPushNotification' , 'folder' => 'Admin\adminPushNotification']);
     $router->add('addPushNotification', ['controller' => 'PushNotification', 'action' => 'addPushNotification' , 'folder' => 'Admin\adminPushNotification']);
     $router->add('savePushNotification', ['controller' => 'PushNotification', 'action' => 'savePushNotification' , 'folder' => 'Admin\adminPushNotification']);
     
     //$router->add('deletetwotables', ['controller' => 'TwoTable', 'action' => 'deleteTwoTables' , 'folder' => 'Admin\adminTwotable']);
 
    // Start Call for setting Sesion for JS 
    $router->add('setSession', ['controller' => 'SessionSetter', 'action' => 'setSession' , 'folder' => 'SessionSetter']);
    $router->add('getSession', ['controller' => 'SessionSetter', 'action' => 'getSession' , 'folder' => 'SessionSetter']);
    $router->add('setSessionFilter', ['controller' => 'SessionSetter', 'action' => 'setSessionFilter' , 'folder' => 'SessionSetter']);
    
    $router->add('SaveFilterSession', ['controller' => 'SessionSetter', 'action' => 'SaveFilterSession' , 'folder' => 'SessionSetter']);
   
    $router->add('LiveImgSync', ['controller' => 'LiveImgSync', 'action' => 'LiveImgSync' , 'folder' => 'Cron']);
    $router->add('DownloadXML', ['controller' => 'XMLDownload', 'action' => 'XMLDownload' , 'folder' => 'Cron']);
    
    $router->add('AddPayment', ['controller' => 'Payment', 'action' => 'AddPayment' , 'folder' => 'DataTables']);
    $router->add('ClearFilter', ['controller' => 'SearchFilter', 'action' => 'DeleteSearch' , 'folder' => 'DataTables']);
    $router->add('SaveFilter', ['controller' => 'SearchFilter', 'action' => 'SaveSearch' , 'folder' => 'DataTables']);

    $router->add('generateExcelPivotTable', ['controller' => 'PivotTable', 'action' => 'GenerateExcelPivotTable' , 'folder' => 'DataTables']);
	$router->add('SaveExcel', ['controller' => 'PivotTable', 'action' => 'SaveExcel' , 'folder' => 'DataTables']);
    
    
    $router->add('getSpecficPaymentCustomer', ['controller' => 'Payment', 'action' => 'getSpecficPaymentCustomer' , 'folder' => 'DataTables']);
    $router->add('LiveReportSync', ['controller' => 'LiveImgSync', 'action' => 'LiveReportSync' , 'folder' => 'Cron']);
    $router->add('GetData', ['controller' => 'LiveImgSync', 'action' => 'LiveAPIReportSync' , 'folder' => 'Cron']);
    
    $router->add('add_column_setting', ['controller' => 'TablePlaceholder', 'action' => 'addColumSetting' , 'folder' => 'Admin\adminPlaceholder']);
    
    $router->add('save_column_setting', ['controller' => 'TablePlaceholder', 'action' => 'saveColumnSetting' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('delete_column_setting', ['controller' => 'TablePlaceholder', 'action' => 'deleteColumnSetting' , 'folder' => 'Admin\adminPlaceholder']);
    $router->add('add_new_table', ['controller' => 'TablePlaceholder', 'action' => 'addNewTable' , 'folder' => 'Admin\adminPlaceholder']);
    
    

} else {
    if ($currentUrl != baseUrl) {
        header('Location: ' . baseUrl);
        exit;
    }
}
$router->add('{controller}/{action}');
$router->dispatch($_SERVER['QUERY_STRING']);