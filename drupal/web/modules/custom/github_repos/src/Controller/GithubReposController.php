<?php

namespace Drupal\github_repos\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Controller routines for fetching a user's Github repositories.
 */
class GithubReposController extends ControllerBase {

  /**
   * An injected instance of the Drupal\github_repos\GithubRepoService
   */
  protected $githubRepoService;

  /**
   * HINT: you'll need a constructor
   */

  /**
   * Fetches and returns the Github repositories for a user.
   *
   * @param  string $username
   *   The github username.
   *
   * @return array/FALSE
   *   An array of repositories with their info or FALSE if not found.
   */
  public function fetch_user_repositories($username) {
    $config = $this->config('github_repos.settings');

    try {
      return $this->githubRepoService->getUserRepos($username, $config->get('api'));
    }
    catch (RequestException $e) {
      watchdog_exception('github_repos', $e->getMessage());
      return FALSE;
    }
  }
}
