<?php

namespace Drupal\frontkom_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\system\Controller\Http4xxController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController
 *
 * @package Drupal\frontkom_test\Controller
 */
class MainController extends ControllerBase{

  public function test() {
    return new Response('frontkom test');
  }

  public function authorizedEditors()
  {
//    $httpController = new Http4xxController();
//    return $httpController->on403();

    $block_manager = \Drupal::service('plugin.manager.block');
    $plugin_block = $block_manager->createInstance('authorized_editors');

    return $plugin_block->build();
  }
}