Phase 2 - Requirements
========================

Good job with phase 1! You got most of the basics of the module donw well, and we have working software after just a few hours! Very happy with that.

For the next stesp, I'd like to push the envelope a bit. I've created a new class called GithubRepoService. I'd like you to do the following

# Change the controller to use this via Dependency Injection (so don't new it up in the controller class)
# Change the Menu router to use its own page, not rendering the form directly. Lets make the new route "/githubrepo/<username>"
# Change up the Form class to use dependency injection, rather than newing up the Controller in the form

I've hacked in some basics to get you started, but its by no means complete or tested. There could be imports required, bugs to fix, etc.

The overall goal here is to test the more advanced concept of Dependency Injection, and to test some basic OOP concepts.

Good luck!
