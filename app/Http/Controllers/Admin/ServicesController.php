<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services', compact('services'));
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
            'pic' => 'required|image',
            'price' => 'required'
        ]);
        try {
            $pic_name = '';
            if ($request->hasFile('pic')) {
                $upic = 'service-' . time() . '-' . rand(0, 99) . '.' . $request->pic->extension();
                $request->pic->move(public_path('upload/service/'), $upic);
                $pic_name = 'upload/service/' . $upic;
            }
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'image' => $pic_name,
                'price' => $request->price
            ];
            $services = Service::create($data);

            if ($services) {

                Session::flash('success', 'Services registered successfully');
            } else {
                Session::flash('error', 'Services not registered');
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
        $udata = Service::find($id);
        $services = Service::all();
        return view('admin.services', compact('services', 'udata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'pic' => 'nullable|image',
            'price' => 'required'
        ]);
        try {
            if ($request->hasFile('pic')) {
                $upic = 'service-' . time() . '-' . rand(0, 99) . '.' . $request->pic->extension();
                $request->pic->move(public_path('upload/service/'), $upic);
                $pic_name = 'upload/service/' . $upic;
                $services = Service::find($id)->update([
                    'image' => $pic_name
                ]);
            }
            $services = Service::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price
            ]);
            if ($services) {

                Session::flash('success', 'Services Updated successfully');
            } else {
                Session::flash('error', 'Services not Update');
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
            $res = Service::find($id)->delete();
            if ($res) {
                session()->flash('success', 'Services deleted sucessfully');
            } else {
                session()->flash('error', 'Services not deleted ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }
}
