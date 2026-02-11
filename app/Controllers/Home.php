<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Home extends BaseController
{
    public function getIndex() {
        $words_model = model('WordsModel');
        $data['words'] = $words_model->orderBy("word")->findAll();
        return view('index',$data);
    }
}