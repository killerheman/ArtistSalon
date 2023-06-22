<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Gallery::all();
        return view('admin.gallery', compact('events'));
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
            'file' => 'required'
        ]);
        if ($request->hasFile('file')) {
            $filepath = 'upload/Gallery/';
            foreach ($request->file('file') as $file) {
                $name = 'gallery' . '-' . time() . '-' . rand(0, 99) . '.' . $file->extension();
                $file->move(public_path($filepath), $name);
                $eventpic = $filepath . $name;

                $data = Gallery::create([
                    'image' => $eventpic
                ]);
            }
            if ($data) {
                return redirect()->back()->with('success', 'Photos added to event successfully.');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            return redirect()->back()->with('error', 'Please upload correct file');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        try {
            $res = Gallery::find($id)->delete();
            if ($res) {
                session()->flash('success', 'Photos deleted sucessfully');
            } else {
                session()->flash('error', 'Photo not deleted ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }
}
