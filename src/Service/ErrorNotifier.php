<?php

namespace Drupal\frontkom_test\Service;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\system\Controller\Http4xxController;

/**
 * Class ErrorNotifier
 *
 * @package Drupal\frontkom_test\Service
 */
class ErrorNotifier {

  public function showAccessDeniedMessage(
    ?Node $node,
    Http4xxController $http4xxController,
    BlockPluginInterface $blockPlugin,
    AccountInterface $accountProxy
  ):iterable
  {
    $nodeTypeIsPage = ($node->getType() === 'page');
    $nodeIsEntity = ($node instanceof Node);

    if ($accountProxy->isAuthenticated() && $nodeIsEntity && $nodeTypeIsPage) {
      return $blockPlugin->build();
    }

    return $http4xxController->on403();
  }

}
