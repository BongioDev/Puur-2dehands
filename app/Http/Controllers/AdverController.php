<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adver;
use App\Category;

class AdverController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //categories
        $categories = Category::get();
        return view('adver')->with('categories', $categories);
    }

    public function store(Request $request)
    {
//Validate
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

// oude systeem 1 foto uploaden
//         if($request->hasFile('images')){
//             //met extension
//             $fileNameWithExtension = $request->file('images')->getClientOriginalName();
//             //zonder extension enkel naam
//             $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
//             //enkel extension
//             $extension = $request->file('images')->getClientOriginalExtension();
//             //naam die word opgeslagen
//             $fileNameToStore = $fileName.'_'.time().'.'.$extension;
//             //opslaan
//             $path = $request->file('images')->storeAs('public/images', $fileNameToStore);
//         } else {
//             $fileNameToStore = 'geenfoto.jpg';
//         }

if(empty($request->file('image'))){
    $insert[]['image'] = 'noadverimage.jpg';
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

// opslaan in oude images table
// images aanmaken
    //    $image = new Image;
    //    $image->path = json_encode($insert);
        // Image::insert([
        //     'path' => json_encode($insert)
        // ]);

//adver aanmaken
        $adver = new Adver;
        $adver->title = $request->input('title');
        $adver->discription = $request->input('discription');
        $adver->condition = $request->input('condition');
        $adver->images = json_encode($insert);
        $adver->priceclass = $request->input('priceclass');
        $adver->price = $request->input('price');
        $adver->tel = $request->input('tel');
        $adver->location = $request->input('location');
        $adver->user_id = auth()->user()->id;
        $adver->category_id = $request->input('category');
        $adver->save(); 

        return redirect('/currentUser/myAdver')->with('success', 'Zoekertje aangemaakt!');
    }
}
