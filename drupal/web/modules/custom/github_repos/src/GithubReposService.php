<?php

namespace Drupal\github_repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class GithubRepoService.
 *
 * @package Drupal\gitsearch
 */
class GithubReposService {

  /**
   * A Drupal HTTP Client
   */
  protected $client;

  /**
   * Constructor.
   */
  public function __construct() {
    $this->client = \Drupal::httpClient();
  }

  /**
   * Fetch the users repositories.
   *
   * @throws RequestException
   *
   * @return JSON data
   */
  public function getUserRepos($username, $api_url) {
    $response = $this->client->get($api_url . $username . '/repos');
    $content = json_decode($response->getBody()->getContents());
    return $content;
  }

  /**
   * Returns an array of Github repositories for a user in a themed fashion.
   *
   * @param string $content
   *   An array of Github repository info.
   *
   * @return array
   *   A themed array for displaying the user repositories.
   */
  public function display_user_repositories($content) {
    // Display the themed results.
    // First, let's pocess and get the user details from this info.
    $git_user_info = $this->get_git_user_info($content);
    // Now, display the themed info.
    $form['repository_results'] = array(
      '#theme' => 'display_repos',
      '#user_name' => $git_user_info['user_name'],
      '#user_url' => $git_user_info['user_url'],
      '#repos' => $content,
    );
    return $form;
  }

  /**
   * Function that goes through the repositories array and grabs the user info.
   *
   * @param array $content
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
