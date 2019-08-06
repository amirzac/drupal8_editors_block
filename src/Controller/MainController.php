<?php

namespace Drupal\frontkom_test\Controller;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\frontkom_test\Service\ErrorNotifier;
use Drupal\system\Controller\Http4xxController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Drupal\frontkom_test\Plugin\Block\EditorsBlock;

/**
 * Class MainController
 *
 * @package Drupal\frontkom_test\Controller
 */
class MainController extends ControllerBase {

  protected $errorNotifier;

  private $requestStack;

  private $pluginManager;

  public function __construct(
    ErrorNotifier $errorNotifier,
    RequestStack $requestStack,
    PluginManagerInterface $pluginManager
  ) {
    $this->errorNotifier = $errorNotifier;
    $this->requestStack = $requestStack;
    $this->pluginManager = $pluginManager;
  }

  public function test() {
    return new Response('frontkom test');
  }

  public function authorizedEditors() {
    /* @var \Drupal\node\Entity\Node $node */
    $node = $this->requestStack->getCurrentRequest()->get('node');

    /* @var EditorsBlock $editorsBlock */
    $editorsBlock = $this->pluginManager->createInstance('authorized_editors');

    return $this->errorNotifier->showAccessDeniedMessage(
      $node,
      new Http4xxController(),
      $editorsBlock,
      $this->currentUser()
    );
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    /* @var ErrorNotifier $errorNotifier */
    $errorNotifier = $container->get('frontkom_test:error_notifier');

    /* @var RequestStack $requestStack */
    $requestStack = $container->get('request_stack');

    /* @var PluginManagerInterface $pluginManager */
    $pluginManager = $container->get('plugin.manager.block');

    return new static($errorNotifier, $requestStack, $pluginManager);
  }

}
