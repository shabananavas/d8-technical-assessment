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
    $client = \Drupal::httpClient();

    try {
      $response = $client->get($config->get('api') . $username . '/repos');
      $content = json_decode($response->getBody()->getContents());
      return $content;
    }
    catch (RequestException $e) {
      watchdog_exception('github_repos', $e->getMessage());
      return FALSE;
    }
  }
}