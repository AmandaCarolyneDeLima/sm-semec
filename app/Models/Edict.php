<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DateTimeFormatter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Edict extends Model
{
    use DateTimeFormatter;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'started_at',
        'ended_at',
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function pdfs()
    {
        return $this->hasMany(Pdf::class, 'edict_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'edict_id');
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

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Edict::where('title', 'LIKE', $searchTerm)
            ->orderBy('started_at', 'desc')
            ->paginate(20);
        }
        return Edict::orderBy('started_at', 'desc')->paginate(20);
    }

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchOpen($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Edict::where([
                ['ended_at', '>=', Carbon::now()->toDateTimeString()],
                ['title', 'LIKE', $searchTerm],
                 ])
                ->orderBy('started_at', 'desc')
                ->paginate(20);
        }
        return Edict::where('ended_at', '>=', Carbon::now()->toDateTimeString())
                      ->orderBy('started_at', 'desc')
                      ->paginate(20);
    }

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchClose($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Edict::where([
                ['ended_at', '<=', Carbon::now()->toDateTimeString()],
                ['title', 'LIKE', $searchTerm],])
                ->orderBy('started_at', 'desc')
                ->paginate(20);
        }
        return Edict::where('ended_at', '<=', Carbon::now()->toDateTimeString())
                      ->orderBy('started_at', 'desc')
                      ->paginate(20);
    }
}
