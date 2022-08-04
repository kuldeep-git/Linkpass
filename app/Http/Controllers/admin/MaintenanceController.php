<?php

namespace App\Http\Controllers\admin;

use App\Content;
use App\Category;
use Illuminate\Http\Request;
use Storage;
use App\ContentStepMedia;
use App\ContentCategory;
use App\ContentSteps;
use Response;

class MaintenanceController extends Controller
{

    public function __construct()
    {
        $this->getrecord = '12';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $maintenance = Content::with('content_category','content_category.category')->where('content_type','=','maintenance')->where('main_title','!=','')->where('status','!=','2')->orderBy('created_at', 'desc')->paginate($this->getrecord);

        if($request->ajax()){
            return view('admin.maintenance.ajaxlist',array('maintenance'=>$maintenance));
        }else{
            $categorys = Category::where('status','1')->orderBy('name','asc')->get();

            return view('admin.maintenance.list',array('title' => 'Maintenance Content List','categorys'=>$categorys,'maintenance'=>$maintenance));
        }
    }

    public function search(Request $request){

        $maintenance=Content::with('content_category','content_category.category')->where('content_type','=','maintenance')->where('main_title','!=','')->where('status','!=','2');
        //->where('status','!=','2')
        if(isset($request->search) && !empty($request->search)){
            $maintenance=$maintenance->where('main_title','LIKE','%'.$request->search.'%');
        }
        if(isset($request->category_id) && !empty($request->category_id)){
            $category_id=$request->category_id;
            $maintenance=$maintenance->whereHas('content_category', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
        }
        $maintenance=$maintenance->orderBy('created_at', 'desc')->paginate($this->getrecord);

        return view('admin.maintenance.ajaxlist',array('maintenance'=>$maintenance));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guidArr = array();
        $guidArr['status'] = '3';
        $guidArr['content_type'] = 'maintenance';
        $content = Content::create($guidArr);

        return redirect(route('admin.maintenance.edit',['content' => $content->id ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    }

    public function img_upload(Request $request)
    {
        //dd($request->all());
        if($request->unique_id && $request->file('file_image')){
            $file=$request->file('file_image');

            $request->validate([
                'file_image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $file_name =$file->getClientOriginalName();
            $fileslug= pathinfo($file_name, PATHINFO_FILENAME);
            $imageName = md5($fileslug.time());
            $imgext =$file->getClientOriginalExtension();
            $path = 'content/'.$request->content_id.'/step_media/'.$imageName.".".$imgext;
            $fileAdded = Storage::disk('public')->putFileAs('content/'.$request->content_id.'/step_media/',$file,$imageName.".".$imgext);

            if($fileAdded){
                $getStepId = ContentSteps::where('step_key',$request->unique_id)->first();
                $guidMediaArr = array();
                $guidMediaArr['step_key'] = $request->unique_id;
                $guidMediaArr['step_id'] = ($getStepId)? $getStepId->id : NULL;
                $guidMediaArr['media'] =  $path;
                $media = ContentStepMedia::create($guidMediaArr);
                return Response::json(['status' => true, 'message' => 'Media uploaded.', 'id' => $media->id]);
            }
            return Response::json(['status' => false, 'message' => 'Something went wrong.']);
        }

        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    public function mainImgUpload(Request $request, $id)
    {
        $file = $request->file('file');
        if($file && $id){

            $request->validate([
                'file' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $file_name =$file->getClientOriginalName();
            $fileslug= pathinfo($file_name, PATHINFO_FILENAME);
            $imageName = md5($fileslug.time());
            $imgext =$file->getClientOriginalExtension();
            $path = 'content/'.$id.'/'.$imageName.".".$imgext;
            $fileAdded = Storage::disk('public')->putFileAs('content/'.$id.'/',$file,$imageName.".".$imgext);

            if($fileAdded){
                $contentData = Content::find($id);
                Storage::disk('public')->delete($contentData->main_image);
                $media = Content::where('id',$id)->update(['main_image' => $path]);
                return Response::json(['status' => true, 'message' => 'Media uploaded.']);
            }
            return Response::json(['status' => false, 'message' => 'Something went wrong.']);
        }

        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    public function removeImage(Request $request)
    {
        $media = ContentStepMedia::find($request->imageId);
        //dd($media);
        if($media){

            if(Storage::disk('public')->delete($media->media)){

               $media->delete();
               return Response::json(['status' => true, 'message' => 'Media deleted.']);
            }
            return Response::json(['status' => false, 'message' => 'Something went wrong.']);
        }
        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    public function removeStep(Request $request)
    {

        $steps = ContentSteps::where('step_key',$request->step_key)->first();

        if($steps){

            $medias = ContentStepMedia::where('step_id', $steps->id)->get();
            foreach ($medias as $media) {
                Storage::deleteDirectory($media->media);
            }
            ContentStepMedia::where('step_id', $steps->id)->delete();
            $steps->delete();
            return Response::json(['status' => true, 'message' => 'Step deleted.']);
        }
        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        return view('admin.maintenance.detail',array('title'=>'Maintenance Content Details','maintenance'=>$content));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        $category = Category::where('status','1')->get();
        $content_step = ContentSteps::where('content_id',$content->id)->with('media')->orderBy('step_no','asc')->get();
        //dd($content_step);
        $selectedCategory = ContentCategory::where('content_id',$content->id)->pluck('category_id')->toArray();
        return view('admin.maintenance.add',array('title' => 'Add Maintenance Content','category'=> $category, 'content' => $content, 'selectedCategory' => $selectedCategory, 'content_step' => $content_step));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //dd($request->all());
        if(!$content){
            abort(404);
        }

        $messages = [
            'content_step.*.step_title.required' => 'The title field is required.',
            'content_step.*.step_description.required' => 'The points/description field is required.',
            //'content_step.*.stepfilupload.*' => 'Please upload jpg,jpeg,png,bmp image',
        ];

        if($request->submit == 'Save As Draft'){

            $request->validate([
                'main_title' => 'required'
            ]);

        }else{

            $request->validate([
                'main_title' => 'required',
                'description' => 'required',
                'category' => 'required',
                'type' => 'required',
                'duration' => 'required|numeric',
                'cost' => 'required|numeric|between:0,99999999.99',

                //'content_step.*.step_title' => 'required',
                //'content_step.*.step_description' => 'required',
                //'content_step.*.stepfilupload.*' => 'mimes:jpg,jpeg,png,bmp'
            ]);
        }

        $content->main_title = $request->main_title;
        $content->description = $request->description;
        $content->type = $request->type;
        $content->duration = $request->duration;
        $content->duration_type = $request->duration_type;
        $content->difficulty = $request->difficulty;
        $content->cost = $request->cost;
        $content->tags = $request->tags;
        $content->introduction = $request->introduction;
        $content->introduction_video_type = $request->vid_link_type;
        $content->introduction_video_link = $request->vid_link_url;
        $content->status = ($request->submit == 'Save As Draft')? '3' : '1';

        if(isset($request->category) && is_array($request->category)){
            ContentCategory::where('content_id', $content->id)->whereNotIn('category_id', $request->category)->delete();
            foreach ($request->category as $key => $cate) {

                $checkCat = ContentCategory::where('content_id', $content->id)->where('category_id', $cate)->count();
                if($checkCat == 0){
                    $cateArr = array();
                    $cateArr['content_id'] = $content->id;
                    $cateArr['category_id'] = $cate;
                    ContentCategory::create($cateArr);
                }
            }
        }

        if(isset($request->content_step) && is_array($request->content_step)){

            foreach ($request->content_step as $key1 => $step) {

                $stepArr = array();
                $stepArr['title'] = $step['step_title'];

                if($step['step_video_media'] != ''){
                    $stepArr['video_type'] = $step['step_video_type'];
                    $stepArr['video_media'] = $step['step_video_media'];
                }

                $stepArr['description'] = $step['step_description'];

                $checkstep = ContentSteps::where('step_key', $step['step_key'])->where('content_id',  $content->id)->first();

                if($checkstep){

                    //$stepData = ContentSteps::where('step_key', $step['step_key'])->where('content_id',  $content->id)->update($stepArr);
                    $checkstep->update($stepArr);
                    ContentStepMedia::where('step_key',$checkstep->step_key)->update(['step_id' => $checkstep->id]);
                }else{

                    $stepArr['step_key'] = $step['step_key'];
                    $stepArr['content_id'] = $content->id;
                    //dd($stepArr);
                    $stepData = ContentSteps::create($stepArr);
                    ContentStepMedia::where('step_key',$step['step_key'])->update(['step_id' => $stepData->id]);
                }

            }
        }

        if ($content->save()) {
            $request->session()->flash('alert-success', 'Maintenance Content updated successfully.');
        }
        return redirect(route('admin.maintenance.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content, Request $request)
    {
        try {
            if(!$content){
                return abort(404) ;
            }
            $content->status = '2';
            if ($content->save()) {
                $request->session()->flash('alert-success', 'Maintenance Content deleted successfully.');
            }
            return redirect(route('admin.maintenance.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.maintenance.list'));
        }
    }
}
