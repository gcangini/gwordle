<?php

namespace App\Controllers;

use App\Models\WordsModel;
use Dom\HTMLDocument;

class FiveForks extends BaseController
{
    public function getIndex() {
        $words_model = model('WordsModel');
        $last = $words_model->orderBy('day DESC')->first();
        $url = 'https://www.fiveforks.com/wordle/';
        $data = array();
        $data['res'] = "NONE";
        try {
            $ch = curl_init($url);
//          curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, "gcangini");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $html_str = curl_exec($ch);
            curl_close($ch);
            $html = HTMLDocument::createFromString($html_str,LIBXML_NOERROR);
            $block = $html->getElementById('chronlist')->textContent;
            if (isset($block) && is_string($block)) {
                $pattern = "/(.{5})\s([^\s]+)\s(\d\d)\/(\d\d)\/(\d\d)/";
                $rows = explode("\n",$block);
                $matches = array();
                $end = false;
                $i = 1;
                $c = 0;
                while (!$end) {
                    if (preg_match($pattern,$rows[$i],$matches)) {
                        $new = [    "word"      => $matches[1], 
                                    "wordle"    => $matches[2], 
                                    "day"       => "20".$matches[5]."-".$matches[3]."-".$matches[4],
                                    "ext"       => 0
                        ];
                        if ($matches[2] == $last['wordle']) {
                            $end = true;
                        } else {
                            // NEW WORD found -> insert on db
                            $exist_word = $words_model->where("word",$matches[1])->first();
                            if ($exist_word && is_null($exist_word['wordle'])) { // update
                                $new['id'] = $exist_word['id'];
                            }
                            $words_model->save($new);
                            $c++;
                        }
                    } else {
                        $end = true;
                    }
                    $i++;
                    if ($i == count($rows))
                        $end = true;
                }
                if ($c != 0) {
                    $data['res'] = "OK: $c new words";
                }
            }
        } catch (\Exception $e) {
            $data['res'] = "ERROR:".$e->getMessage();
        }

        return view('ff',$data);
    }

}