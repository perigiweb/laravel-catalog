<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $accounts = User::orderBy('id', 'DESC')->paginate(20);

      return view('admin.accounts.list', [
        'pageTitle' => 'List Accounts',
        'accounts' => $accounts
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accounts.form', [
          'pageTitle' => 'Add Account',
          'account' => new User(),
          'back' => route('admin.accounts.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
      $newUser = $request->addUser();
      if ($newUser && $newUser->exists){
        return redirect()->route('admin.accounts.edit', ['account' => $newUser])->with('account_message', [
          'type' => 'success',
          'text' => 'Account ('.$newUser->name.') successfully added.'
        ]);
      }

      return redirect()->back()->with('account_message', [
        'type' => 'danger',
        'text' => 'Account failed to add.'
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
      return view('admin.accounts.form', [
        'pageTitle' => 'Edit Account',
        'account' => $account,
        'back' => route('admin.accounts.index')
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $account)
    {
      $message = [
        'type' => 'danger',
        'text' => 'Account failed to update.'
      ];

      if ($request->updateUser($account)){
        $successMsg = 'Account successfully updated.';
        if ($account->id == $request->user()->id){
          $successMsg = 'Your account successfully updated.';
        }

        $message = [
          'type' => 'success',
          'text' => $successMsg
        ];
      }

      return redirect()->back()->with('account_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ?User $account = null)
    {
      $errorMsg = null;
      $successMsg = null;
      if ($account && $account->exists){
        $name = $account->name;
        try{
          $result = $account->delete();
          if ($result){
            $successMsg = 'Account "'.$name.'" successfully deleted.';
          } else {
            $errorMsg = 'Account "'.$name.'" failed to delete.';
          }
        } catch (Exception $e){
          $errorMsg = 'Account "'.$name.'" failed to delete.';
        }
      } else {
        $id = $request->input('id');
        if ( !is_array($id)){
          $id = [$id];
        }
        if ($total = count($id)){
          try {
            $result = User::destroy($id);
            if ($result){
              $successMsg = $total . ($total > 1 ? ' accounts':' account') . ' successfully deleted.';
            } else {
              $errorMsg = 'Failed to delete Accounts.';
            }
          } catch (Exception $e){
            $errorMsg = 'Failed to delete Accounts.';
          }
        } else {
            $errorMsg = 'No accounts to be deleted.';
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

      $request->session()->flash('account_message', $message);

      if ($request->acceptsJson()){
        return response()->json(['status' => true]);
      } else {
        return redirect()->route('admin.accounts.index');
      }
    }
}
