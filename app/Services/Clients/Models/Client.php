<?php

namespace App\Services\Clients\Models;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;

class Client extends BaseModel
{
    use Sluggable;

    protected $table = 'clients';

    protected $fillable = [
        'asana_id',
        'toggl_id',
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
}
