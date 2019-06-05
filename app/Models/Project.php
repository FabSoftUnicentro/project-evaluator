<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeNotEvaluatedBy(Builder $query, User $user)
    {
        return $query->whereDoesntHave('evaluations', function (Builder $query) use ($user) {
            $query->where('user_id', '=', $user->getKey());
        });
    }

    /**
     * @param Builder $query
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function scopeOrderedByEvaluationAverage(Builder $query)
    {
        return $query->with('evaluations')
            ->get()
            ->sortByDesc('evaluationAverage');
    }

    public function getEvaluationAverageAttribute()
    {
        return $this->evaluations->avg('value');
    }
}
