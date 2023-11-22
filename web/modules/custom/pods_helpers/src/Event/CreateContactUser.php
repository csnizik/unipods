<?php

namespace Drupal\pods_helpers\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 */
class CreateContactUser implements EventSubscriberInterface {

  /**
   * The config.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $currentUser;

  /**
   * TimeZoneResolver constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(AccountInterface $current_user, ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->currentUser = $current_user;
  }

  public function onUserSet(AccountInterface $account = NULL) {
    if (!isset($account)) {
      $account = $this->currentUser;
    }
    \Drupal::logger('pods_helpers')->info('user set: %user', ['%user'=>$account ->getEmail()]);
  }

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      AccountEvents::SET_USER[] = ['onUserSet']
    ];
  }

}
