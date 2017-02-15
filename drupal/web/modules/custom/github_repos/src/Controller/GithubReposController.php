<?php

namespace Drupal\github_repos\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\github_repos\GithubReposService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for fetching a user's Github repositories.
 */
class GithubReposController extends ControllerBase {

  /**
   * An injected instance of the Drupal\github_repos\GithubReposService
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
   * Fetches and returns the Github repositories for a user.
   *
   * @param string $username
   *   The Github username.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *   If the parameters are invalid.
   *
   * @return html
   *   Displays a themed array of repositories with their info if the repo
   *   was successfully found.
   */
  public function fetch_user_repositories($username) {
    try {
      $config = $this->config('github_repos.settings');
      // A call to our githubRepoService using dependency injection.
      $content = $this->githubRepoService->getUserRepos($username, $config->get('api'));
      if ($content) {
        // Another call to our repo service to display the themed repos.
        return $this->githubRepoService->display_user_repositories($content);
      }
      // Else, if an error has occurred, display that.
      else {
        return drupal_set_message(t('An error has occurred. Please check back later.'));
      }
    }
    catch (RequestException $e) {
      watchdog_exception('github_repos', $e->getMessage());
      return drupal_set_message(t('An error has occurred. Please check back later.'));
    }
  }
}
