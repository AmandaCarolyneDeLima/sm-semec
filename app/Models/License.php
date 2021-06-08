<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'started_at',
        'ended_at',
        'license_type',
        'days',
        'contract_id',
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
