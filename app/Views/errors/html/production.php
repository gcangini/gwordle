<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#234C80">
    <title>gWordle</title>
    <script defer src="https://www.gigini.it/fa/js/fontawesome.js"></script>
    <script defer src="https://www.gigini.it/fa/js/solid.js"></script>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
    <link rel="manifest" href="<?= base_url('gwordle.webmanifest') ?>"> 
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= base_url('img/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('img/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="gWordle" />
</head>
<body>

    <!-- HEADER -->
    <header class="app-header">
        <div class="header-left">
        </div>
        
        <div class="header-center">
            <h1><img src="<?= base_url('img/favicon.svg') ?>" class="logo"> gWordle</h1>
        </div>

        <div class="header-right">
        </div>
    </header>
    <!-- /HEADER -->

    <!-- MAIN -->
    <main class="container">

        <!-- ERROR PAGE -->
        <section id="view-error" class="active-view">
            <div class="card">
               <h2>Whoops !!</h2>
                There seems to be an error, sorry for that... please try again later.
            </div>
        </section>
        <!-- /ERROR PAGE -->

    </main>
    <!-- /MAIN -->

    <footer>
        <p>&copy; 2026 - <a href="https://www.gigini.it" target="_blank">gigini.it</a></p>
    </footer>
</body>
</html>
