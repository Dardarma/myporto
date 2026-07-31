<?php

$trustedProxies = explode(
    ',',
    (string) env('TRUSTED_PROXIES', '127.0.0.1,::1')
);

return [
    'trusted' => array_values(
        array_filter(
            array_map('trim', $trustedProxies),
            fn (string $proxy): bool => $proxy !== '',
        )
    ),
];