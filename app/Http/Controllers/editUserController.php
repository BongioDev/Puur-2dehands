<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\User;
use App\Adver;

class editUserController extends Controller
{
    public function edit($id){
        $user = User::find($id);
        return view('editUser')->with('user', $user);
   }

  //update user
  public function update(Request $request, $id){
    //Validate??
    $this->validate($request, [
     'name' => 'required',
     'location' => 'nullable',
     'tel' => 'nullable',
     'user_image' => 'image|max:5000',
 ]);

//handle
 if($request->hasFile('user_image')){
     //met extension
     $fileNameWithExtension = $request->file('user_image')->getClientOriginalName();
     //zonder extension enkel naam
     $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
     //enkel extension
     $extension = $request->file('user_image')->getClientOriginalExtension();
     //naam die word opgeslagen
     $fileNameToStore = $fileName.'_'.time().'.'.$extension;
     //opslaan
     $path = $request->file('user_image')->storeAs('public/user_images', $fileNameToStore);
 }

//create
 $user = User::find($id);
 $user->name = $request->input('name');
 $user->location = $request->input('location');
 $user->tel = $request->input('tel');
 if($request->hasFile('user_image')){
 $user->user_image = $fileNameToStore;
 }
 $user->save();   
 
 return redirect('/currentUser')->with('success', 'Jouw profiel is aangepast');
}

//confirm inloggen voor data veranderen
public function showConfirm(){
    return view('confirmUserData');
}
//check of login goed is
public function changeUserData(){
    return view('editUser');
}
}
