<?php

namespace App\Controllers;

use App\Models\WordsModel;

class Home extends BaseController
{
    public function getIndex($view = 'game') {
        $words_model = model('WordsModel');
        $data['words'] = $words_model->orderBy('word ASC')->findAll();
        if ($view == 'offline') {
            return view('offline',$data);
        }
        $data['view'] = $view;
        return view('index',$data);
    }
}