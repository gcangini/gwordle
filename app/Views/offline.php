<!DOCTYPE html>
<html lang="it">
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
            <h1>gWordle (offline)</h1>
        </div>

        <div class="header-right">
        </div>
    </header>
    <!-- /HEADER -->

  <!-- MAIN -->
    <main class="container">

        <!-- WORDS LIST PAGE -->
        <section id="view-lists" class="active-view">
            <div class="card">
               It seems that you're <i>OFFLINE</i> but you can still browsw words list<br>
                Select words:
                <div class="word-tags">
                    <span class="official"><input type="checkbox" id="check-official" checked onchange="printWords();"> Official</span>
                    <span class="ext"><input type="checkbox" id="check-ext" onchange="printWords();"> Extended</span>
                    <span class="wordle"><input type="checkbox" id="check-wordle" onchange="printWords();"> Past used</span> 
                </div>
                <div class="search-box">
                    <form action="<?= base_url('words') ?>" method="POST">
<?php
$search_label = "SEARCH";
if (isset($pattern)) {
    $search_label = "NEW SEARCH";
?>
                        pattern: <b><?= esc(strtoupper($pattern)) ?></b>
<?php } else { ?>
                        <input type="text" name="pattern" placeholder="RegExp Search..." required>
<?php } ?>
                        <button type="submit" class="btn btn-primary"><?= $search_label ?></button>
                    </form>
                </div>
            </div>
            <div class="card">
                <h2>Words List (<span id="word-num"></span>)</h2>
                <div class="list-container" id="word-list"></div>
            </div>

            <template id="word-template">
                <div class="list-item">
                    <span class="word"></span>
                    <span class="meta"></span>
                </div>
            </template>

        </section>
        <!-- /WORDS LIST PAGE -->

    </main>
    <!-- /MAIN -->

    <footer>
        <p>&copy; 2026 - <a href="https://www.gigini.it" target="_blank">gigini.it</a></p>
    </footer>

    <script src="<?= base_url('app.js') ?>"></script>

    <script>
        const words = <?php echo json_encode($words); ?>;
        console.table(words);

        function printWords() {
            const wl = document.getElementById('word-list');
            const template = document.getElementById('word-template');
            const num = document.getElementById('word-num');
            const c_official = document.getElementById('check-official').checked;
            const c_ext = document.getElementById('check-ext').checked;
            const c_wordle = document.getElementById('check-wordle').checked;

            // empty the list (useful for updates)
            wl.innerHTML = '';
            
            const fragment = document.createDocumentFragment();

            let count = 0;
            let add = false;
            words.forEach(item => {
                const clone = template.content.cloneNode(true);
    
                // select word and meta tags
                const word = clone.querySelector('.word');
                const meta = clone.querySelector('.meta');
                word.textContent = item.word;

                add = false;
                if (item.wordle) { // past used
                    if (c_wordle) {
                        word.classList.add('wordle');
                        meta.textContent = "#"+item.wordle+" • "+item.day;
                        add = true;
                    }
                } else if (item.ext == 1) { // extended
                    if (c_ext) {
                        word.classList.add('ext');
                        meta.textContent = "ext";
                        add = true;
                    }
                } else { // official
                    if (c_official) {
                        word.classList.add('official');
                        meta.textContent = "";
                        add = true;
                    }
                }

                if (add) {
                    fragment.appendChild(clone);
                    count++;
                }
            });
            wl.appendChild(fragment);
            num.innerHTML = count;
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize view
            printWords();
        });
    </script>

</body>
</html>
