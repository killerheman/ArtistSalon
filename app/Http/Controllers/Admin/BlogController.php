<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blog', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'pic' => 'nullable|image'
        ]);
        try {
            $pic_name = '';
            if ($request->hasFile('pic')) {
                $upic = 'blog-' . time() . '-' . rand(0, 99) . '.' . $request->pic->extension();
                $request->pic->move(public_path('upload/blog/'), $upic);
                $pic_name = 'upload/blog/' . $upic;
            }
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'image' => $pic_name
            ];
            $blog = Blog::create($data);

            if ($blog) {

                Session::flash('success', 'Blog registered successfully');
            } else {
                Session::flash('error', 'Blog not registered');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
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
        $id = Crypt::decrypt($id);
        $udata = Blog::find($id);
        $blogs = Blog::all();
        return view('admin.blog', compact('blogs', 'udata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'pic' => 'nullable|image'
        ]);
        try {
            if ($request->hasFile('pic')) {
                $upic = 'blog-' . time() . '-' . rand(0, 99) . '.' . $request->pic->extension();
                $request->pic->move(public_path('upload/blog/'), $upic);
                $pic_name = 'upload/blog/' . $upic;
                $blog = Blog::find($id)->update([
                    'image' => $pic_name
                ]);
            }
            $blog = Blog::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            if ($blog) {

                Session::flash('success', 'Blog Updated successfully');
            } else {
                Session::flash('error', 'Blog not Update');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        try {
            $res = Blog::find($id)->delete();
            if ($res) {
                session()->flash('success', 'Blog deleted sucessfully');
            } else {
                session()->flash('error', 'Blog not deleted ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }
}
