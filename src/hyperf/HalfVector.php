<?php

namespace Pgvector\Hyperf;

use Hyperf\Contract\Castable;
use Hyperf\Contract\CastsAttributes;

class HalfVector extends \Pgvector\HalfVector implements Castable
{
	public static function castUsing(): CastsAttributes
    {
	    return new class implements CastsAttributes {

            public function get(mixed $model, string $key, mixed $value, array $attributes): ?HalfVector
            {
                if (is_null($value)) {
                    return null;
                }

                // return HalfVector instead of array
                // since HalfVector needed for orderByRaw and selectRaw
                return new HalfVector($value);
            }

            public function set(mixed $model, string $key, mixed $value, array $attributes): ?string
            {
                if (is_null($value)) {
                    return null;
                }

                if (!($value instanceof HalfVector)) {
                    $value = new HalfVector($value);
                }

                return (string) $value;
            }
        };
    }
}
