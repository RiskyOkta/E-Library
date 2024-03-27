<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collection),
            'meta' => [
                "success" => true,
                "message" => "Success get product lists",
                'pagination' => $this->metaData()
            ]
        ];
    }

    private function transformData($data)
    {
        return [
            'id' => $data->id,
            'book_title' => $data->book_title,
            'book_number' => $data->book_number,
            'location' => $data->location,
            'is_scan' => $data->is_scan,
            'file_path' => $data->file_path,
            'utility_id' => $data->utility_id,
            'utility_name' => $data->utility->name,
            'category_id' => $data->category_id,
            'category_name' => $data->category->name,
            'file_path_url' => $data->file_path_url,
        ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int) $this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }
}