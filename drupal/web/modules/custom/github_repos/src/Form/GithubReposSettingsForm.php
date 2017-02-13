<?php

namespace Drupal\github_repos\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure github_repos settings for this site.
 */
class GithubReposSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'github_repos_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'github_repos.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('github_repos.settings');

    $form['api'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Enter the Github API URL'),
      '#default_value' => $config->get('api'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config('github_repos.settings')
      // Set the submitted configuration setting.
      ->set('api', $form_state->getValue('api'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}