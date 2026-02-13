<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Bot extends BaseController
{
    protected $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    protected $data = array();
    protected $char_values;

    // calcola la probabilità di una parola ($word)
    // basandosi sulla probabilità delle lettere
    private function wordVal($word) {
        $res = 0;
        for ($i=0;$i<strlen($word);$i++)
            $res += $this->char_values[ord($word[$i])];
        return $res;
    }

    // a partire da un array di parole ($words)
    // crea la lista da giocare ordinata per probabilità
    private function create_list($words) {
        $res = array();
        foreach ($words as $w) {
            $res[] = [$this->wordVal(implode("",array_unique(str_split($w)))),$w];
        }
        rsort($res);
        reset($res);
        return $res;
    }

    private function playWordle($sol) {
        // carico tutte le parole già uscite e calcolo le statistiche di utilizzo delle lettere
        $wordle = array_filter($this->words, fn($item) => $item['wordle'] !== null);
        $wordles = array_column($wordle,'word');
        $wordle_str = implode("",$wordles);
        $this->char_values = count_chars($wordle_str,1);

        // carico tutte le possibili parole (dizionario standard) e le ordino per probabilità
        $official = array_filter($this->words, fn($item) => (($item['ext'] == 0) && ($item['wordle'] === null)));
        $off = array_column($official,'word');
        $words_sel = $this->create_list($off);

        $ext = false; // true se lavoro con la lista estesa
        $rep = false; // true se lavoro con le parole già uscite
        $tries = array();
        // primo tentativo (prima parola dell'array ordinato $word_sel)
        $try = current($words_sel)[1];
        $tries[1] = $try;
        if ($try != $sol) {
            $end = false;
            $num_t = 2;
            while (!$end) {
                // tentativo $num_t con le info dei precedenti
                $p_arr = array();
                $p_arr_not = array();
                for ($i=0;$i<5;$i++) {
                    $p_arr[$i] = "";
                    $p_arr_not[$i] = "";
                }
                $not = "";
                $in = "";
                $double = array();
                // analisi lettere tentativi precedenti
                for ($t=1;$t<$num_t;$t++) {
                    for ($i=0;$i<5;$i++) {
                        $l = $tries[$t][$i];
                        if (strpos($sol,$l) === false)
                            $not.=$l; // grigia
                        else {
                            if ($sol[$i] == $l)
                                $p_arr[$i] = $l; // verde
                            else {
                                $p_arr_not[$i].=$l;
                                $in.=$l; // gialla
                                // doppie?
                                if ((substr_count($tries[$t],$l) > 1) && (substr_count($sol,$l) > 1)) {
                                    $double[$l] = min(substr_count($tries[$t],$l), substr_count($sol,$l));
                                }
                            }
                        }
                    }
                }
                // crea il pattern con le lettere OK e quelle da escludere
                $pattern="/";
                for ($i=0;$i<5;$i++) {
                    if ($p_arr[$i] != "") {
                        $pattern.=$p_arr[$i];
                    } else {
                        $pattern.="[^".$not.$p_arr_not[$i]."]";
                    }
                }
                $pattern.="/";
                $found = false;
                while (!$found) {
                    // prende la successiva parola dall'array ordinato $word_sel
                    $t = next($words_sel);
                    // parola non trovata dopo $num_t tentativi
                    if ($t === false) {
                        if ($ext) {
                            if ($rep) {
                                // ho già provato tutte le liste (ufficiale, estesa, già uscite)
                                return "Word $sol is not in my dictionary";
                            } else {
                                // stavo già  cercando la lista estesa
                                // provo a ri-giocare parole già uscite
                                $rep = true;
                                $words_sel = $this->create_list($wordles);
                            }
                        } else {
                            // la parola non è nella lista UFFICIALE, la cerco nella lista estesa
                            // da cui sottraggo le parole già uscite e quelle della lista ufficiale
                            $ext = true;
                            $words_ext_arr = array_filter($this->words, fn($item) => $item['ext'] == 1);
                            $words_ext = array_column($words_ext_arr,'word');
                            $words_sel = $this->create_list($words_ext);
                        }
                        $try = current($words_sel)[1];
                    } else {
                        $try = $t[1];
                    }
                    // verifica se la parola trovata fa match con il pattern
                    if (preg_match($pattern,$try)) {
                        $found=true;
                        //verifica che la parola trovata faccia match anche con tutte le altre lettere che deve contenere
                        for ($i=0;$i<strlen($in);$i++) {
                            if (!preg_match("/".$in[$i]."/",$try))
                                $found = false;
                        }
                        // verifica le doppie
                        foreach ($double as $dk => $dv) {
                            if (substr_count($try,$dk) < $dv) {
                                $found = false;
                            }
                        }
                    }
                }
                $tries[$num_t] = $try;
                if (($try == $sol) || ($num_t == 6))
                    $end = true;
                else
                    $num_t++;
            }
        }

        return $tries;
    }

    private function init() {
        $words_model = model('WordsModel');
        $this->data['words'] = $words_model->orderBy('word ASC')->findAll();
        $this->data['view'] = 'bot';
    }

    public function postIndex() {
        $this->init();
        $word = request()->getPost('word');
        if ($word) {
            $sol = strtoupper(trim($word));
            if ((strlen($sol) == 5) &&                 // 5 chars
                (strspn($sol,$this->alphabet) == 5)    // all literals
                ) {
                $this->data['res'] = $this->playWordle($sol);
                $this->data['sol'] = $sol;
            }
        }
        return view('index',$this->data);
    }

    public function getIndex() {
        $this->init();
        return view('index',$this->data);
    }
}
