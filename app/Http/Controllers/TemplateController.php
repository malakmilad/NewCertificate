<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Models\Font;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::get();
        return view('admin.template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fonts = Font::get();
        return view('admin.template.create', compact('fonts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTemplateRequest $request)
    {
        $template_name = $request->template_name;
        if ($request->file('template_image')) {
            $image = $request->file('template_image');
            $extension = $image->getClientOriginalExtension();
            $newFilename = $template_name . '.' . $extension;
            $image->move(public_path('templates'), $newFilename);
            $templateImagePath = public_path('templates') . '/' . $newFilename;
        }
        $width = $request->width;
        $height = $request->height;

        $student_content = $request->student_content;
        $student_color = $request->student_color;
        $student_font_size = $request->student_font_size;
        $student_font_family = $request->student_font_family;
        $student_x = $request->student_x;
        $student_y = $request->student_y;

        $course_content = $request->course_content;
        $course_color = $request->course_color;
        $course_font_size = $request->course_font_size;
        $course_font_family = $request->course_font_family;
        $course_x = $request->course_x;
        $course_y = $request->course_y;

        $date_content = $request->date_content;
        $date_color = $request->date_color;
        $date_font_size = $request->date_font_size;
        $date_font_family = $request->date_font_family;
        $date_x = $request->date_x;
        $date_y = $request->date_y;

        $qr_content = $request->qr_content;
        $qr_x = $request->qr_x;
        $qr_y = $request->qr_y;

        $student_percent_x = ($student_x / $width) * 100;
        $student_percent_y = ($student_y / $height) * 100;

        $course_percent_x = ($course_x / $width) * 100;
        $course_percent_y = ($course_y / $height) * 100;

        $date_percent_x = ($date_x / $width) * 100;
        $date_percent_y = ($date_y / $height) * 100;

        $qr_percent_x = ($qr_x / $width) * 100;
        $qr_percent_y = ($qr_y / $height) * 100;

        $options = [
            'student' => [
                'content' => $student_content,
                'color' => $student_color,
                'font_size' =>$student_font_size,
                'font_family' => $student_font_family,
                'position_pixel_x' => $student_x,
                'position_pixel_y' => $student_y,
                'position_percent_x' => $student_percent_x,
                'position_percent_y' => $student_percent_y,
            ],
            'course' => [
                'content' => $course_content,
                'color' => $course_color,
                'font_size' =>$course_font_size,
                'font_family' => $course_font_family,
                'position_pixel_x' => $course_x,
                'position_pixel_y' => $course_y,
                'position_percent_x' => $course_percent_x,
                'position_percent_y' => $course_percent_y,
            ],
            'date' => [
                    'content' => $date_content,
                    'color' => $date_color,
                    'font_size' => $date_font_size,
                    'font_family' => $date_font_family,
                    'position_pixel_x' =>$date_x,
                    'position_pixel_y' => $date_y,
                    'position_percent_x' => $date_percent_x,
                    'position_percent_y' => $date_percent_y,
            ],
            'qr_code' => [
                'content' => $qr_content,
                'position_pixel_x' => $qr_x,
                'position_pixel_y' => $qr_y,
                'position_percent_x' => $qr_percent_x,
                'position_percent_y' => $qr_percent_y,
            ]
        ];
        $data = [
            'name' => $template_name,
            'image' => $templateImagePath,
            'options' => $options,
        ];
        Template::create($data);

        toastr()->success('Data has been saved successfully!');
        return redirect()->route('template.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        //
    }
}
