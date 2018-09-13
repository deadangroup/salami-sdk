<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait CommonScopes
{
    /**
     * Get enum values from a column.
     *
     * @param  string $column
     *
     * @return array
     */
    public static function getEnumValues($column)
    {
        $instance = new static();
        $type = DB::select(DB::raw('SHOW COLUMNS FROM ' . $instance->getTable() . ' WHERE Field = "' . $column . '"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }

        return $enum;
    }

    /**
     * Scope the query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisWeek($query, $field)
    {
        $from = now()->startOfWeek();
        $to = now()->endOfWeek();

        if (!is_null($field)) {

            return $query->whereBetween($field, [$from, $to]);
        }

        return $query;

    }

    /**
     * Scope the query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query, $field)
    {
        $from = now()->startOfDay();
        $to = now()->endOfDay();

        if (!$field) {
            $field = "created_at";
        }

        return $query->whereBetween($field, [$from, $to]);

    }

    /**
     * Scope the query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder $query, $type = 'asc')
    {
        return $query->orderBy('id', $type);
    }

    /**
     * Scope the query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->sort('desc');
    }
}