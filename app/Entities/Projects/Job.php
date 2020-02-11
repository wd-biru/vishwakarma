<?php

namespace App\Entities\Projects;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Job Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class Job extends Model
{

    use PresentableTrait;
    protected $table = 'vishwa_jobs';
    protected $presenter = JobPresenter::class;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function nameLink()
    {
        return link_to_route('jobs.show', $this->name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('job.job')]
            ),
        ]);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function worker()
    {
        return $this->belongsTo('App\Models\EmployeeProfile', 'worker_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('progress')->orderBy('position');
    }

    public function type()
    {
        return $this->type_id == 1 ? trans('job.main') : trans('job.additional');
    }

    public function getProgressAttribute()
    {
        return $this->tasks->isEmpty() ? 0 : $this->tasks->avg('progress');
    }

    public function getReceiveableEarningAttribute()
    {
        return $this->price * ($this->progress / 100);
    }
}
