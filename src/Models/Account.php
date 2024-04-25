<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAdvancedFilter;

    public $table = 'accounts';
    protected $orderable = [
        'id',
        'name',
        'details'
    ];

    protected $filterable = [
        'id',
        'name',
        'details'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'details',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function expanses(): HasMany
    {
        return $this->hasMany(Expanse::class);
    }
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function locker()
    {
        return $this->hasOne(PublicTreasury::class);
    }

    public function setting()
    {
        return $this->hasOne(Setting::class)->first();
    }

}
