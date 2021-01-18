<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectsTransactionModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = [];
    public $table = 'projectTransactions';
}
