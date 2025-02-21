<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProductController extends AppBaseController
{
    /**
     * @var ProductRepository
     */
    public $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $categories = Category::pluck('name', 'id')->toArray();

        return view('products.create', compact('categories'));
    }

    public function store(CreateProductRequest $request): RedirectResponse
    {
        $input = $request->all();
        $this->productRepository->store($input);
        Flash::success(__('messages.flash.product_created_successfully'));

        return redirect()->route('products.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function edit(Product $product): \Illuminate\View\View
    {
        $categories = Category::pluck('name', 'id')->toArray();
        $product->load('category');

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $input = $request->all();
        $this->productRepository->updateProduct($input, $product->id);
        Flash::success(__('messages.flash.product_updated_successfully'));

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): JsonResponse
    {
        $invoiceModels = [
            InvoiceItem::class,
        ];
        $result = canDelete($invoiceModels, 'product_id', $product->id);
        if ($result) {
            return $this->sendError(__('messages.flash.product_cant_deleted'));
        }
        $product->delete();

        return $this->sendSuccess(__('messages.flash.product_deleted_successfully'));
    }

    /**
     * @return Application|Factory|View
     */
    public function show(Product $product): \Illuminate\View\View
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
