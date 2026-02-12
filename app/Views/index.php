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
            <h1>gWordle</h1>
        </div>

        <div class="header-right">
            <button onclick="toggleMenu()" class="icon-btn" aria-label="Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>
    <!-- /HEADER -->

    <!-- MENU -->
    <nav id="side-menu" class="side-menu">
        <button class="close-btn" onclick="toggleMenu()">✕</button>
        <ul>
            <li><a href="#" onclick="router('game'); toggleMenu()"><i class="fa-solid fa-robot"></i> BOT play</a></li>
            <li><a href="#" onclick="router('list'); toggleMenu()"><i class="fa-solid fa-list"></i> Words List</a></li>
            <li><a href="#" onclick="router('helper'); toggleMenu()"><i class="fa-solid fa-question"></i> Helper</a></li>
        </ul>
    </nav>
    <!-- /MENU -->

    <!-- MAIN -->
    <main class="container">

        <!-- BOT PAGE -->
        <section id="view-game" class="hidden-view">
            <div class="card">
                <h2><i class="fa-solid fa-robot"></i> BOT play</h2>
                <div class="wordle-grid">
                    <div class="row">
                        <div class="tile gray">A</div>
                        <div class="tile green">R</div>
                        <div class="tile gray">O</div>
                        <div class="tile gray">S</div>
                        <div class="tile yellow">E</div>
                    </div>
                    <div class="row">
                        <div class="tile gray">T</div>
                        <div class="tile green">R</div>
                        <div class="tile gray">I</div>
                        <div class="tile green">E</div>
                        <div class="tile gray">D</div>
                    </div>
                    <div class="row">
                        <div class="tile green">C</div>
                        <div class="tile green">R</div>
                        <div class="tile green">E</div>
                        <div class="tile green">E</div>
                        <div class="tile green">P</div>
                    </div>
                </div>
                
                <p class="result-text">Played with word <b>CREEP</b></p>
                
                <div class="actions">
                    <button onclick="shareWhatsApp()" class="btn btn-whatsapp">
                        <i class="fa-solid fa-share-nodes"></i> share on WhatsApp
                    </button>
                </div>
            </div>

            <div class="card new-game-card">
                <h3>New game</h3>
                <form action="/" method="GET" class="inline-form">
                    <input type="text" name="word" minlength="5" maxlength="5" placeholder="Insert new word..." required>
                    <button type="submit" class="btn btn-primary">PLAY</button>
                </form>
            </div>
        </section>
        <!-- /BOT PAGE -->

        <!-- HELPER PAGE -->
        <section id="view-helper" class="hidden-view">
            <form action="<?= base_url('helper') ?>" method="POST" id="helper-form">
            <div class="card">
                <h2>Wordle Helper</h2>
<?php 
if (isset($p_words) && (count($p_words) != 6)) {
?>
                <div class="input-group">
                    <label>Add word:</label>
                    <div class="row-input">
                        <input type="text" name="new"  minlength="5" maxlength="5" placeholder="Es. SLATE">
                        <button type="submit" name="add" value="1" class="btn-icon-small"><i class="fa-solid fa-circle-plus"></i> add</button>
                    </div>
                </div>
                <br>
<?php 
}
if (isset($p_words) && (count($p_words) != 0)) {
?>
                <div>
                    Click letters to match your color/state then GO
                </div>
                <br>
<?php 
    $i = 1;
    foreach ($p_words as $w) { 
?>
                <div class="helper-row-container">
                    <input type="hidden" name="w<?= $i ?>" value="<?= $w ?>">
                    <input type="hidden" name="c<?= $i ?>" id="c<?= $i ?>" value="<?= $colors[$i-1] ?>">
                    <div class="wordle-row-interactive">
<?php 
        $col = ['gray', 'yellow', 'green'];
        for ($j=0; $j<5; $j++) {
?>
                        <div class="tile interactive <?= $col[$colors[$i-1][$j]] ?>" onclick="cycleColor(this, <?= $j ?>, 'c<?= $i ?>')"><?= $w[$j] ?></div>
<?php
        }
?>
                    </div>
                    <button type="submit" name="del<?= $i ?>" value="1" class="btn-icon-trash"><i class="fa-solid fa-trash"></i></button>
                </div>
<?php
        $i++;
    }
?>
                <div class="actions-row">
                    <a href="<?= base_url('helper') ?>" class="btn btn-text"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    <button type="submit" name="search" value="1" class="btn btn-primary">GO <i class="fa-solid fa-play"></i></button>
                </div>
            </div>
<?php 
    if (isset($res) && (count($res) != 0)) {
        // Filtra gli elementi dove il secondo valore (indice 1) è uguale a 1
        $official = array_filter($res, fn($item) => (($item['ext'] === 0) && ($item['wordle'] === null)));
        $ext = array_filter($res, fn($item) => $item['ext'] === 1);
        $wordle = array_filter($res, fn($item) => $item['wordle'] !== null);
        print_r($official);
        print_r($ext);
        print_r($wordle);
?>

<!--
                <div class="results-area">
                    <div class="card">
                        <h4>Official List (6)</h4>
                        <div class="word-tags">
                            <span>GAYER</span> <span>GAZER</span> <span>PALER</span>
                            <span>PAYER</span> <span>WAGER</span> <span>WAVER</span>
                        </div>
                    </div>
                </div>
                <div class="results-area">
                    <div class="card">
                        <h4>Extended List (6)</h4>
                        <div class="word-tags">
                            <span>GAYER</span> <span>GAZER</span> <span>PALER</span>
                            <span>PAYER</span> <span>WAGER</span> <span>WAVER</span>
                        </div>
                    </div>
                </div>
                <div class="results-area">
                    <div class="card">
                        <h4>Past used list (6)</h4>
                        <div class="word-tags">
                            <span>GAYER</span> <span>GAZER</span> <span>PALER</span>
                            <span>PAYER</span> <span>WAGER</span> <span>WAVER</span>
                        </div>
                    </div>
                </div>
-->
<?php
    }
} else {
?>
                <div>
                    Add the words you played...
                </div>
<?php
}    
?>
            </div>
            </form>
        </section>
        <!-- /HELPER PAGE -->

        <!-- WORDS LIST PAGE -->
        <section id="view-lists" class="hidden-view">
            <div class="card">
                Select words:
                <div class="word-tags">
                    <span class="official"><input type="checkbox" id="check-official" checked onchange="printWords();"> Official</span>
                    <span class="ext"><input type="checkbox" id="check-ext" onchange="printWords();"> Extended</span>
                    <span class="wordle"><input type="checkbox" id="check-wordle" onchange="printWords();"> Past used</span> 
                </div>
                <div class="search-box">
                    <form action="<?= base_url('words') ?>" method="POST">
                        <?php if (isset($pattern)) { ?>
                        pattern: <b><?= esc(strtoupper($pattern)) ?></b>
                        <?php } else { ?>
                        <input type="text" name="pattern" placeholder="RegExp Search..." required>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary">New Search</button>
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
<?php if (isset($view)) { ?>
            router('<?= esc($view) ?>');
<?php } else { ?>
            router('game');
<?php }?>
        });
    </script>

</body>
</html>