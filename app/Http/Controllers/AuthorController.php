<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\AuthorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AuthorController extends Controller
{
    public function index(){
        $authors = Author::latest()->paginate(10);
        return view('admin.author.index', compact('authors'));
    }
    public function create(Request $request){
        return view('admin.author.create');

    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Create author
        $author = new Author();
        $author->name = $validatedData['name'];
        $author->description = $request->description;
        $author->status = $validatedData['status'];
        $author->created_by = Auth::user()->name;
        $author->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate unique image name
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

            // Save image to the author folder
            $image->move(public_path('authorImage/' . $author->id), $imageName);

            // Create a new record in the author_image table
            $authorImage = new AuthorImage(); // Remove unnecessary parentheses
            $authorImage->author_id = $author->id;
            $authorImage->image = $imageName;
            $authorImage->save();
        }

        return redirect()->route('authors.index')->with('success', 'Author created successfully');
    }
    public function edit($id){
        $author = Author::find($id);
        return view('admin.author.edit', compact('author'));
    }
    public function deleteImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $image = AuthorImage::find($imageId);

        if ($image) {
            $authorId = $image->author_id;
            $imagePath = public_path('authorImage/' . $authorId . '/' . $image->image);

            // Delete the image file
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Check if the author-id folder is empty, and if so, delete it
            $authorFolderPath = public_path('authorImage/' . $authorId);
            if (File::isDirectory($authorFolderPath) && File::allFiles($authorFolderPath) === []) {
                File::deleteDirectory($authorFolderPath);
            }

            // Delete the image record from the database
            $image->delete();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $author = Author::find($id);
        $author->name = $validatedData['name'];
        $author->description = $request->description;
        $author->status = $validatedData['status'];
        $author->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate unique image name
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

            // Save image to the author folder
            $image->move(public_path('authorImage/' . $author->id), $imageName);

            // Create a new record in the author_image table
            $authorImage = new AuthorImage(); // Remove unnecessary parentheses
            $authorImage->author_id = $author->id;
            $authorImage->image = $imageName;
            $authorImage->save();
        }

        return redirect()->route('authors.index')->with('success', 'Author updated successfully');
    }
    public function destroy($id, Request $request) {
        $author = Author::find($id);
        if(empty($author)){
            $request->session()->flash('error', 'Author Not found.');
            return redirect()->route('authors.index');
        }
        $authorImage = AuthorImage::where('author_id', $id)->first(); // Using first() instead of get()
        if ($authorImage) {
            // Delete the image file
            $imagePath = public_path('authorImage/' . $author->id . '/'. $authorImage->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the author image record
            $authorImage->delete();
        }
        // Delete the folder associated with the author's ID
        $folderPath = public_path('authorImage/' . $author->id);
        if (file_exists($folderPath)) {
            // Remove the directory along with its contents
            rmdir($folderPath);
        }
        // Delete the author record
        $author->delete();
        $request->session()->flash('success', 'Author deleted successfully.');
        return redirect()->route('authors.index');
    }
}
