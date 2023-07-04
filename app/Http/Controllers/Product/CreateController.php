<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\File;

class CreateController extends Controller
{
    //

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => ['required'],
                "description" => ['required'],
                "price" => ['required'],
                "category_id" => ['required'],
                "likes" => ['required'],
                "sales" => ['required'],
                "image" => [File::image(), 'mimes:png,jpg,jpeg,gif']
            ]);

            $created_product = Product::query()->create(
                [
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'price' => $validated['price'],
                    'category_id' => $validated['category_id'],
                    'likes' => $validated['likes'],
                    'sales' => $validated['sales'],
                    'image' => $this->getUploadedImagePath()
                ]
            );

            return response()->json([
                "created" => true,
                "product" => $created_product
            ], 201);
        } catch (ValidationException $err) {
            return response()->json(
                [
                    'created' => false,
                    'errors' => $err->errors()
                ],
                400
            );
        }
    }


    public function getUploadedImagePath()
    {
        if (!request()->hasFile('image')) return null;

        return request()
            ->file('image')
            ->storeAs(
                'product',
                request()->file('image')->getClientOriginalName(),
                ['disk' => 'public']
            );
    }
}
