<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
class Bayaran extends Model  implements Auditable
{
    use SoftDeletes;
    public $timestamps = true;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tblbayaran';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];


    public function bayaranDetails()
    {
        return $this->hasMany(BayaranDetail::class, 'bayaran_id', 'id');
    }

    public function keahlian()
    {
        return $this->belongsTo(Keahlian::class, 'nokp', 'nokp');
    }

    function kategoriPengguna() {
        return $this->belongsTo(StatusPengguna::class, 'kategoriTajaan', 'kodstatuspengguna');
    }
}
