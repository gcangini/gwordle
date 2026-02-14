<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Offline extends BaseController
{
    public function getIndex() {
        $words_model = model('WordsModel');
        $data['words'] = $words_model->orderBy('word ASC')->findAll();
        return view('offline',$data);
    }
}