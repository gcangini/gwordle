<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#ffffff">
    <title>gWordle</title>
    <script defer src="https://www.gigini.it/fa/js/fontawesome.js"></script>
    <script defer src="https://www.gigini.it/fa/js/solid.js"></script>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>"> 
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= base_url('img/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('img/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="gWordle" />
</head>
<body>

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

    <nav id="side-menu" class="side-menu">
        <button class="close-btn" onclick="toggleMenu()">✕</button>
        <ul>
            <li><a href="#" onclick="router('game'); toggleMenu()"><i class="fa-solid fa-robot"></i> BOT play</a></li>
            <li><a href="#" onclick="router('list'); toggleMenu()"><i class="fa-solid fa-list"></i> Words List</a></li>
            <li><a href="#" onclick="router('helper'); toggleMenu()"><i class="fa-solid fa-question"></i> Helper</a></li>
        </ul>
    </nav>

    <main class="container">

        <section id="view-game" class="active-view">
            <div class="card">
                <h2>BOT play</h2>
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
                    <input type="text" name="word" size="10" minlength="5" maxlength="5" placeholder="Insert new word..." required>
                    <button type="submit" class="btn btn-primary">PLAY</button>
                </form>
            </div>
        </section>

        <section id="view-helper" class="hidden-view">
            <div class="card">
                <h2>Wordle Helper</h2>
                <form action="/helper" method="GET" id="helper-form">
                    
                    <div class="input-group">
                        <label>Add word:</label>
                        <div class="row-input">
                            <input type="text" name="new" size="10" minlength="5" maxlength="5" placeholder="Es. SLATE">
                            <button type="submit" name="add" class="btn-icon-small"><i class="fa-solid fa-circle-plus"></i></button>
                        </div>
                    </div>
                    <br>
                    <div>
                        Click letters to match your color/state then GO
                    </div>
                    <br>
                    <div class="helper-row-container">
                        <input type="hidden" name="w1" value="ROAST">
                        <input type="hidden" name="c1" id="c1" value="10100">
                        <div class="wordle-row-interactive">
                            <div class="tile interactive yellow" onclick="cycleColor(this, 0, 'c1')">R</div>
                            <div class="tile interactive gray" onclick="cycleColor(this, 1, 'c1')">O</div>
                            <div class="tile interactive yellow" onclick="cycleColor(this, 2, 'c1')">A</div>
                            <div class="tile interactive gray" onclick="cycleColor(this, 3, 'c1')">S</div>
                            <div class="tile interactive gray" onclick="cycleColor(this, 4, 'c1')">T</div>
                        </div>
                        <button type="button" class="btn-icon-trash"><i class="fa-solid fa-trash"></i></button>
                    </div>

                     <div class="helper-row-container">
                        <input type="hidden" name="w2" value="CEDAR">
                        <input type="hidden" name="c2" id="c2" value="01012">
                        <div class="wordle-row-interactive">
                            <div class="tile interactive gray" onclick="cycleColor(this, 0, 'c2')">C</div>
                            <div class="tile interactive yellow" onclick="cycleColor(this, 1, 'c2')">E</div>
                            <div class="tile interactive gray" onclick="cycleColor(this, 2, 'c2')">D</div>
                            <div class="tile interactive yellow" onclick="cycleColor(this, 3, 'c2')">A</div>
                            <div class="tile interactive green" onclick="cycleColor(this, 4, 'c2')">R</div>
                        </div>
                        <button type="button" class="btn-icon-trash"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <div class="actions-row">
                        <a href="/helper" class="btn btn-text"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                        <button type="submit" name="play" class="btn btn-success">GO <i class="fa-solid fa-play"></i></button>
                    </div>
                </form>
            </div>

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
        </section>

        <section id="view-lists" class="hidden-view">
            <div class="card">
                Select:
                <div class="word-tags">
                        <span class="official">Official List</span> <span>Extended list</span> <span class="wordle">Past used list</span> 
                </div>
                <div class="search-box">
                    <form action="#" method="GET">
                         <input type="text" name="pattern" placeholder="RegExp Search...">
                         <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <h2>Words List</h2>
                <div class="list-container" id="word-list"></div>

<template id="word-template">
    <div class="list-item">
        <span class="word"></span>
        <span class="meta"></span>
    </div>
</template>


<!--
                    <div class="list-item">
                        <span class="word official">ROAST</span>
                        <span class="meta">#1690 • 2026-02-03</span>
                    </div>
                    <div class="list-item">
                        <span class="word wordle">WEIGH</span>
                        <span class="meta">#1690 • 2026-02-03</span>
                    </div>
                    <div class="list-item">
                        <span class="word wordle">CIGAR</span>
                        <span class="meta">#1689 • 2026-02-02</span>
                    </div>
                    <div class="list-item">
                        <span class="word wordle">SPINY</span>
                        <span class="meta">#1688 • 2026-02-01</span>
                    </div>
                    <div class="list-item">
                        <span class="word ext">AARGH</span>
                        <span class="meta">ext</span>
                    </div>
                </div>
-->

            </div>
        </section>

    </main>

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

            // empty the list (useful for updates)
            wl.innerHTML = '';

            words.forEach(item => {
                const clone = template.content.cloneNode(true);
    
                // select word and meta tags
                const word = clone.querySelector('.word');
                const meta = clone.querySelector('.meta');
                word.textContent = item.word;

                if (item.wordle) {
                    word.classList.add('wordle');
                    meta.textContent = "#".item.wordle." • ".item.day;
                } else if (item.ext) {
                    word.classList.add('ext');
                    meta.textContent = "ext";
                } else {
                    word.classList.add('official');
                    meta.textContent = "";
                }

                wl.appendChild(clone);
            });
        }

        printWords();
    </script>

</body>
</html>