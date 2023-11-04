<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsblastDetail extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'smsblast_details';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function smsBlast()
    {
        return $this->belongsTo(Smsblast::class, 'smsblast_id', 'id');
    }

    public function smsBlastGroup(){
        return $this->belongsTo(SmsblastGroup::class, 'smsblast_group_id', 'id');
    }

}
