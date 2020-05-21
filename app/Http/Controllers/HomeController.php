<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adver;
use App\User;
use App\Review;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Mail\AdverMail;
use App\Mail\ReviewMail;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        //categories
        $categories = DB::table('categories')->get();
        //advertenties
        $advers = DB::table('advers')->orderBy('created_at', 'desc')->paginate(12);

        return view('/home')->with('advers', $advers)->with('categories', $categories);
    }

    public function searchInput(Request $request)
    {
        $Advers = Adver::get();

        //input
        $zoekopdracht = $request->input('zoekopdracht');
        $regio = $request->input('regio');
        $afstand = $request->input('afstand');
        $category = $request->input('category');
        //categories
        $categories = DB::table('categories')->get();

        //////////////////////////////////////////////////////////////////////
        ///////////////////curl api google places/////////////////////////////

        //result array, hier worden de data in gepushed
        $result = array();

        foreach ($Advers as $Adver) {

            $test = str_replace(" ", "+", $Adver->location);
            $regio = str_replace(" ", "+", $regio);

            // create & initialize a curl session
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . $regio .
                "&destinations=" . $test . "&key=AIzaSyDkZ4PP_qS1NDJ9Lcyv7SYf9kLhaIn_DD0";
            $curl = curl_init();

            // set our url with curl_setopt()
            curl_setopt($curl, CURLOPT_URL, $url);

            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // curl_exec() executes the started curl session
            // $x contains the output string

            $x = json_decode(curl_exec($curl));
            array_push($result, $x);

            ob_flush();

            // close curl resource to free up system resources
            // (deletes the variable made by curl_init)
            curl_close($curl);
        }
        ob_end_flush();

        //////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////

        //hieronder worden de locaties gefilterd binnen de gekozen max afstand van de input
        $juisteLocaties = array();
        if ($regio == "") {
            //doe gewoon de query zonder afstanden
        } else {
            for ($i = 0; $i < count($result); $i++) {
                //checken welke afstanden binnen de gekozen afstand zit, die dan in de $juisteLocaties arrray pushen
                if ($result[$i]->rows[0]->elements[0]->distance->value <= $afstand) {
                    $minPostcode = substr($result[$i]->destination_addresses[0], 4);
                    $locaties = substr($minPostcode, 0, -9);
                    array_push($juisteLocaties, $locaties);
                }
            }
        }

        //advertenties ophalen db adhv input
        $advers = DB::table('advers')
            ->where('title', 'LIKE', "%{$zoekopdracht}%")
            ->where('category_id', 'LIKE', "%{$category}%")
            ->where(function ($query) use ($juisteLocaties) {
                for ($i = 0; $i < count($juisteLocaties); $i++) {
                    $query->orWhere('location', 'LIKE', '%' . trim($juisteLocaties[$i]) . '%');
                }
            })
            ->paginate(12);

        return view('home')->with('advers', $advers)
            ->with('categories', $categories)
            ->with('regio', $regio)
            ->with('afstand', $afstand);
    }

    public function searchCat($catId)
    {
        $advers = Adver::where('category_id', $catId)->paginate(12);
        //categories
        $categories =  Category::get();

        return view('home')->with('advers', $advers)->with('categories', $categories);
    }

    public function showAdverUser($adverId)
    {
        //huidige advertentie
        $adver = Adver::find($adverId);
        $images = json_decode($adver->images);

        // dd($images);

        return view('adverUser')
            ->with('adver', $adver)
            ->with('images', $images);
    }

    public function showSendMail($adverId)
    {
        //huidige advertentie
        $adver = Adver::where('id', $adverId)->first();
        // user gegevens van de geintresseerde
        $user = DB::table('users')->where('id', auth()->user()->id)->first();

        return view('sendMail')
            ->with('adverId', $adverId)
            ->with('adver', $adver)
            ->with('user', $user);
    }

    public function sendMailToAdverUser(Request $request, $adverId)
    {
        //huidige advertentie
        $adver = Adver::where('id', $adverId)->first();
        //bericht
        $message = $request->input('message');
        //mail versturen naar eigenaar advertentie, values meegeven
        Mail::to($adver->user->email)->send(new AdverMail($adver, $message));

        return redirect()->route('showAdverUser', $adverId)->with('success', 'Bericht verstuurd!');
    }

    public function showUserAdver($user_id)
    {
        $adverUser = User::where('id', $user_id)->first();

        return view('currentUser')->with('user', $adverUser);
    }

    public function showAdverGuest($userId)
    {
        // Advertenties van deze gebruiker laten zien voor gast
        $advers = Adver::where('user_id', $userId)->paginate(12);
        $user = DB::table('users')->where('id', $userId)->first();

        return view('myAdver')->with('advers', $advers)->with('user', $user);
    }


    public function review(Request $request, $user_id, $guest_id)
    {

        $this->validate($request, [
            'review' => 'required',
        ]);

        $toMail = $request->input('review');
        $addReview = new Review;
        $addReview->review = $request->input('review');
        $addReview->author_id = $guest_id;
        $addReview->user_id = $user_id;
        $addReview->save();

        // data meegeven
        $user = User::where('id', $user_id)->first();
        //mail versturen naar gebruiker
        Mail::to($user->email)->send(new ReviewMail($toMail, $guest_id));

        return back()->with('user', $user);
    }

    public function reviewDestroy($review_id)
    {
        Review::find($review_id)->delete();

        return back()->with('success', 'Beoordeling verwijderd!');
    }
}
