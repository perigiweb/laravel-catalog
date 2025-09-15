<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $brands = Brand::orderBy('name', 'ASC')->paginate(20);

      return view('admin.brands.list', [
        'pageTitle' => 'List Brands',
        'brands' => $brands
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return $this->edit(new Brand());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
      $newBrand = $request->saveBrand();
      if ($newBrand && $newBrand->exists){
        return redirect()->route('admin.brands.edit', ['brand' => $newBrand])->with('brand_message', [
          'type' => 'success',
          'text' => 'Brand ('.$newBrand->name.') successfully added.'
        ]);
      }

      return redirect()->back()->with('brand_message', [
        'type' => 'danger',
        'text' => 'Brand failed to add.'
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
      return view('admin.brands.form', [
        'pageTitle' => $brand->exists ? 'Edit Brand':'Add Brand',
        'brand' => $brand,
        'back' => route('admin.brands.index')
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
      if ($request->saveBrand($brand)){
        $message = [
          'type' => 'success',
          'text' => 'Brand successfully updated.'
        ];
      } else {
        $message = [
          'type' => 'danger',
          'text' => 'Brand failed to update.'
        ];
      }
      return redirect()->back()->with('brand_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ?Brand $brand = null)
    {
      $errorMsg = null;
      $successMsg = null;
      if ($brand && $brand->exists){
        $name = $brand->name;
        try{
          $result = $brand->delete();
          if ($result){
            $successMsg = 'Brand "'.$name.'" successfully deleted.';
          } else {
            $errorMsg = 'Brand "'.$name.'" failed to delete.';
          }
        } catch (Exception $e){
          $errorMsg = 'Brand "'.$name.'" failed to delete.';
        }
      } else {
        $id = $request->input('id');
        if ( !is_array($id)){
          $id = [$id];
        }
        if ($total = count($id)){
          try {
            $result = Brand::destroy($id);
            if ($result){
              $successMsg = $total . ($total > 1 ? ' brands':' brand') . ' successfully deleted.';
            } else {
              $errorMsg = 'Failed to delete Brands.';
            }
          } catch (Exception $e){
            $errorMsg = 'Failed to delete Brands.';
          }
        } else {
            $errorMsg = 'No brands to be deleted.';
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

      $request->session()->flash('brand_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.brands.index');
      }
    }

    public function removeLogo(Request $request, Brand $brand)
    {
      if ($brand->logo){
        if (File::delete($brand->logo_path)){
          $brand->logo = null;
          $brand->save();
          $message = [
            'type' => 'success',
            'text' => 'Brand Logo successfully removed.'
          ];
        } else {
          $message = [
            'type' => 'danger',
            'text' => 'Failed to remove Brand Logo.'
          ];
        }
      }

      $request->session()->flash('brand_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.brands.index');
      }
    }
}
