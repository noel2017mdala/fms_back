<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\projectsTransactionModel as Transactions;

class projectsModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    public $table = 'projects';
    public $primaryKey = 'projects_id';

    //one to many relationship btwn projects and transactions
    public function transactions(){
        return $this->hasMany(Transactions::class, 'projects_id');
    }
}
