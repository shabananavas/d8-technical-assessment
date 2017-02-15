<?php

namespace Drupal\github_repos\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\github_repos\GithubReposService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A form class which collects and fetches the Github repositories of a user.
 */
class GithubReposSearchForm extends FormBase {

  /**
   * An instance of GithubRepoService
   */
  protected $githubRepoService;

  /**
   * {@inheritdoc}
   */
  public function __construct(GithubReposService $githubRepoService) {
    $this->githubRepoService = $githubRepoService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('github_repos.custom_client')
    );
  }

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
      try {
        $config = $this->config('github_repos.settings');
        // A call to our githubRepoService using dependency injection.
        $content = $this->githubRepoService->getUserRepos($form_state->getValue('username'), $config->get('api'));
        if ($content) {
          // Another call to our repo service to display the themed repos.
          return $this->githubRepoService->display_user_repositories($content);
        }
        // Else, if an error has occurred, display that.
        else {
          $form['repository_results'] = array(
            '#markup' => t('An error has occurred. Please check back later.')
          );
          return $form;
        }
      }
      catch (RequestException $e) {
        watchdog_exception('github_repos', $e->getMessage());
        return FALSE;
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
}
