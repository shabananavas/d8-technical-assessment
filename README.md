# d8-technical-assessment

This installation contains the github_repos module which enables a user to search and retrieve the public repositories of a particular user using the Github API.
* Steps to enable this feature *
- Go to /admin/modules and enable the github_repos module
- Flush cache

* Configuration *
- You can configure the Github API by going here: /admin/config/github-repos/settings

* Search Page *
- You can search for a user's repositories from Github by going here: /admin/content/github-repos/search
- Enter the username in the search box and click 'Search' which will retrieve and display all the user's public repositories.

* Configuring Block *
- Go to /admin/structure/block and click on 'Place Block' next to which ever region and select the 'Github Repos' block and hit 'Place Block'
- This should now display the Github Repos search form in a block in the appropriate region.