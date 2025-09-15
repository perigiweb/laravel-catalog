<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstructionPageRequest;
use App\Http\Requests\UpdateInstructionPageRequest;
use App\Models\InstructionPage;

class AdminInstructionPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pages = InstructionPage::orderBy('id', 'DESC')->paginate(20);

        return view('admin.pages.list', [
          'pageTitle' => 'Pages',
          'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.form', [
          'pageTitle' => 'Add New Page',
          'page' => new InstructionPage()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructionPageRequest $request)
    {
        //
        $validated = $request->createInstructionPage();

        return response()->json($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructionPage $instructionPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructionPage $instructionPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructionPageRequest $request, InstructionPage $instructionPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructionPage $instructionPage)
    {
        //
    }
}
