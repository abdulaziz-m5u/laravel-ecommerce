<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\SlideRequest;

class SlideController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = Slide::latest()->paginate(5);

        return view('admin.slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $image = NULL;
        if ($request->hasFile('cover')) {
            $image = $this->uploadImage($request->title, $request->cover, 'slides', 500, 500);
        }

        Slide::create([
            'title' => $request->title,
            'url' => $request->url,
            'body' => $request->body,
            'cover' => $image,
            'position' => Slide::max('position') + 1
        ]);

        return redirect()->route('admin.slides.index')->with([
            'message' => 'success created !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        return view('admin.slides.show', compact('slide'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Slide $slide)
    {
        $image = $slide->cover;
        if ($request->has('cover')) {
            if ($slide->cover != null && File::exists('storage/images/slides/'. $slide->cover)) {
                unlink('storage/images/slides/'. $slide->cover);
            }
            $image = $this->uploadImage($request->title, $request->cover, 'slides', 450, 450);
        }

        $slide->update([
            'title' => $request->title,
            'url' => $request->url,
            'body' => $request->body,
            'cover' => $image,
        ]);

        return redirect()->route('admin.slides.index')->with([
            'message' => 'success updated !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        if ($slide->cover) {
            if (File::exists('storage/images/slides/'. $slide->cover)) {
                unlink('storage/images/slides/'. $slide->cover);
            }
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')->with([
            'message' => 'success deleted !',
            'alert-type' => 'danger'
        ]);        
    }

    public function moveUp($slideId){
        $slide = Slide::findOrFail($slideId);

		if (!$slide->prevSlide()) {
			return redirect()->route('admin.slides.index');
		}

		\DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$prevPosition = $slide->prevSlide()->position;

				$prevSlide = Slide::find($slide->prevSlide()->id);
				$prevSlide->position = $currentPosition;
				$prevSlide->save();

				$slide->position = $prevPosition;
				$slide->save();
			}
		);

		return redirect()->route('admin.slides.index');
    }   

    public function moveDown($slideId){
        $slide = Slide::findOrFail($slideId);

		if (!$slide->nextSlide()) {
			return redirect()->route('admin.slides.index');
		}

		\DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$prevPosition = $slide->nextSlide()->position;

				$prevSlide = Slide::find($slide->nextSlide()->id);
				$prevSlide->position = $currentPosition;
				$prevSlide->save();

				$slide->position = $prevPosition;
				$slide->save();
			}
		);

		return redirect()->route('admin.slides.index');
    }   
}
