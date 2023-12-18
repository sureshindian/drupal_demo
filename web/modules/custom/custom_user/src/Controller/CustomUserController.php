<?php

namespace Drupal\custom_user\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomUserController extends ControllerBase {


/**
   * Get the api url .
   */
 
//    protected $api_url;


//    public function __construct(){

//     $this->api_url = "https://dummyjson.com/products/1";

//    }


//    public function  getProduct(){
//     $result =  $this->api_url;
//     return [
//         '#title' => 'product',
//         '#theme' =>  'product',
//         '#data' =>  $result
//     ];

//    }

    public function  modalLink() {

        $build['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $build = [
            '#markup' => '<a href="/drupal_demo/web/get-user-details" class="use-ajax" data-dialog-type="modal">Click here</a>',
        ];
        return $build;
    } 


    public function customTemplate() {

        return [
            '#theme' => 'custom',
            '#data' => 'Welcome to our suresh Channel',
        ];

    }
}