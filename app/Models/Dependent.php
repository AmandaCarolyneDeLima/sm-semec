<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dependent extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'birthed_at',
        'degree',
        'study',
        'works',
        'servant_id'
    ];

    protected $dates = [
        'birthed_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servant()
    {
        return $this->belongsTo(Servant::class, 'servant_id');
    }
}
