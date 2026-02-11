<?php

namespace App\Controllers;

use App\Models\WordsModel;

class List extends BaseController
{
    public function postIndex() {
        $words_model = model('WordsModel');
        $words = $words_model->orderBy("word")->findAll();
        $pattern = request()->getPost('pattern');
        $res = array();
        if (isset($pattern)) {
            $data['pattern'] = $pattern;
            foreach ($words as $w) {
                if (preg_match("/".$pattern."/i",$w['word'])) {
                    $res[] = $w;
                }
            }
        } else {
            $res = $words;
        }
        $data['words'] = $res;
        $data['view'] = 'list';
        return view('index',$data);
    }
}