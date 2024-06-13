<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Models\Font;
use App\Models\Template;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

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
            $image->move('templates', $newFilename);
            $templateImagePath = 'templates/' . $newFilename;
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

        $countText=$request->countText;

        $options = [
            'countText'=>$countText,
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
        $texts = [];
        for($i = 0; $i <= $countText; $i++){
            $text_content=$request["text".$i."_content"];
            $text_color=$request["text".$i."_color"];
            $text_font_family=$request["text".$i."_font_family"];
            $text_font_size=$request["text".$i."_font_size"];
            $text_x=$request["text".$i."_x"];
            $text_y=$request["text".$i."_y"];
            $text_percent_x=($text_x/$width)*100;
            $text_percent_y=($text_y/$height)*100;
            $texts[]=[
                'content' => $text_content,
                'color' => $text_color,
                'font_family' => $text_font_family,
                'font_size' => $text_font_size,
                'position_pixel_x' => $text_x,
                'position_pixel_y' => $text_y,
                'position_percent_x' => $text_percent_x,
                'position_percent_y' => $text_percent_y,
            ];
        }
        $options['texts'] = $texts;
        $data = [
            'name' => $template_name,
            'image' => $templateImagePath,
            'options' => $options,
        ];
        Template::create($data);

        toastr()->success('Template has been saved successfully!');
        return redirect()->route('template.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hash = Hashids::decode($id);
        $template=Template::findOrFail($hash[0]);
        return view('admin.template.show',compact('template'));
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
    public function destroy($id)
    {
        $hash = Hashids::decode($id);
        $template=Template::findOrFail($hash[0]);
        if($template->template_imag){
            $path = public_path($template->template_image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $template->delete();
        toastr()->success('Template has been deleted successfully!');
        return redirect()->route('font.index');
    }
}
