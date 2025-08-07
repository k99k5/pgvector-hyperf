<?php

namespace Pgvector\Hyperf;

use Hyperf\Contract\Castable;
use Hyperf\Contract\CastsAttributes;

class SparseVector extends \Pgvector\SparseVector implements Castable
{
	public static function castUsing(): CastsAttributes
    {
	    return new class implements CastsAttributes {

            public function get(mixed $model, string $key, mixed $value, array $attributes): ?\Pgvector\SparseVector
            {
                if (is_null($value)) {
                    return null;
                }

                return new SparseVector($value);
            }

            public function set(mixed $model, string $key, mixed $value, array $attributes): ?string
            {
                if (is_null($value)) {
                    return null;
                }

                // TODO use !($value instanceof SparseVector) in 0.3.0
                if (is_array($value) || $value instanceof \SplFixedArray) {
                    $value = new SparseVector($value);
                }

                return (string) $value;
            }
        };
    }
}
