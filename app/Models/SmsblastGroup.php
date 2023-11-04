<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsblastGroup extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'smsblast_groups';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function smsBlastDetails()
    {
        return $this->hasMany(SmsblastDetail::class, 'smsblast_group_id', 'id');
    }

    public function smsBlast()
    {
        return $this->belongsTo(Smsblast::class, 'smsblast_id', 'id');
    }
}
