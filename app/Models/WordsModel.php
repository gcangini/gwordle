<?php

namespace App\Models;

use CodeIgniter\Model;

class WordleModel extends Model
{
        protected $table = 'words';
        protected $primaryKey = 'id';
        protected $allowedFields = ['id', 'word', 'wordle', 'day', 'ext'];
}