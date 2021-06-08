<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servant extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'birthed_at',
        'natural_from',
        'marital_status',
        'mother_name',
        'father_name',
        'CPF',
        'RG',
        'PIS',
        'CTPS',
        'title',
        'address',
        'phone',
        'email',
        'password',
        'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'image_path',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'servant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependents()
    {
        return $this->hasMany(Dependent::class, 'servant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'servant_id')->orderBy('admission_at', 'desc');
    }

    /**
     * @return Contract
     */
    public function lastContract()
    {
        return $this->contracts->first() ?: new Contract();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function licenses()
    {
        return $this->hasManyThrough(License::class, Contract::class, 'servant_id', 'contract_id');
    }

    /**
    * @param string $value
    * @return void
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
    * @return string
    */
    public function getImagePathAttribute()
    {
        if ($this->getOriginal('image') == null) {
            return '/assets/images/default/default-user.png';
        }

        return '/uploads/servants/' . $this->id . '/' . $this->getOriginal('image');
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


    /*
     * TODO: Pegar automaticamente a unidade atual do servidor.
     * @return \App\Models\Unit
     */
    public function currentUnit(): \App\Models\Unit
    {
        return Unit::first();
    }

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Servant::query()->with(['contracts'])
                                   ->where('name', 'LIKE', $searchTerm)
                                   ->orWhere('CPF', 'LIKE', $searchTerm)
                                   ->orderBy('name', 'asc')
                                   ->paginate(20);
        }

        return Servant::with(['contracts'])->paginate(20);
    }
}
