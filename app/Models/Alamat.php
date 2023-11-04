<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'ltalamat';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get all of the comments for the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ahli()
    {
        return $this->hasMany(Keahlian::class, 'ltalamat_id', 'id');
    }
}
