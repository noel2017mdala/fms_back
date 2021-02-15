<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAmount extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    public $table = 'User_Amount_transactions';
    public $primaryKey = 'user_Amount_id';
}
