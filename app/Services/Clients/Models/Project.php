<?php

namespace App\Services\Clients\Models;

use App\Models\BaseModel;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use CrudTrait, Sluggable, SoftDeletes;

    protected $table = 'client_projects';

    protected $fillable = [
        'toggl_id',
        'client_id',
        'label',
        'color',
        'rate',
        'estimated_hours',
        'billable_flag',
        'active_flag',
        'private_flag',
        'created_at',
    ];

    protected $appends = [
        'clientAndLabel',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'name' => [
                'source' => 'label',
            ],
        ];
    }

    public function getClientAndLabelAttribute()
    {
        return $this->client->label . ': ' . $this->label;
    }

    public function taskCount()
    {
        return $this->hasOne(Task::class)
                    ->selectRaw('project_id, count(*) as count')->groupBy('project_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}
