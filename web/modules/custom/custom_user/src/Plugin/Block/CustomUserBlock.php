<?php 

namespace Drupal\custom_user\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Custom user block'  .
 *
 * @Block(
 *   id = "custom_user_block",
 *   admin_label = @Translation("Custom user block"),
 *   category = @Translation("Custom user block"),
 * )
 */

 class CustomUserBlock extends BlockBase implements ContainerFactoryPluginInterface {


/**
   * Get the api url .
   */
 
   protected $api_url;


     /**
     * @var AccountInterface $account
     */
protected $account;
/**
 * @param array $configuration
 * @param string $plugin_id
 * @param mixed $plugin_definition
 * @param Drupal\Core\Session\AccountInterface $account
 */

public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account) {
  parent::__construct($configuration, $plugin_id, $plugin_definition);
  $this->account = $account;
  $this->api_url = "https://dummyjson.com/products/1";
}


    /**
     * {@inheritdoc}
     */

     public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('current_user')
      );
    }


  public function build(){
    $prefix = $this->configuration['prefix'];
     $url = "https://dummyjson.com/products/1";//$this->api_url;

        $response  =  \Drupal::httpClient()->get($url);
        $jsondata =  $response->getBody()->getContents();
        $result = json_decode($jsondata); 
     
  //       $finaldata  = ['id'=>$result->id,'title'=>$result->title];
  // dd($finaldata);  exit;
        \Drupal::logger('custom_user')->error(" API  called");
   
    return [
      '#theme' => 'custom',
      '#data' => "hi suresh",
    ];

      // return [
      //   '#theme' => 'custom_user',
      //   '#data' => 'This is a block that was rendered with twig!',
      // ];
     
   
  }


    /**
     * {@inheritdoc}
     */

     protected function blockAccess(AccountInterface $account) {
      return AccessResult::allowedIfHasPermission($account, "d4drupal block access");
    }

    /**
     * {@inheritdoc}
     */

    public function defaultConfiguration() {
      return [
        'prefix' => "",
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
      $form['prefix'] = [
        '#type' => 'textfield',
        '#title' => 'Prefix Text',
        '#default_value' => $this->configuration['prefix'],
      ];
      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
      $this->configuration['prefix'] = $form_state->getValue('prefix');
    }
  

 }