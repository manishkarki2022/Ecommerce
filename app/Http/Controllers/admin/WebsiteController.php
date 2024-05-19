<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WebsiteController extends Controller
{
    public function index()
    {
        $website = Website::first();
        return view('admin.website.view',compact('website'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address.*' => 'nullable|string|max:255', // Validate each address in the array
            'phone.*' => 'nullable|string|max:255',   // Validate each phone number in the array
            'email' => 'required|email|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow logo to be nullable for updates
        ]);

        $websiteData = [
            'name' => $request->name,
            'quote' => $request->quote,
            'description' => $request->description,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ];

        // Process addresses
        if ($request->has('address')) {
            $websiteData['address'] = $request->address; // Assign addresses directly
        }

        // Process phone numbers
        if ($request->has('phone')) {
            $websiteData['phone'] = $request->phone; // Assign phone numbers directly
        }

        // Check if ID exists and is valid
        if ($request->filled('id')) {
            $websiteData['id'] = $request->id;
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $name = time().'.'.$logo->getClientOriginalExtension();

            // Delete any existing logo
            $destinationPath = public_path('/logo');
            File::cleanDirectory($destinationPath);

            // Move the new logo to the folder
            $logo->move($destinationPath, $name);
            $websiteData['logo'] = $name;
        }

        // Update or create website settings
        $website = Website::updateOrCreate(['id' => $request->id], $websiteData);
        session()->flash('success', 'Website settings updated successfully');

        return redirect()->back();
    }
}
