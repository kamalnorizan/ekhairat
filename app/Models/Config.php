<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'configs';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];
}
