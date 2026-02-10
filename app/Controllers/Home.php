<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Home extends BaseController
{
    public function getIndex() {
        $words_model = model(WordsModel::class);
        $this->data['words'] = $words_model->findAll();
        return view('index',$data);
    }
}