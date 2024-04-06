<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest('created_at')->paginate(10);
        return view('admin.page.index',compact('pages'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        // Perform the search query
        $pages = Page::where('name', 'like', '%' . $keyword . '%')
        ->orWhere('slug', 'like', '%' . $keyword . '%')
        ->orWhere('contents', 'like', '%' . $keyword . '%')
            ->paginate(10);

        // Pass the search results to your view
        return view('admin.page.index', ['pages' => $pages]);
    }



    public function create()
    {
        return view('admin.page.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:pages,slug',
            'contents' => 'required',
            'status' => 'required',
        ]);

        if($validate){
            $page = new Page();
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->contents = $request->contents;
            $page->status = $request->status;
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page created successfully.');
        } else {
            return redirect()->back()->with('error', 'Validation failed.');
        }
    }

    public function edit(Request $request,$slug)
    {
        $page = Page::where('slug', $slug)->first();
        if(empty($page)){
            $request->session()->flash('error','Page Not Found');
            return redirect()->route('pages.index');
        }
        return view('admin.page.edit',compact('page'));
    }

    public function update(Request $request,$id){
        $page = Page::find($id);
        if(empty($page)){
            $request->session()->flash('error','Page Not Found');
            return redirect()->route('categories.index');
        }
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,' . $id.',id',
            'contents' => 'required',
            'status' => 'required',
        ]);
        if($validate){
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->contents = $request->contents;
            $page->status = $request->status;
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
        }
        return view('admin.page.edit',compact('page'));

    }
    public function destroy(Request $request,$id){
        $page = Page::find($id);
        if(empty($page)){
            $request->session()->flash('error','Page Not Found');
            return redirect()->route('pages.index');
        }
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
