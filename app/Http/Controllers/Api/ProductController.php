<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Muestra una lista de productos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo recuperar la lista de productos. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|numeric|unique:products,code',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'quantity' => 'required|integer',
            ]);

            $product = Product::create($validated);
            return response()->json($product, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Datos incorrectos. No se pudo crear el producto.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el producto. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    /**
     * Muestra un producto específico.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        try {
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo recuperar el producto. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'code' => ['required', 'numeric', Rule::unique('products', 'code')->ignore($product->id)],
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'quantity' => 'required|integer',
            ]);

            $product->update($validated);
            return response()->json($product);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Datos incorrectos. No se pudo actualizar el producto.'
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar el producto. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    /**
     * Elimina un producto de la base de datos.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([
                'message' => 'Producto eliminado exitosamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo eliminar el producto. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }
}
