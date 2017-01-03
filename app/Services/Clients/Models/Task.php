<?php

namespace App\Services\Clients\Models;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use Sluggable, SoftDeletes;

    protected $table = 'client_tasks';

    protected $fillable = [
        'toggl_id',
        'project_id',
        'label',
        'estimated_seconds',
        'active_flag',
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

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
