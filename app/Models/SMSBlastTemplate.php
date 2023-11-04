<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSBlastTemplate extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'smsblast_templates';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];


}
