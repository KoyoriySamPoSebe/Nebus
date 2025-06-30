<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CastQueryParams
{
    /**
     * @var array<string, 'int'|'float'|'bool'>
     */
    protected array $casts = [
        'per_page'    => 'int',
        'building_id' => 'int',
        'activity_id' => 'int',
        'level'       => 'int',
        'radius'      => 'float',
        'latitude'    => 'float',
        'longitude'   => 'float',
    ];

    public function handle(Request $request, Closure $next)
    {
        foreach ($this->casts as $param => $type) {
            if ($request->query->has($param)) {
                $raw = $request->query($param);
                $value = match ($type) {
                    'int'   => (int) $raw,
                    'float' => (float) $raw,
                    'bool'  => filter_var($raw, FILTER_VALIDATE_BOOLEAN),
                };
                $request->query->set($param, $value);
            }
        }

        return $next($request);
    }
}
