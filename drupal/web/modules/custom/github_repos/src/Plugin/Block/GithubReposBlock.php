<?php

namespace Drupal\github_repos\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Search Github Repos' Block.
 *
 * @Block(
 *   id = "github_repos",
 *   admin_label = @Translation("Github Repos"),
 * )
 */
class GithubReposBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
 		$form = \Drupal::formBuilder()->getForm('Drupal\github_repos\Form\GithubReposSearchForm');
    return $form;
  }
}