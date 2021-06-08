<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'edict_id',
        'servant_id',
        'contract_id',
        'removal_type_id',
        'interested_unit_id',
        'reason',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servant()
    {
        return $this->belongsTo(Servant::class, 'inscription_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentUnit()
    {
        return $this->belongsTo(Unit::class, 'current_unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interestedUnit()
    {
        return $this->belongsTo(Unit::class, 'interested_unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function edict()
    {
        return $this->belongsTo(Edict::class, 'edict_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function removalType()
    {
        return $this->belongsTo(RemovalType::class, 'removal_type_id');
    }
}
