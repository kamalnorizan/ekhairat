<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunTajaan extends Model
{
    public $timestamps = true;

    protected $table = 'lttahun_tajaan';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    
}
