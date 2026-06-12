<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'status'=>$this->status,
            'description'=>$this->description,
            'cost'=>$this->cost,
            'pdf'=>$this->pdf,

            'image'=>asset($this->image),
            'reviews' => $this->reviews,
            'avg_rating'=>$this->reviews->avg('rating'),
            'count'=>$this->reviews->count(),
            'category'=>new CategoryResource($this->category)
        ];
    }
}
