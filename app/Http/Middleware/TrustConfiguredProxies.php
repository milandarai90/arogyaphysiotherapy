<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustConfiguredProxies extends Middleware
{
    protected function proxies()
    {
        $proxies = (string) config('app.trusted_proxies', '');

        return $proxies === '' ? null : array_map('trim', explode(',', $proxies));
    }
}
