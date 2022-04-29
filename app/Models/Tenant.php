<?php


namespace App\Models;

use App\Exceptions\TenantCouldNotBeIdentified;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Tenant extends Model
{
    use Uuids;

    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getKeyName());
    }

    /**
     * Initializes the domain.
     *
     * @param string $value
     * @param string $column
     * @return ?Tenant
     * @throws TenantCouldNotBeIdentified
     */
    public static function findBy($value, $column = 'domain'): ?Tenant
    {
        $tenant = static::query()
            ->when($column == 'domain', function (Builder $query) use ($value) {
                $query->whereRelation('domains', 'domain', $value);
            }, function (Builder $query) use ($column, $value) {
                $query->where($column, $value);
            })
            ->with('domains')
            ->first();

        if (! $tenant) {
            throw new TenantCouldNotBeIdentified($column, $value);
        }

        $tenant->configure();

        return $tenant;
    }

    public function configure()
    {
        $prefix = config('cache.prefix') . '_tenant_' . $this->getTenantKey();

        config()->set('cache.prefix', $prefix);

        cache()->purge($this->storeName);

        // This is important because the `CacheManager` will have the `$app['config']` array cached
        // with old prefixes on the `cache` instance. Simply calling `forgetDriver` only removes
        // the `$store` but doesn't update the `$app['config']`.
        app()->forgetInstance('cache');

        Cache::clearResolvedInstances();
    }
}
