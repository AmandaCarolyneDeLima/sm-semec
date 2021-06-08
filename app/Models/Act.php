<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Act extends Model
{
    use HasFactory;

    /**
    * @var array
    */
    protected $fillable = [
        'name',
        'started_at',
        'ended_at',
        'number',
        'time',
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
