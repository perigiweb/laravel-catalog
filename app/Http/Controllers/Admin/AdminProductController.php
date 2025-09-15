<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $brand_id = (int) $request->query('brand_id');
      $category_id = (int) $request->query('category_id');
      $q = $request->query('q');

      $product = new Product();
      if ($brand_id){
        $product = $product->where('brand_id', $brand_id);
      }
      if ($category_id){
        $product = $product->where('category_id', $category_id);
      }
      if ($q != ''){
        $product = $product->where(function($query) use ($q){
          $query->whereLike('name', '%'.$q.'%')->orWhereLike('code', $q);
        });
      }
      $products = $product->orderBy('id', 'DESC')->paginate(20);

      $brands = Brand::orderBy('name', 'ASC')->get();
      $cats = Category::orderBy('name', 'ASC')->get();

      return view('admin.products.list', [
        'pageTitle' => 'List Products',
        'brands' => $brands,
        'cats' => $cats,
        'products' => $products
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return $this->edit(new Product());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
      $newProduct = $request->saveProduct();
      if ($newProduct && $newProduct->exists){
        return redirect()->route('admin.products.edit', ['product' => $newProduct])->with('product_message', [
          'type' => 'success',
          'text' => 'Product ('.$newProduct->name.') successfully added.'
        ]);
      }

      return redirect()->back()->with('product_message', [
        'type' => 'danger',
        'text' => 'Product failed to add.'
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
      return view('admin.products.form', [
        'pageTitle' => $product->exists ? 'Edit Product':'Add Product',
        'product' => $product,
        'brands' => Brand::orderBy('name', 'ASC')->get(),
        'cats' => Category::orderBy('name', 'ASC')->get(),
        'back' => route('admin.products.index')
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
      if ($request->saveProduct($product)){
        $message = [
          'type' => 'success',
          'text' => 'Product successfully updated.'
        ];
      } else {
        $message = [
          'type' => 'danger',
          'text' => 'Product failed to update.'
        ];
      }
      return redirect()->back()->with('product_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ?Product $product)
    {
      $errorMsg = null;
      $successMsg = null;
      if ($product && $product->exists){
        $name = $product->name;
        try{
          $result = $product->delete();
          if ($result){
            $successMsg = 'Product "'.$name.'" successfully deleted.';
          } else {
            $errorMsg = 'Product "'.$name.'" failed to delete.';
          }
        } catch (Exception $e){
          $errorMsg = 'Product "'.$name.'" failed to delete.';
        }
      } else {
        $id = $request->input('id');
        if ( !is_array($id)){
          $id = [$id];
        }
        if ($total = count($id)){
          try {
            $result = Product::destroy($id);
            if ($result){
              $successMsg = $total . ($total > 1 ? ' products':' product') . ' successfully deleted.';
            } else {
              $errorMsg = 'Failed to delete products.';
            }
          } catch (Exception $e){
            $errorMsg = 'Failed to delete products.';
          }
        } else {
            $errorMsg = 'No products to be deleted.';
        }
      }

      if ($errorMsg){
        $message = [
          'type' => 'danger',
          'text' => $errorMsg
        ];
      } else {
        $message = [
          'type' => 'success',
          'text' => $successMsg
        ];
      }

      $request->session()->flash('product_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.products.index');
      }
    }

    public function removeImage(Request $request, Product $product)
    {
      if ($product->image){
        if (File::delete($product->image_path)){
          $product->image = null;
          $product->save();
          $message = [
            'type' => 'success',
            'text' => 'Product Image successfully removed.'
          ];
        } else {
          $message = [
            'type' => 'danger',
            'text' => 'Failed to remove Product Image.'
          ];
        }
      }

      $request->session()->flash('product_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.products.edit', ['product' => $product]);
      }
    }
}
