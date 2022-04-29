<?php

return [
    /**
     * The list of domains hosting your central app.
     *
     * Only relevant if you're using the domain or subdomain identification middleware.
     */
    'central_domains' => [
        '127.0.0.1',
        'tenant.local',
        // 127.0.0.1 tenant.local
        // 127.0.0.1 shop1.tenant.local
    ],

    'features' => [
        App\Features\TelescopeTags::class,
    ],
];
