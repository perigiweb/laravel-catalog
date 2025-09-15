<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $cats = Category::orderBy('name', 'ASC')->paginate(20);

      return view('admin.cats.list', [
        'pageTitle' => 'List Categories',
        'cats' => $cats
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return $this->edit(new Category());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
      $newCat = $request->saveCategory();
      if ($newCat && $newCat->exists){
        return redirect()->route('admin.cats.edit', ['cat' => $newCat])->with('category_message', [
          'type' => 'success',
          'text' => 'Category ('.$newCat->name.') successfully added.'
        ]);
      }

      return redirect()->back()->with('category_message', [
        'type' => 'danger',
        'text' => 'Category failed to add.'
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $cat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $cat)
    {
      return view('admin.cats.form', [
        'pageTitle' => $cat->exists ? 'Edit Category':'Add Category',
        'category' => $cat,
        'back' => route('admin.cats.index')
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $cat)
    {
      if ($request->saveCategory($cat)){
        $message = [
          'type' => 'success',
          'text' => 'Category successfully updated.'
        ];
      } else {
        $message = [
          'type' => 'danger',
          'text' => 'Category failed to update.'
        ];
      }
      return redirect()->back()->with('category_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ?Category $cat)
    {
      $errorMsg = null;
      $successMsg = null;
      if ($cat && $cat->exists){
        $name = $cat->name;
        try{
          $result = $cat->delete();
          if ($result){
            $successMsg = 'Category "'.$name.'" successfully deleted.';
          } else {
            $errorMsg = 'Category "'.$name.'" failed to delete.';
          }
        } catch (Exception $e){
          $errorMsg = 'Category "'.$name.'" failed to delete.';
        }
      } else {
        $id = $request->input('id');
        if ( !is_array($id)){
          $id = [$id];
        }
        if ($total = count($id)){
          try {
            $result = Category::destroy($id);
            if ($result){
              $successMsg = $total . ($total > 1 ? ' categories':' category') . ' successfully deleted.';
            } else {
              $errorMsg = 'Failed to delete Categories.';
            }
          } catch (Exception $e){
            $errorMsg = 'Failed to delete Categories.';
          }
        } else {
            $errorMsg = 'No categories to be deleted.';
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

      $request->session()->flash('category_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.cats.index');
      }
    }
}
