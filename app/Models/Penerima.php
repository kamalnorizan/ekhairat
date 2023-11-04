<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerima extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'tblpenerima';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get the keahlian that owns the Penerima
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keahlian()
    {
        return $this->belongsTo(Keahlian::class, 'nokpketua', 'nokp');
    }
}
