<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use\App\User;
use\App\Adver;


class currentUserController extends Controller
{
   public function index(){
    $user = User::find(auth()->user()->id);
    return view('currentUser')->with('user', $user)->with('advers', $user->adver);
   }
   
   public function show(){
    $advers = Adver::where('user_id', auth()->user()->id)->paginate(12);
    $user = DB::table('users')->where('id', auth()->user()->id)->first();
   
    return view('myAdver')->with('advers', $advers)->with('user', $user);
   }

   public function edit($id){
       $advers = Adver::find($id);
       $categories = DB::table('categories')->get();
       return view('editAdver')->with('advers', $advers)->with('categories', $categories);
   }

   //update zoekertje
   public function update(Request $request, $id){
       //Validate??
       $this->validate($request, [
        'title' => 'required',
        'discription' => 'required',
        'category' => 'required',
        'condition' => 'required',
        'image.*' => 'image|nullable|max:2048',
        'priceclass' => 'required',
        'price' => 'string|nullable',
        'tel' => 'required',
        'location' => 'required'
    ]);

if(empty($request->file('image'))){
    
} else {
    if(count($request->file('image')) > 5){
        return redirect('/adver')->with('error', "Maximum 5 foto's zijn toegelaten!");
    } else {
        if ($image = $request->file('image')) {
            foreach ($image as $files) {
            $destinationPath = 'storage/images'; // upload path
            $adverImage = pathinfo($files, PATHINFO_FILENAME) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $adverImage);
            $insert[]['image'] = "$adverImage";
            }
        }
    }
}
   //adver aanmaken
   $adver = Adver::find($id);
   $adver->title = $request->input('title');
   $adver->discription = $request->input('discription');
   $adver->condition = $request->input('condition');
   if ($image = $request->file('image')) { 
        $adver->images = json_encode($insert);
   }
   $adver->priceclass = $request->input('priceclass');
   $adver->price = $request->input('price');
   $adver->tel = $request->input('tel');
   $adver->location = $request->input('location');
   $adver->user_id = auth()->user()->id;
   $adver->category_id = $request->input('category');
   $adver->save(); 
    
    return redirect('/currentUser/myAdver')->with('success', 'Uw advertentie is aangepast');
   }

//    verwijder zoekertje
   public function destroy($id){
       $adver = Adver::find($id);
       $adver->delete();
       return redirect('/currentUser/myAdver')->with('success', 'Uw advertentie is verwijderd');
   }

   //password veranderen
   public function showFormReset(){
    return view('auth.resetpassword');
   }

   public function changePassword(Request $request){

    if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
        return redirect()->back()->with("error","Huidig ingegeven wachtwoord komt niet overeen met jouw wachtwoord.");
    }

    if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
        return redirect()->back()->with("error","Nieuwe wachtwoord mag niet hetzelfde zijn als je huidig wachtwoord, kies een ander nieuw wachtwoord.");
    }

    $validatedData = $request->validate([
        'current-password' => 'required',
        'new-password' => 'required|string|min:6|confirmed',
    ]);

    //Change Password
    $user = Auth::user();
    $user->password = bcrypt($request->get('new-password'));
    $user->save();

    return redirect()->back()->with("success","Je nieuw wachtwoord is aangemaakt!");
}
}
