<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counter extends Model
{
   
    public $timestamps = true;

    protected $table = 'tblcounter';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

   

}
