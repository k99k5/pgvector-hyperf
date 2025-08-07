<?php

namespace Pgvector\Hyperf;


use Hyperf\Contract\Castable;
use Hyperf\Contract\CastsAttributes;

class Vector extends \Pgvector\Vector implements Castable
{
	public static function castUsing(): CastsAttributes
    {
	    return new class implements CastsAttributes {
            public function get(mixed $model, string $key, mixed $value, array $attributes): ?Vector
            {
                if (is_null($value)) {
                    return null;
                }

                // return Vector instead of array
                // since Vector needed for orderByRaw and selectRaw
                return new Vector($value);
            }

            public function set(mixed $model, string $key, mixed $value, array $attributes): ?string
            {
                if (is_null($value)) {
                    return null;
                }

                if (!($value instanceof Vector)) {
                    $value = new Vector($value);
                }

                return (string) $value;
            }
        };
    }
}
