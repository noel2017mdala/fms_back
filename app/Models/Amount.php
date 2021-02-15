<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    public $table = 'Amount';
    public $primaryKey = 'Amount_id';
}
