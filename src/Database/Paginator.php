<?php

namespace Caneara\Spine\Database;

use Caneara\Spine\Support\Arr;
use Caneara\Spine\Support\Str;
use Caneara\Spine\Types\ListRequest;
use Illuminate\Pagination\Paginator as BasePaginator;
use Caneara\Spine\Exception\TemporaryRedirectException;

class Paginator extends BasePaginator
{
    /**
     * Prepare the response using the instance and the request.
     *
     */
    public function format(ListRequest $request) : array
    {
        if ($this->currentPage() !== 1 && $this->items->isEmpty()) {
            $this->redirectToFirstPage($request->query());
        }

        return [
            'type'        => 'SimplePaginator',
            'data'        => [
                'rows'    => $this->items->toArray(),
                'columns' => $request->columns(),
            ],
            'search'      => [
                'filtering' => $request->filtering(),
                'ordering'  => $request->ordering(),
                'order_key' => $request->orderKey(),
            ],
            'pagination'  => [
                'current_page'   => $this->currentPage(),
                'first_page_url' => $this->url(1),
                'from'           => $this->firstItem(),
                'last_page'      => null,
                'last_page_url'  => null,
                'links'          => null,
                'next_page_url'  => $this->nextPageUrl(),
                'path'           => $this->path(),
                'per_page'       => $this->perPage(),
                'prev_page_url'  => $this->previousPageUrl(),
                'to'             => $this->lastItem(),
                'total'          => null,
            ],
        ];
    }

    /**
     * Trigger a redirect to the first page of the paginator.
     *
     */
    protected function redirectToFirstPage(array $query) : void
    {
        $query[$this->pageName] = 1;

        $url = Str::of($this->path())
            ->append('?')
            ->append(Arr::query($query))
            ->toString();

        throw new TemporaryRedirectException($url);
    }
}
