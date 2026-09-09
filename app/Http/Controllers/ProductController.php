<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Producto;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
    public function inicio(): View
    {
        return view('catalog.index', [
            'productos' => Producto::query()->latest()->paginate(12),
        ]);
    }

    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        return view('products.index', [
            'productos' => Producto::query()->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Producto::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified product.
     */
    public function show(Producto $producto): View
    {
        return view('products.show', [
            'producto' => $producto,
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Producto $producto): View
    {
        return view('products.edit', [
            'producto' => $producto,
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
