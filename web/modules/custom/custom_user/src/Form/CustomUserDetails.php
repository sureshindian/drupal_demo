<?php 

namespace Drupal\custom_user\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Messenger\Messenger;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CustomUserDetails extends FormBase {

    public function getFormId(){

        return "custom_user_details";
    }


    public function buildForm(array $form,FormStateInterface $form_state){
        $form['#attached']['library'][] = "custom_user/customjsform";
        $form['username'] = [
            '#type' =>'textfield',
            '#title'=>'username',
            '#required' => true
        ];
        $form['usermail'] = [
            '#type' =>'email',
            '#title'=>'Email',
            '#required' => true
        ];
        $form['usergender'] = [
            '#type' =>'select',
            '#title'=>'Gender',
            '#required' => true,
            '#options'=>[
                'male'=>'Male',
                'female'=>'Female'
            ]
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' =>'submit',
            ];


            return $form;
        
    }


    public function  userFormValidation(){
        $response = new AjaxResponse();
        $response->addCommand(new InvokeCommand("html", 'datacheck'));
        return $response;
    }


    public function validateForm(array &$form, FormStateInterface $form_state) {

        // if (strlen($form_state->getValue('username')) < 6) {
        //     $form_state->setErrorByname('username', "please make sure your username length is more than 5");
        // }
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        \Drupal::messenger()->addMessage("User Details Submitted Successfully");
        $value  = $form_state->getValues();
       // dd($value);exit;
        $success = \Drupal::database()->insert('user_details')->fields([
            'name' => $value['username'],
            'mail' => $value['usermail'],
            'gender' => $value['usergender'],
        ])->execute();
        $url = Url::fromRoute('<front>');
        return new RedirectResponse($url->toString());
    }

      //  $form_state->setRedirectUrl(\Drupal::url::fromUri('internal:'.'/node/add/movies'));

    
}