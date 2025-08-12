<?php

namespace Pgvector\Hyperf;

use Hyperf\Database\Model\Concerns\HasGlobalScopes;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Query\Builder;

/**
 * @method static nearestNeighbors(string $column, mixed $value, Distance $distance)
 */
trait HasNeighbors
{
    
    public function scopeNearestNeighbors(\Hyperf\Database\Query\Builder $query, string $column, mixed $value, Distance $distance): void
    {
        $op = match ($distance) {
            Distance::L2 => '<->',
            Distance::InnerProduct => '<#>',
            Distance::Cosine => '<=>',
            Distance::L1 => '<+>',
            Distance::Hamming => '<~>',
            Distance::Jaccard => '<%>',
            default => throw new \InvalidArgumentException("Invalid distance"),
        };
        $wrapped = $query->getGrammar()->wrap($column);
        $order = "$wrapped $op ?";
        $neighborDistance = $distance == Distance::InnerProduct ? "($order) * -1" : $order;
        $vector = is_array($value) ? new Vector($value) : $value;
        
        // ideally preserve existing select, but does not appear to be a way to get columns
        $query->select()
            ->selectRaw("$neighborDistance AS neighbor_distance", [$vector])
            ->withCasts(['neighbor_distance' => 'double'])
            ->whereNotNull($column)
            ->orderByRaw($order, [$vector]);
    }
    
    public function nearestNeighbors(string $column, Distance $distance): \Hyperf\Database\Model\Builder
    {
        $id = $this->getKey();
        if (!array_key_exists($column, $this->attributes)) {
            throw new \Hyperf\Database\Exception\InvalidArgumentException($this, $column);
        }
        $value = $this->getAttributeValue($column);
        return static::whereKeyNot($id)
            ->nearestNeighbors($column, $value, $distance);
    }
}
