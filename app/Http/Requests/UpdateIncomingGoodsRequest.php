<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIncomingGoodsRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() !== null;
    }

    public function rules()
    {
        $incomingGoodsId = $this->route('barang_masuk') ?? $this->route('id');

        return [
            'receiving_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('incoming_goods', 'receiving_code')->ignore($incomingGoodsId),
            ],
            'container_number' => ['nullable', 'string', 'max:50'],
            'receiving_date' => ['required', 'date'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'delivery_order_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'exists:barangs,id', 'distinct'],
            'items.*.quantity_received' => ['required', 'integer', 'min:1'],
            'items.*.rack_location_id' => ['required', 'exists:rack_locations,id'],
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'Please add at least one incoming item.',
            'items.min' => 'Please add at least one incoming item.',
            'items.*.item_id.required' => 'The item field is required.',
            'items.*.item_id.exists' => 'The selected item is invalid.',
            'items.*.item_id.distinct' => 'Each incoming item must be unique.',
            'items.*.quantity_received.required' => 'The received quantity is required.',
            'items.*.quantity_received.integer' => 'The received quantity must be a whole number.',
            'items.*.quantity_received.min' => 'The received quantity must be at least 1.',
            'items.*.rack_location_id.required' => 'Please select a rack location for each item.',
            'items.*.rack_location_id.exists' => 'The selected rack location is invalid.',
        ];
    }
}
