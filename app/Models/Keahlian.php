<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keahlian extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'tblkeahlian';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get all of the tangungan f the Keahlian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tangungan()
    {
        return $this->hasMany(Tanggungan::class, 'nokpketua', 'nokp');
    }

    /**
     * Get all of the bayaran for the Keahlian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bayaran()
    {
        return $this->hasMany(Bayaran::class, 'nokp', 'nokp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nokp', 'nokp');
    }

    /**
     * Get the kumpulanAlamat that owns the Keahlian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kumpulanAlamat()
    {
        return $this->belongsTo(Alamat::class, 'ltalamat_id', 'id');
    }

    function bayaranDetails() {
        return $this->hasManyThrough(BayaranDetail::class,Bayaran::class, 'nokp', 'bayaran_id', 'nokp', 'id');
    }

    function bayaranDetailsPaid() {
        return $this->hasManyThrough(BayaranDetail::class,Bayaran::class, 'nokp', 'bayaran_id', 'nokp', 'id')->where('tblbayaran.statusbayaran', '=', '1');
    }

    function bayaranDetailsPaidTajaan() {
        return $this->hasManyThrough(BayaranDetail::class,Bayaran::class, 'nokp', 'bayaran_id', 'nokp', 'id')->where('tblbayaran.statusbayaran', '=', '1')->where('tblbayaran.carabayaran', '=', 'TAJAAN');
    }

    /**
     * Get the statusPengguna that owns the Keahlian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusPengguna()
    {
        return $this->belongsTo(StatusPengguna::class, 'kodstatuspengguna', 'kodstatuspengguna');
    }

}
