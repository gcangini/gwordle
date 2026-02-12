<?php

namespace App\Controllers;

class Helper extends BaseController
{
    protected $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    protected $data = array();

    // read data from POST form
    private function getData() {
        $i=1;
        $this->data['p_words'] = array();
        $this->data['colors'] = array();
        for ($i=1; $i<7;$i++) { // check up to 6 words
            $w = request()->getPost('w'.$i);
            if (!isset($w)) { // exit from the cycle
                break;
            }
            $w = strtoupper($w);
            // check again that word is correct
            if ((null === request()->getPost('del'.$i)) &&  // not marked for deletion
                (strlen($w) == 5) &&                        // 5 chars
                (strspn($w,$this->alphabet) == 5) &&        // all literals
                (!in_array($w,$this->data['p_words']))      // not already present
                ) {
                $this->data['p_words'][] = $w;
                $this->data['colors'][] = request()->getPost('c'.$i);
            }
        }
        /*
        while (request()->getPost('w'.$i) && $i<7) {
            if (null === request()->getPost('del'.$i)) {
                $this->data['p_words'][] = request()->getPost('w'.$i);
                $this->data['colors'][] = request()->getPost('c'.$i);
            }
            $i++;
        }*/

        // add new word ?
        $add = request()->getPost('add');
        $new = request()->getPost('new');
        if ($new) $new = strtoupper($new);
        if ($add && $new &&                             // request to add new word
            (count($this->data['p_words'])<6) &&        // space available
            (strlen($new) == 5) &&                      // 5 chars
            (strspn($new,$this->alphabet) == 5) &&      // all literals
            (!in_array($new,$this->data['p_words']))    // not already present
            ) {
            $this->data['p_words'][] = $new;
            $this->data['colors'][] = "00000";
        }

        // get result ?
        if (request()->getPost('search')) {
            $this->data['search'] = true;
        } else {
            $this->data['search'] = false;
        }
    }

    // create RegExp pattern (based on wors/letters/colors)
    private function createPattern() {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $i = 0;
        $yellow = "";
        $gray = "";
        $pattern = array();
        for ($j=0; $j<5; $j++) {
            $pattern[] = $alphabet;
        }
        foreach ($this->data['words'] as $word) {
            $color = $this->data['colors'][$i];
            $tmp_gray = "";
            $tmp_yellow = "";
            for ($j=0; $j<5; $j++) {
                if (strlen($pattern[$j]) != 1) {
                    // check $j letter
                    if ($color[$j] == 2) { // GREEN
                        $pattern[$j] = $word[$j];
                        $tmp_yellow .= $word[$j];
                    } elseif ($color[$j] == 1) { // YELLOW
                        $pattern[$j] = str_replace($word[$j],"",$pattern[$j]);
                        $tmp_yellow .= $word[$j];
                    } else { // GRAY
                        if (substr_count($word,$word[$j]) == 1) {
                            $gray .= $word[$j];
                        } else {
                            $pattern[$j] = str_replace($word[$j],"",$pattern[$j]);
                            $tmp_gray .= $word[$j];
                        }
                    }
                } else {
                    $tmp_yellow .= $word[$j];
                }
            }
            for ($j=0; $j<strlen($tmp_gray); $j++) {
                if (substr_count($tmp_yellow,$tmp_gray[$j]) == 0) {
                    $gray .= $tmp_gray[$j];
                }
            }
            for ($j=0; $j<strlen($tmp_yellow); $j++) {
                $tot = substr_count($tmp_yellow,$tmp_yellow[$j]) - substr_count($yellow,$tmp_yellow[$j]);
                for ($x=0; $x<$tot; $x++) {
                    $yellow .= $tmp_yellow[$j];
                }
            }
            $i++;
        }
        for ($i=0; $i<5; $i++) {
            for ($j=0; $j<strlen($gray); $j++) {
                $pattern[$i] = str_replace($gray[$j],"",$pattern[$i]);
            }
        }
        $res = "";
        for ($j=0; $j<5; $j++) {
            $res .= "[".$pattern[$j]."]";
        }
        $res .= "+".$yellow;
        return $res;
    }

    public function getIndex() {
        $words_model = model('WordsModel');
        $data['words'] = $words_model->orderBy('word ASC')->findAll();
        $data['view'] = 'helper';
        return view('index',$data);
    }

    public function postIndex() {
        $this->getData();
        $words_model = model('WordsModel');
        $this->data['words'] = $words_model->orderBy('word ASC')->findAll();
        $this->data['view'] = 'helper';
        return view('index',$this->data);
    }
}