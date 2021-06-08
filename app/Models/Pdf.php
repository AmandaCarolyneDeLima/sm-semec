<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Edict;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pdf extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
     'pdf',
     'name',
     'edict_id'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function edict()
    {
        return $this->belongsTo(Edict::class, 'edict_id');
    }

    /**
    * @return string
    */
    public function pathToFile()
    {
        return public_path('uploads/edicts/' . $this->edict_id . '/' . $this->getOriginal('pdf'));
    }

    /**
    * @return $this
    */
    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
}
