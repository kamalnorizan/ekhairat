<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tanggungan extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'tbltanggungan';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get the ketua that owns the Tanggungan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ketua()
    {
        return $this->belongsTo(Keahlian::class, 'nokpketua', 'nokp');
    }
}
