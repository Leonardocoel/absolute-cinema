# Absolute Cinema

[![Contributors][contributors-shield]][contributors-url]
[![Pull Requests][pull-requests-shield]][pull-requests-url]
[![Issues][issues-shield]][issues-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]

<details>
  <summary>Table of Contents</summary>
 <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#technologies">Technologies</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#setup">Setup</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
     <ul>
        <li><a href="#routes">Routes</a></li>
        <li><a href="#tests">Tests</a></li>
      </ul>
  </ol>
</details>

## About The Project

#### Technologies

![PHP][php]
![Laravel][laravel]
![Vue.js][vue.js]
![NodeJS][nodejs]
![Postgres][postgres]
![Tailwind][tailwindCSS]

</details>

## Getting Started

### Prerequisites

- Docker
- Docker Compose
- Local: PHP 8.2 - Node 20 - Postgres 15

### Setup

- Clone the repository and switch to it:

        git clone https://github.com/Leonardocoel/absolute-cinema && cd absolute-cinema

- Installing Composer Dependencies:

        docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs

- Configure .env:

        copy or rename .env.example to .env and configure database

- Start Sail in the background:

        ./vendor/bin/sail up -d

- Configuring A Shell Alias (Optional):

        alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

-
        sail up -d

- Migrate and seed the database:

        sail php artisan migrate --seed

- Start Node

        npm run dev

## Usage

### Routes

- Root admin (super admin):

    email

        root_admin@mail.com

    password

        password 

- Cinema admin:

    email

        cinema@mail.com

    password

        password 

- End user (WORK IN PROGRESS) :

    email

        usuario@mail.com

    password

        password 

### Tests

[⬆ Back to top](#absolute-cinema)<br>

<!-- MARKDOWN LINKS & IMAGES -->

[contributors-shield]: https://img.shields.io/github/contributors/Leonardocoel/absolute-cinema?style=for-the-badge
[contributors-url]: https://github.com/Leonardocoel/absolute-cinema/graphs/contributors
[pull-requests-shield]: https://img.shields.io/github/issues-pr/Leonardocoel/absolute-cinema?style=for-the-badge
[pull-requests-url]: https://github.com/Leonardocoel/absolute-cinema/pulls
[forks-shield]: https://img.shields.io/github/forks/Leonardocoel/absolute-cinema?style=for-the-badge
[forks-url]: https://github.com/Leonardocoel/
[stars-shield]: https://img.shields.io/github/stars/Leonardocoel/absolute-cinema?style=for-the-badge
[stars-url]: https://github.com/Leonardocoel/
[issues-shield]: https://img.shields.io/github/issues/Leonardocoel/absolute-cinema?style=for-the-badge
[issues-url]: https://github.com/Leonardocoel/
[nodejs]: https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=nodedotjs&logoColor=white
[php]:https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white
[laravel]:https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white
[postgres]:https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white
[vue.js]:https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D
[tailwindCSS]:https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white
