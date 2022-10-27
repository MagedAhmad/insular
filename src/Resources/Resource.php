<?php

namespace MagedAhmad\Insular\Resources;

use Illuminate\Http\JsonResponse;
use MagedAhmad\Insular\Types\MetaType;
use MagedAhmad\Insular\Types\MessageType;
use MagedAhmad\Insular\Support\RangeService;
use MagedAhmad\Insular\Resources\RangeResource;
use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;

class Resource
{
    public ?MetaType $meta = null;
    public string $filter;
    public ?MessageType $message = null;
    public string $status;
    public array $filters;
    public bool $ranges;
    public $resource;
    public $data;

    public function __construct($data = null, string $filter = '', MessageType $message = null, $status = 200, $resource = null, $ranges = false)
    {
        $this->data = $data;
        $this->filter = $filter;
        $this->message = $message;
        $this->status = $status;
        $this->resource = $resource;
        $this->ranges = $ranges;
    }

    /**
     * To Array
     *
     * @return JsonResponse
     */
    public function toArray()
    {
        if($this->filter) {
            $this->setFilters();
        }

        if ($this->data instanceof Collection) {
            $this->setCollectionData();
        }else if($this->data instanceof LengthAwarePaginator) {
            $this->setPaginatorData();
        }else {
            $this->data = $this->resource ? $this->resource::from($this->data) : $this->data;
        }
        
        return ok(
            status: $this->status,
            message: $this->message,
            filters: $this->filters ?? [],
            meta: $this->meta,
            data: $this->data,
            ranges: $this->ranges ? $this->getRanges() : null,
            range: $this->ranges ? $this->getSelectedRange() : null
        );
    }

    private function getRanges()
    {
        return RangeResource::collection(RangeService::ranges());
    }

    private function getSelectedRange()
    {
        return (new RangeService())->range(request()->range);
    }

    private function setCollectionData(): void
    {
        if($this->resource) {
            $this->data = $this->resource::collection($this->data);
        }
    }

    private function setPaginatorData(): void
    {
        // set meta data
        $this->meta = $this->getMetaData();

        if($this->resource) {
            $this->data = $this->resource::collection($this->data->items());
        }else {
            $this->data = $this->data->items();
        }
    }

    private function setFilters(): void
    {
        $this->filters = $this->getFilters();
    }

    private function getMetaData(): MetaType
    {
        return new MetaType(
            count: $this->data->perPage(), // per page
            pages: $this->data->currentPage(), // currently, selected page
            total: $this->data->total() // total records
        );
    }

    private function getFilters(): array
    {
        return (new $this->filter(request()))->get_data();
    }
}
