<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $highlights = Highlight::latest()->paginate(10);
        return view('admin.highlight.index', compact('highlights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->where('status', 1);
        return view('admin.highlight.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'nullable',
            'description' => 'required',
            'is_active' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Create highlight
        $highlight = new Highlight();
        $highlight->name = $validatedData['name'];
        $highlight->slug = $validatedData['slug'];
        $highlight->category_id = $validatedData['category_id'];
        $highlight->description = $validatedData['description'];
        $highlight->is_active = $validatedData['is_active'];

        // Check if image file is present in the request
        if ($request->hasFile('image')) {
            // Get the file
            $image = $request->file('image');

            // Generate a unique name for the image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('highlightImage');

            // Move the uploaded file to the storage path with the generated name
            $image->move($storagePath, $imageName);

            // Assign the image name to the validated data
           $highlight->image = $imageName;
        }

        // Save highlight
        $highlight->save();

        // Redirect with success message
        return redirect()->route('highlights.index')->with('success', 'Highlight created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $highlight = Highlight::find($id);
        $categories = Category::all()->where('status', 1);
        if(!$highlight){
            return redirect()->route('highlights.index')->with('error', 'Highlight not found');
        }
        return view('admin.highlight.edit', compact('highlight','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the highlight to update
        $highlight = Highlight::findOrFail($id);
        if(!$highlight){
            return redirect()->route('highlights.index')->with('error', 'Highlight not found');
        }
        // Validation
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'category_id' => 'nullable',
            'is_active' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);


        // Update highlight attributes
        $highlight->name = $validatedData['name'];
        $highlight->slug = $validatedData['slug'];
        $highlight->category_id = $validatedData['category_id'];
        $highlight->description = $validatedData['description'];
        $highlight->is_active = $validatedData['is_active'];

        // Check if image file is present in the request
        if ($request->hasFile('image')) {
            // Get the file
            $image = $request->file('image');

            // Generate a unique name for the new image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('highlightImage');

            // Move the uploaded file to the storage path with the generated name
            $image->move($storagePath, $imageName);

            // Delete the older image file if it exists
            if ($highlight->image != null) {
                $oldImagePath = $storagePath . '/' . $highlight->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Assign the new image name to the validated data
           $highlight->image = $imageName;
        }

        // Save changes
        $highlight->update();

        // Redirect with success message
        return redirect()->route('highlights.index')->with('success', 'Highlight updated successfully');


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the service by id or throw a ModelNotFoundException
        $highlight = Highlight::findOrFail($id);
        if($highlight){
            // Define the storage path
            $storagePath = public_path('highlightImage');

            // Delete the image file if it exists
            if ($highlight->image != null) {
                $imagePath = $storagePath . '/' . $highlight->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the service
            $highlight->delete();

            // Redirect with success message
            return redirect()->route('highlights.index')->with('success', 'Highlight deleted successfully');
        }
        else{
            // Redirect with success message
            return redirect()->route('highlights.index')->with('success', 'Error deleting Highlight');
        }


    }

    public function deleteImage(Request $request)
    {
        // Get the image id from the request
        $imageName = $request->image;
        // Find the highlight record with the specified image name
        $highlight = Highlight::where('image', $imageName)->first();

        if ($highlight) {
            // Delete the image file from the public folder
            $imagePath = public_path('highlightImage/' . $highlight->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Update the highlight entry to set the image attribute to null
            $highlight->update(['image' => null]);
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }else {
            return response()->json(['error' => false, 'message' => 'Image not found.'], 404);
        }


    }
}
