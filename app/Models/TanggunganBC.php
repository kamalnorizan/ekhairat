<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggunganBC extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'tbltanggunganBC';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];


}
