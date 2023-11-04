<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPengguna extends Model
{
    public $timestamps = true;

    protected $table = 'ltstatuspengguna';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get all of the ahli for the StatusPengguna
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ahli()
    {
        return $this->hasMany(Keahlian::class, 'kodstatuspengguna', 'kodstatuspengguna');
    }

    /**
     * Get all of the users for the StatusPengguna
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'kodstatuspengguna', 'kodstatuspengguna');
    }
}
