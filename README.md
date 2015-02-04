# GithubAPI_Demo
Small demo for Sitepoint article.

##Installation
- Clone the repo to your computer.
- run `composer update` to update your packages.
- run `vagrant up` to create your vm. You can use `./artisan serve` if you are a laravel fan ;)
- Your hosts file should map (vaprobash.dev => 192.168.22.10)
- Create `.env` file in your root directory and update keys.
  - `GITHUB_EMAIL`. (Only when testing `/authorization` page).
  - `GITHUB_PASSWORD`. (Only when testing `/authorization` page).
  - `GITHUB_USERNAME`.
  - `GITHUB_TOKEN`.
