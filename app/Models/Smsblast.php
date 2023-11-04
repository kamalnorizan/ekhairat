<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smsblast extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'smsblasts';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function smsblastDetails()
    {
        return $this->hasMany(SmsblastDetail::class, 'smsblast_id', 'id');
    }

    /**
     * Get all of the smsBlastGroups for the Smsblast
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function smsBlastGroups()
    {
        return $this->hasMany(SmsblastGroup::class, 'smsblast_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
