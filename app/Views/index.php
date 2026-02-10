<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#ffffff">
    <title>gWordle</title>
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
            <button onclick="router('game')" class="icon-btn" aria-label="Bot Home">
                🤖
            </button>
        </div>
        
        <div class="header-center">
            <h1>pWordle</h1>
        </div>

        <div class="header-right">
            <button onclick="router('helper')" class="icon-btn" aria-label="Helper">
                ❓
            </button>
            <button onclick="toggleMenu()" class="icon-btn" aria-label="Menu">
                ☰
            </button>
        </div>
    </header>

    <nav id="side-menu" class="side-menu">
        <button class="close-btn" onclick="toggleMenu()">✕</button>
        <ul>
            <li><a href="#" onclick="router('wordlist'); toggleMenu()">📜 List</a></li>
            <li><a href="#" onclick="router('ext'); toggleMenu()">📚 Ext List</a></li>
            <li><a href="#" onclick="router('played'); toggleMenu()">✅ Played</a></li>
            <li><a href="#" onclick="router('miss'); toggleMenu()">❌ Missed</a></li>
            <li class="separator"></li>
            <li><a href="/login" class="login-link">🔐 Login</a></li>
        </ul>
    </nav>

    <main class="container">

        <section id="view-game" class="active-view">
            <div class="card">
                <h2>Ultima Partita: pW01</h2>
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
                        📤 Condividi su WhatsApp
                    </button>
                </div>
            </div>

            <div class="card new-game-card">
                <h3>Nuova Partita</h3>
                <form action="/" method="GET" class="inline-form">
                    <input type="text" name="word" placeholder="Inserisci parola..." required>
                    <button type="submit" class="btn btn-primary">PLAY</button>
                </form>
            </div>
        </section>

        <section id="view-helper" class="hidden-view">
            <div class="card">
                <h2>Wordle Helper</h2>
                <form action="/helper" method="GET" id="helper-form">
                    
                    <div class="input-group">
                        <label>Aggiungi parola:</label>
                        <div class="row-input">
                            <input type="text" name="new" placeholder="Es. ROAST">
                            <button type="submit" name="add" class="btn-icon-small">➕</button>
                        </div>
                    </div>

                    <hr class="divider">

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
                        <button type="button" class="btn-icon-trash">🗑️</button>
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
                        <button type="button" class="btn-icon-trash">🗑️</button>
                    </div>

                    <div class="actions-row">
                        <a href="/helper" class="btn btn-text">Reset</a>
                        <button type="submit" name="play" class="btn btn-success">SOLVE ▶</button>
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
        </section>

        <section id="view-lists" class="hidden-view">
            <div class="card">
                <h2 id="list-title">Past Words</h2>
                <div class="search-box">
                    <form action="#" method="GET">
                         <textarea name="pattern" rows="1" placeholder="RegExp Search..."></textarea>
                         <button type="submit" class="btn btn-primary">Cerca</button>
                    </form>
                </div>
                
                <div class="list-container">
                    <div class="list-item">
                        <span class="word">WEIGH</span>
                        <span class="meta">#1690 • 2026-02-03</span>
                    </div>
                    <div class="list-item">
                        <span class="word">CIGAR</span>
                        <span class="meta">#1689 • 2026-02-02</span>
                    </div>
                    <div class="list-item">
                        <span class="word">SPINY</span>
                        <span class="meta">#1688 • 2026-02-01</span>
                    </div>
                    </div>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 - <a href="https://www.gigini.it" target="_blank">gigini.it</a></p>
    </footer>

    <script src="<?= base_url('app.js') ?>"></script>
</body>
</html>