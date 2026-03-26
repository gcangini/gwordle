<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Bot extends BaseController
{
    protected $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    protected $data = array();
    protected $char_values;

    // calculates the probability of a word
    // based on letter statistics
    private function wordVal($word) {
        $res = 0;
        for ($i=0;$i<strlen($word);$i++)
            $res += $this->char_values[ord($word[$i])];
        return $res;
    }

    // starting from an array of words
    // creates the list to be played, sorted by probability
    private function create_list($words) {
        $res = array();
        foreach ($words as $w) {
            $res[] = [$this->wordVal(implode("",array_unique(str_split($w)))),$w];
        }
        rsort($res);
        reset($res);
        return $res;
    }

    // play Wordle trying to guess word $sol
    private function playWordle($sol) {
        // load all words that have already appeared and calculate letter usage statistics
        $wordle = array_filter($this->data['words'], fn($item) => $item['wordle'] !== null);
        $wordles = array_column($wordle,'word');
        $wordle_str = implode("",$wordles);
        $this->char_values = count_chars($wordle_str,1);

        // load all possible words (standard dictionary) and sort them by probability
        $official = array_filter($this->data['words'], fn($item) => (($item['ext'] == 0) && ($item['wordle'] === null)));
        $off = array_column($official,'word');
        $words_sel = $this->create_list($off);

        $ext = false; // true if working with the extended list
        $rep = false; // true if working with past used words
        $tries = array();
        // first attempt (first word of the sorted array $word_sel)
        $try = current($words_sel)[1];
        $tries[1] = $try;
        if ($try != $sol) {
            $end = false;
            $num_t = 2;
            while (!$end) {
                // attempt $num_t with previous info
                $p_arr = array();
                $p_arr_not = array();
                for ($i=0;$i<5;$i++) {
                    $p_arr[$i] = "";
                    $p_arr_not[$i] = "";
                }
                $not = "";
                $in = "";
                $double = array();
                // analysis of previous attempts
                for ($t=1;$t<$num_t;$t++) {
                    for ($i=0;$i<5;$i++) {
                        $l = $tries[$t][$i];
                        if (strpos($sol,$l) === false)
                            $not.=$l; // gray
                        else {
                            if ($sol[$i] == $l)
                                $p_arr[$i] = $l; // green
                            else {
                                $p_arr_not[$i].=$l;
                                $in.=$l; // yellow
                                // double letters ? (to be improved...)
                                if ((substr_count($tries[$t],$l) > 1) && (substr_count($sol,$l) > 1)) {
                                    $double[$l] = min(substr_count($tries[$t],$l), substr_count($sol,$l));
                                }
                            }
                        }
                    }
                }
                // create the pattern with the letters OK and those to be excluded
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
                    // takes the next word from the sorted array $word_sel
                    $t = next($words_sel);
                    // word not found after $num_t attempts
                    if ($t === false) {
                        if ($ext) {
                            if ($rep) {
                                // already tried all the lists (official, extended, already released)
                                // Word $sol is not dictionary
                                return null;
                            } else {
                                // already looking for the extended list
                                // try to replay past used words
                                $rep = true;
                                $words_sel = $this->create_list($wordles);
                            }
                        } else {
                            // the word is not in the OFFICIAL list, look for it in the extended list
                            $ext = true;
                            $words_ext_arr = array_filter($this->data['words'], fn($item) => $item['ext'] == 1);
                            $words_ext = array_column($words_ext_arr,'word');
                            $words_sel = $this->create_list($words_ext);
                        }
                        $try = current($words_sel)[1];
                    } else {
                        $try = $t[1];
                    }
                    // check if the word found matches the pattern
                    if (preg_match($pattern,$try)) {
                        $found=true;
                        //verify that the word found also matches all the other letters it must contain
                        for ($i=0;$i<strlen($in);$i++) {
                            if (!preg_match("/".$in[$i]."/",$try))
                                $found = false;
                        }
                        // check for duplicates letters
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

    // format result array of Words ($res) with colors
    private function formatWords($res,$sol) {
        $colors = array();
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $aa = array();
        for($i=0; $i<strlen($alphabet); $i++) {
            $aa[substr($alphabet,$i,1)]=0;
        }
        $sa = str_split($sol);
        foreach ($res as $k => $w) {
            $colors[$k] = array();
            $wa = str_split($w);
            for ($i=0; $i<5; $i++) {
                if ($wa[$i] == $sa[$i]) { // GREEN
                    $col = 2;
                    $aa[$wa[$i]] = 2;
                } elseif (!in_array($wa[$i], $sa)) { // GRAY
                    $col = 0;
                    if (($aa[$wa[$i]] != 2) && ($aa[$wa[$i]] != 1))
                        $aa[$wa[$i]] = 0;
                } else {
                    if (substr_count($sol,$wa[$i]) >= substr_count($w,$wa[$i])) { // YELLOW
                        $col = 1;
                        if ($aa[$wa[$i]] != 2) 
                            $aa[$wa[$i]] = 1;
                    } else {
                        $tot = 0;
                        $greens = 0;
                        for ($j=0; $j<5; $j++) {
                            if ($sa[$j] == $wa[$i]) {
                                $tot = $tot+1;
                                if ($sa[$j] == $wa[$j]) {
                                    $greens = $greens+1;
                                }
                            }
                        }
                        $yellows = $tot-$greens;
                        if ($yellows == 0) { // GRAY
                            $col = 0;
                            if (($aa[$wa[$i]] != 2) && ($aa[$wa[$i]] != 1))
                                $aa[$wa[$i]] = 0;
                        } else {
                            for ($j=0; $j<$i; $j++) {
                                if (($wa[$j] == $wa[$i]) && ($wa[$j] != $sa[$j])) {
                                    $yellows = $yellows-1;
                                }
                            }
                            if ($yellows <= 0) { // GRAY
                                $col = 0;
                                if (($aa[$wa[$i]] != 2) && ($aa[$wa[$i]] != 1))
                                    $aa[$wa[$i]] = 0;
                            } else { // YELLOW
                                $col = 1;
                                if ($aa[$wa[$i]] != 2)
                                    $aa[$wa[$i]] = 1;
                            }
                        }
                    }
                }
                $colors[$k][$i] = $col;
            }
        }
        return $colors;
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
                if ($this->data['res']) {
                    $this->data['bot_colors'] = $this->formatWords($this->data['res'],$sol);
                } else {
                    $this->data['error'] = "Word \"$sol\" is not in my dictionary!";
                }
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
