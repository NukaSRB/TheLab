<?php

namespace App\Services\Clients\Models;

use App\Models\BaseModel;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends BaseModel
{
    use CrudTrait, Sluggable, SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'asana_id',
        'toggl_id',
        'abbreviation',
        'label',
        'color',
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

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}
