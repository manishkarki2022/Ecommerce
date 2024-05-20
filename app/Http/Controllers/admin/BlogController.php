<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'name' => 'required|string',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if image file is present in the request
        if ($request->hasFile('image')) {
            // Get the file
            $image = $request->file('image');

            // Generate a unique name for the image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('blogs');

            // Move the uploaded file to the storage path with the generated name
            $image->move($storagePath, $imageName);

            // Assign the image name to the validated data
            $validatedData['image'] = $imageName;
        }

        // Now you can proceed to store the validated data into your database
        // For example, assuming you have a Service model:

        $blog = new Blog($validatedData);
        $user = Auth::user();
        $blog->created_by = $user->name;
        $blog->save();
        // Retrieve the blog name for the success message
        $blogName = $validatedData['name'];

        // Optionally, you can return a response indicating success or redirect somewhere
        return redirect()->route('blogs.index')->with('success', "Blog '{$blogName}' created successfully");
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            return view('admin.blog.edit', compact('blog',));
        }
        // Fetch Related Blogs
        return redirect()->route('blogs.index')->with('error', 'Blog not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        // Validation rules
        $validatedData = $request->validate([
            'name' => 'required|string',
            'excerpt' => 'nullable|string',
            'content' => 'nullable',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the blog by slug or throw a ModelNotFoundException
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Check if image file is present in the request
        if ($request->hasFile('image')) {
            // Get the file
            $image = $request->file('image');

            // Generate a unique name for the new image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Define the storage path
            $storagePath = public_path('blogs');

            // Move the uploaded file to the storage path with the generated name
            $image->move($storagePath, $imageName);

            // Delete the older image file if it exists
            if ($blog->image != null) {
                $oldImagePath = $storagePath . '/' . $blog->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Assign the new image name to the validated data
            $validatedData['image'] = $imageName;
        }
        // Update the Blog with the validated data
        $blog->update($validatedData);
        $blogName = $validatedData['name'];
        return redirect()->route('blogs.index')->with('success', "Blog '{$blogName}' updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the blog by id or throw a ModelNotFoundException
        $blog = Blog::findOrFail($id);
        if($blog){
            // Define the storage path
            $storagePath = public_path('blogs');

            // Delete the image file if it exists
            if ($blog->image != null) {
                $imagePath = $storagePath . '/' . $blog->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $blogName = $blog->name;

            // Delete the blog
            $blog->delete();

            return redirect()->route('blogs.index')->with('success', "Blog '{$blogName}' deleted successfully");
        }
        else{
            return redirect()->route('blogs.index')->with('error', 'Blog not found');
        }

    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $blogs = Blog::where('name', 'like', '%' . $keyword . '%')->paginate(10);

        // Pass the search results to your view
        return view('admin.blog.index', ['blogs' => $blogs]);
    }
}
