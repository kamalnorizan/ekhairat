<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BayaranDetail extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'tblbayaran_details';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get the bayaran that owns the BayaranDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bayaran()
    {
        return $this->belongsTo(bayaran::class, 'bayaran_id', 'id');
    }
}
