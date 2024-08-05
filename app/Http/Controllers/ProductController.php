<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class ProductController extends Controller
{
    /**
     * Muestra una lista de productos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $products = Product::all();
            return view('products.index', compact('products'));
        } catch (Exception $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo recuperar la lista de productos. Por favor, inténtelo de nuevo más tarde.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
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

            Product::create($validated);
            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo crear el producto. Datos incorrectos');
        } catch (Exception $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo crear el producto. Por favor, inténtelo de nuevo más tarde.');
        }
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|numeric',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'quantity' => 'required|integer',
            ]);

            $product->update($validated);
            return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo editar el producto. Datos incorrectos');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('products.index')
                            ->with('error', 'Producto no encontrado.');
        } catch (Exception $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo actualizar el producto. Por favor, inténtelo de nuevo más tarde.');
        }
    }

    /**
     * Elimina un producto de la base de datos.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('products.index')
                            ->with('error', 'No se pudo eliminar el producto. Por favor, inténtelo de nuevo más tarde.');
        }
    }
}
