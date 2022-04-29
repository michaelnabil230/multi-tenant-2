<?php

namespace App\Models;

use App\Traits\BelongsToPrimaryModel;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use BelongsToPrimaryModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
    ];

    public function getRelationshipToPrimaryModel(): string
    {
        return 'post';
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
