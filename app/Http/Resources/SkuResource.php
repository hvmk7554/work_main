<?php

namespace App\Http\Resources;

use App\Models\Sku;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SkuResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var Sku $model */
        $model = $this;

        return [
            'id' => $model->id,
            'type' => $model->type,
            'school_year' => $model->school_year,
            'website_name' => $model->website_name,
            'name' => $model->name,
            'status' => $model->status,
            'start_date' => $model->start_date,
            'end_date' => $model->end_date,
            'unit_number' => $model->unit_number,
             'original_price'  => $model->original_price,
             'listing_price' => $model->listing_price,
             'unit_type' => $model->unit_type,
             'note' => $model->note,
             
             'grade' => $model->grade,
             'subject' => $model->subject,
        ];
    }
}