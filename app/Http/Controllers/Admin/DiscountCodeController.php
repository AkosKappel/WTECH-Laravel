<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

/**
 * Discount codes in the admin zone: list, create, edit, delete.
 */
class DiscountCodeController extends Controller
{
    public function index()
    {
        return view('layout.admin.codes', ['codes' => DiscountCode::orderBy('code')->get(), 'code' => null]);
    }

    public function store(Request $request)
    {
        $code = DiscountCode::create($this->validated($request));

        return redirect()->route('admin.codes')->with('success_message', __('Code :code saved.', ['code' => $code->code]));
    }

    public function edit(DiscountCode $code)
    {
        return view('layout.admin.codes', ['codes' => DiscountCode::orderBy('code')->get(), 'code' => $code]);
    }

    public function update(Request $request, DiscountCode $code)
    {
        $code->update($this->validated($request, $code));

        return redirect()->route('admin.codes')->with('success_message', __('Code :code saved.', ['code' => $code->code]));
    }

    public function destroy(DiscountCode $code)
    {
        $code->delete();

        return redirect()->route('admin.codes')->with('success_message', __('Code :code deleted.', ['code' => $code->code]));
    }

    private function validated(Request $request, ?DiscountCode $code = null)
    {
        $request->merge(['code' => mb_strtoupper(trim((string) $request->code))]);
        $data = $request->validate([
            'code' => ['required', 'string', 'max:40', 'regex:/^[A-Z0-9_-]+$/', Rule::unique('discount_codes', 'code')->ignore($code)],
            'type' => ['required', Rule::in(DiscountCode::TYPES)],
            'value' => ['required', 'numeric', 'gt:0', $request->type === 'percent' ? 'max:100' : 'max:100000'],
            'min_order' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'per_customer_limit' => 'nullable|integer|min:1',
        ]);

        return array_merge($data, [
            'min_order' => $data['min_order'] ?? 0,
            'expires_at' => filled($data['expires_at'] ?? null) ? Carbon::parse($data['expires_at'], config('demo.reset.timezone')) : null,
            'active' => $request->boolean('active'),
        ]);
    }
}
