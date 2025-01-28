<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFontRequest;
use App\Models\Font;
use RealRashid\SweetAlert\Facades\Alert;
use Vinkla\Hashids\Facades\Hashids;

class FontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fonts=Font::get();
        return view('admin.font.index',compact('fonts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.font.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFontRequest $request)
    {
        if ($request->file('font_file')) {
            $file = $request->file('font_file');
            $fontName = $file->getClientOriginalName();
            $fontNameWithoutExtension = pathinfo($fontName, PATHINFO_FILENAME);
            $whiteSpace = preg_replace('/(?<=\p{L})(?=\p{N})|(?<=\p{N})(?=\p{L})/', ' ', $fontNameWithoutExtension);

            // Move file to the fonts directory
            $file->move(public_path('fonts'), $fontName);

            // Save font details to the database
            Font::create([
                'name' => $whiteSpace,
                'path' => 'fonts/' . $fontName,
            ]);

            Alert::success('Success', 'Font created successfully!');
            return redirect()->route('font.index');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hash = Hashids::decode($id);
        $font=Font::findOrFail($hash[0]);
        if($font->path){
            $path = public_path($font->path);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $font->delete();
        Alert::success('Success', 'Font has been deleted successfully!');
        return redirect()->route('font.index');
    }
}
