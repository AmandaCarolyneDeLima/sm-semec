<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitCategory extends Model
{
    use HasFactory;

    protected $table = 'unit_categories';
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function units()
    {
        return $this->hasMany(Unit::class, 'category_id');
    }

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return UnitCategory::where('name', 'LIKE', $searchTerm)
                ->orderBy('name', 'desc')
                ->paginate(20);
        }
        return UnitCategory::orderBy('name', 'desc')->paginate(20);
    }
}
