<?php

namespace Moawiaab\QTheme\Support;

use Illuminate\Validation\ValidationException;
use Moawiaab\QTheme\Support\FilterQueryBuilder;

trait HasAdvancedFilter
{
    public function scopeAdvancedFilter($query)
    {
        return $this->processQuery($query, [
            'order_column'    => request('sortBy', 'id'),
            'order_direction' => request('sortType', 'desc'),
            // 'limit'           => request('limit', 10),
            's'               => request('s', null),
        ]);
    }

    public function processQuery($query, $data)
    {
        $data = $this->processGlobalSearch($data);

        $v = validator()->make($data, [
            'order_column'    => 'sometimes|required|in:' . $this->orderableColumns(),
            'order_direction' => 'sometimes|required|in:asc,desc',
            'limit'           => 'sometimes|required|integer|min:1',
            's'               => 'sometimes|nullable|string',

            // advanced filter
            'filter_match' => 'sometimes|required|in:and,or',
            'f'            => 'sometimes|required|array',
            'f.*.column'   => 'required|in:' . $this->whiteListColumns(),
            'f.*.operator' => 'required_with:f.*.column|in:' . $this->allowedOperators(),
            'f.*.query_1'  => 'required',
            'f.*.query_2'  => 'required_if:f.*.operator,between,not_between',
        ]);

        if ($v->fails()) {
            throw new ValidationException($v);
        }

        $data = $v->validated();

        return (new FilterQueryBuilder())->apply($query, $data);
    }

    protected function orderableColumns()
    {
        return implode(',', $this->orderable);
    }

    protected function whiteListColumns()
    {
        return implode(',', $this->filterable);
    }

    protected function allowedOperators()
    {
        return implode(',', [
            'contains',
        ]);
    }

    protected function processGlobalSearch($data)
    {
        if (isset($data['f']) || !isset($data['s'])) {
            return $data;
        }

        $data['filter_match'] = 'or';

        $data['f'] = array_map(function ($column) use ($data) {
            return [
                'column'   => $column,
                'operator' => 'contains',
                'query_1'  => $data['s'],
            ];
        }, $this->filterable);

        return $data;
    }
}
