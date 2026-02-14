# gWordle

<!-- Template from https://github.com/othneildrew/Best-README-Template -->
<a id="readme-top"></a>
<!-- PROJECT SHIELDS -->
<!--
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/gcangini/gwordle">
    <img src="https://gwordle.gigini.it/img/favicon.svg" alt="Logo" width="160" height="160">
  </a>
  <h2 align="center">gWordle</h2>
  <p align="center">
    Wordle BOT &amp; Helper
    <br />
    <br />
    <a href="https://github.com/gcangini/gwordle/issues/new?template=bug_report_form.yml">Report Bug</a>
    &middot;
    <a href="https://github.com/gcangini/gwordle/issues/new?template=feature_request_form.yml">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>


<p align="right"><a href="#readme-top">🔼 top</a></p>

<!-- ABOUT THE PROJECT -->
## About The Project

Play Wordle against the bot, read words list or use gWordle Helper to halp you solve yout daily Wordle attempt.

<p align="right"><a href="#readme-top">🔼 top</a></p>

### Built With
- [![PHP][PHP]][PHP-url]
- [![CodeIgniter][CodeIgniter.com]][CodeIgniter-url]
- [![MariaDB]][MariaDB-url]
- [![Git]][Git-url]

<p align="right"><a href="#readme-top">🔼 top</a></p>

<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple example steps.

<p align="right"><a href="#readme-top">🔼 top</a></p>

### Prerequisites

A LAMP stack (Linux-Apache-Mysql-PHP).

<p align="right"><a href="#readme-top">🔼 top</a></p>

### Installation

1. create app skeleton with CodeIgniter
   ```sh
   composer create-project codeigniter4/appstarter gwordle
   cd gwordle
   chmod -R ug+w writable
   cp env .env
   ```
2. create and populate database (with SQL scripts)
3. configure baseURL and database in .env file
   ```sh
   vim .env
   ```
4. set $autoRoute = true; in Routing.php
   ```sh
   vim app/Config/Routing.php
   ```
5. comment home route in Routes.php
   ```sh
   vim app/Config/Routes.php
   ```
6. remove app files managed by git repository
   ```sh
   rm LICENSE
   rm README.md
   rm public/robots.txt
   rm app/Controllers/Home.php
   ```
7. Clone the repo (main branch)
   ```sh
   git clone https://github.com/gcangini/gwordle
   ```
8. Change git remote url to avoid accidental pushes to base project
   ```sh
   git remote set-url origin https://github.com/<YOUR_USER>/<YOUR_PROJECT>
   git remote -v # confirm the changes
   ```
9. configure sitemap.xml with your own URL
10. Enjoy :-)

<p align="right">(<a href="#readme-top">🔼 top</a>)</p>

<!-- ROADMAP -->
## Roadmap

- [ ] restricted area with access via Google login for users participating in the monthly private Wordle championship

See the [open issues](https://github.com/gcangini/gwordle/issues) for a full list of proposed features (and known issues).

<p align="right"><a href="#readme-top">🔼 top</a></p>


<!-- CONTRIBUTING -->
## Contributing

If you have a suggestion that would make this better, please fork the repo and create a pull request. Y
ou can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right"><a href="#readme-top">🔼 top</a></p>


<!-- LICENSE -->
## License

Distributed under the <a href="https://creativecommons.org/publicdomain/zero/1.0/" target="_blank"><b>Creative Commons CC0 1.0 Universal</b></a> license.
<img src="https://gwordle.gigini.it/img/CC_Zero_badge.svg" alt="Licence" width="80">

<p align="right"><a href="#readme-top">🔼 top</a></p>



<!-- CONTACT -->
## Contact

Gianlica Cangini - gcangini@hotmail.com

Project Link: [https://github.com/gcangini/gwordle](https://github.com/gcangni/gwordle)

Online web app: [https://gwordle.gigini.it](https://gwordle.gigini.it)

<p align="right"><a href="#readme-top">🔼 top</a></p>

<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* my friends who beta-tested the app (Cea, Linda, Fausto)
* <a href="https://www.fiveforks.com/wordle/" target="_blank">FiveForks Wordle page</a> that provide daily update of Past Used Wordle Words

<p align="right"><a href="#readme-top">🔼 top</a></p>

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
<!-- Shields.io badges. You can a comprehensive list with many more badges at: https://github.com/inttter/md-badges -->
[PHP]: https://img.shields.io/badge/php-%23777BB4.svg?&logo=php&logoColor=white
[PHP-url]: https://www.php.net
[CodeIgniter.com]: https://img.shields.io/badge/CodeIgniter-35495E?style=for-the-badge&logo=codeigniter
[CodeIgniter-url]: https://codeigniter.com/
[MariaDB]: https://img.shields.io/badge/MariaDB-003545?logo=mariadb&logoColor=white
[MariaDB-url]: https://mariadb.org/
[Git]: https://img.shields.io/badge/Git-F05032?logo=git&logoColor=fff
[Git-url]: https://github.com/