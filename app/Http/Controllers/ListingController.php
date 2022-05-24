<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index',['listings' => Listing::latest()
            ->Filter(request(['tag','search']))->paginate(5)
        ]);
    }

    public function show(Listing $listing){
        return view('listings.show',['listing' => $listing]);
    }

    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){

        $formFields    = $request->validate([
            'title'    => 'required',
            'company'  => 'required|unique:listings',
            'location' => 'required',
            'website'  => 'required',
            'email'    => 'required|email',
            'tags'     => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
            $formFields['logo'] = $request->file('logo')->store('logos','public');

        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/')->with('message','Listing Created Successfully..!');
    }

    public function edit(Listing $listing){
        return view('listings.edit',['listing' => $listing]);
    }

    public function update(Listing $listing, Request $request){
        if($listing->user_id != auth()->id())
            abort(403, 'Unauthorized Action');

        $formFields    = $request->validate([
            'title'    => 'required',
            'company'  => 'required',
            'location' => 'required',
            'website'  => 'required',
            'email'    => 'required|email',
            'tags'     => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
            $formFields['logo'] = $request->file('logo')->store('logos','public');

        $listing->update($formFields);
        return back()->with('message','Listing Updated Successfully..!');
    }

    public function destroy(Listing $listing){
        if($listing->user_id != auth()->id())
            abort(403, 'Unauthorized Action');
        $listing->delete();
        return redirect('/')->with('message','Listing Deleted Successfully..!');
    }

    public function manage(){
        return view('listings.manage',['listings' => auth()->user()->listings()->get()]);
    }
}












