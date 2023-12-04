<?php

namespace App\Controllers\Admin\adminProduct;

use \Core\View;

use \App\Models\Products;
/**
 * DataTables controller
 *
 * PHP version 7.0
 */
class Product extends \Core\Controller
{

	public function saveproduct(){

	    Products::addProduct();
	    View::render('administrator/product/getallProducts.php', []);
	}
 	public function addproduct(){
    
    	View::render('administrator/product/add.php', []);
  	}

  	public function addproduct(){
    
    	View::render('administrator/product/add.php', []);
  	}

}
?>