<?php

namespace App\Models;

use App\Scopes\TenantScopeByAuthentication;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'tenant_id',
    ];

    protected $scopeTenant = TenantScopeByAuthentication::class;

    /**
     * Get all of the comments for the Post
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
