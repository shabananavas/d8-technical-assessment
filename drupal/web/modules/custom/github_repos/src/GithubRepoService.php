<?php

namespace Drupal\github_repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class GithubRepoService.
 *
 * @package Drupal\gitsearch
 */
class GithubRepoService {

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
   * Fetch the users repositories
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
}
