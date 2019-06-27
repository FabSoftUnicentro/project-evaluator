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
        return $this->hasMany(Evaluation::class)->with('user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class);
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
     * @param User $member
     * @return Builder
     */
    public function scopeDoesntHaveMember(Builder $query, User $member)
    {
        return $query->whereDoesntHave('members', function (Builder $query) use ($member) {
            $query->where('id', '=', $member->getKey());
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
            ->sort(function (Project $a, Project $b) {
                if ($a->evaluationAverage === $b->evaluationAverage) {
                    if ($a->teacherEvaluationAverage === $b->teacherEvaluationAverage) {
                        return $a->studentEvaluationAverage > $b->studentEvaluationAverage ? -1 : 1;
                    }

                    return $a->teacherEvaluationAverage > $b->teacherEvaluationAverage ? -1 : 1;
                }

                return $a->evaluationAverage > $b->evaluationAverage ? -1 : 1;
            });
    }

    /**
     * @return float
     */
    public function getEvaluationAverageAttribute()
    {
        $weightSum = 0;
        $evaluationSum = 0;
        $evaluations = $this->evaluations;

        /** @var Evaluation $evaluation */
        foreach ($evaluations as $evaluation) {
            if ($evaluation->user->role === 'student') {
                $evaluationSum += $evaluation->value;
                $weightSum++;
            } else {
                $evaluationSum += 3 * $evaluation->value;
                $weightSum += 3;
            }
        }

        if ($weightSum === 0) {
            $weightSum = 1;
        }

        return round($evaluationSum / $weightSum, 2);
    }

    /**
     * @return int
     */
    public function getStudentEvaluationAverageAttribute()
    {
        $studentEvaluations = $this->evaluations->where('user.role', '=', 'student');

        return $studentEvaluations->avg('value', 2) ?? 0;
    }

    /**
     * @return int
     */
    public function getTeacherEvaluationAverageAttribute()
    {
        $teacherEvaluations = $this->evaluations->where('user.role', '=', 'teacher');

        return $teacherEvaluations->avg('value') ?? 0;
    }

    /**
     * @return mixed
     */
    public function getEvaluationCountAttribute()
    {
        return $this->evaluations->count();
    }

    /**
     * @return mixed
     */
    public function getStudentEvaluationCountAttribute()
    {
        return $this->evaluations->where('user.role', '=', 'student')->count();
    }

    /**
     * @return mixed
     */
    public function getTeacherEvaluationCountAttribute()
    {
        return $this->evaluations->where('user.role', '=', 'teacher')->count();
    }
}
