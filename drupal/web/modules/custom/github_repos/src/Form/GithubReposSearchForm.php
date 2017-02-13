<?php

namespace Drupal\github_repos\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\github_repos\Controller\GithubReposController;

/**
 * A form class which collects and fetches the Github repositories of a user.
 */
class GithubReposSearchForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'github_repos_search';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Enter a username to search Github'),
      '#default_value' => 'shabananavas',
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );

    // Display the results nicely once the form submits in the same page.
    if ($form_state->getValue('username')) {
      // Fetch the content from our controller class.
      $repos_controller_class = new GithubReposController;
      $content = $repos_controller_class->fetch_user_repositories($form_state->getValue('username'));

      // If we have results, display the themed results.
      if ($content) {
        // First, let's pocess and get the user details from this info.
        $git_user_info = $this->get_git_user_info($content);
        // Now, display the themed info.
        $form['repository_results'] = array(
          '#theme' => 'display_repos',
          '#user_name' => $git_user_info['user_name'],
          '#user_url' => $git_user_info['user_url'],
          '#repos' => $content,
        );
      }
      // Else, if an error has occurred, display that.
      else {
        $form['repository_results'] = array(
          '#markup' => t('An error has occurred. Please check back later.'),
        );
      }
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Rebuild the form so we can show the results.
    $form_state->setRebuild();
  }

  /**
   * Function that goes through the repositories array and grabs the user info.
   *
   * @param  array $content
   *   The github repositories for a particular user.
   *
   * @return array
   *   The user github info.
   */
  public function get_git_user_info($content) {
    $output = '';

    // Just run once as all we need is the user info.
    foreach ($content as $key => $repo) {
      $user_name = $repo->owner->login;
      $user_url = $repo->owner->html_url;
      break;
    }

    return array(
      'user_name' => $user_name,
      'user_url' => $user_url,
    );
  }
}