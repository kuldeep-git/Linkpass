<?php

namespace App\Http\Controllers\admin\admin;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\ContentStepMedia;
use App\Selfdiagnosis;
use App\ContentCategory;
use Response;
use Hash;
use Auth;
use Storage;

class SelfDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $content = Selfdiagnosis::with('content_category','content_category.category')->orderBy('created_at', 'desc')->paginate(6);
        // Selfdiagnosis::with('content_category','content_category.category')

        if($request->ajax()){
            return view('admin.content.ajaxlist',array('content'=>$content));
        }else{
            $categorys = Category::all();
            //print_r($categorys);
            return view('admin.content.list',array('title' => 'Content List','categorys'=>$categorys,'content'=>$content));
        }
    }

    public function search(Request $request){

        $content=Selfdiagnosis::with('content_category','content_category.category')
            ->orderBy('created_at', 'desc');
        if(isset($request->search) && !empty($request->search)){
            $content=$content->where('main_title','LIKE','%'.$request->search."%");
        }
        if(isset($request->category_id) && !empty($request->category_id)){
            $category_id=$request->category_id;
            $content=$content->whereHas('content_category', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
        }
        $content=$content->paginate(6);

        return view('admin.content.ajaxlist',array('content'=>$content));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status','1')->get();
        return view('admin.content.add',array('title' => 'Content Add','category'=>$category));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "<pre>";print_r($request->stepfilupload);exit;

        $messages = [
            'content_step.*.step_title.required' => 'The title field is required.',
            'content_step.*.step_description.required' => 'The points/description field is required.',
            //'content_step.*.stepfilupload.*' => 'Please upload jpg,jpeg,png,bmp image',
        ];
        $request->validate([
            'content_step.*.step_title' => 'required',
            'content_step.*.step_description' => 'required',
            //'content_step.*.stepfilupload.*' => 'mimes:jpg,jpeg,png,bmp'
        ],$messages);

        try {
            return redirect(route('organization.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('organization.list'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        //
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
            $imageName = $request->unique_id;
            $imgext =$file->getClientOriginalExtension();
            $path = 'content/step_media/'.$imageName.".".$imgext;
            $fileAdded = Storage::disk('public')->putFileAs('content/step_media/',$file,$imageName.".".$imgext);

            if($fileAdded){
                $guidMediaArr = array();
                $guidMediaArr['step_key'] = $request->unique_id;
                $guidMediaArr['media'] =  $path;
                $media = ContentStepMedia::create($guidMediaArr);
                return Response::json(['status' => true, 'message' => 'Media uploaded.', 'id' => $media->id]);
            }
            return Response::json(['status' => false, 'message' => 'Something went wrong.']);
        }

        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    public function mainImgUpload(Request $request)
    {
        dd($request->all());
        if($request->unique_id && $request->file('file_image')){
            $file=$request->file('file_image');

            $request->validate([
                'file_image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $file_name =$file->getClientOriginalName();
            $fileslug= pathinfo($file_name, PATHINFO_FILENAME);
            $imageName = $request->unique_id;
            $imgext =$file->getClientOriginalExtension();
            $path = 'content/step_media/'.$imageName.".".$imgext;
            $fileAdded = Storage::disk('public')->putFileAs('content/step_media/',$file,$imageName.".".$imgext);

            if($fileAdded){
                $guidMediaArr = array();
                $guidMediaArr['step_key'] = $request->unique_id;
                $guidMediaArr['media'] =  $path;
                $media = ContentStepMedia::create($guidMediaArr);
                return Response::json(['status' => true, 'message' => 'Media uploaded.', 'id' => $media->id]);
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Selfdiagnosis $content, Request $request)
    {
        echo "<pre>";print_r($content);exit();
        try {
            if(!$content){
                return abort(404) ;
            }
            $content->status = '3';
            if ($content->save()) {
            }
            return redirect(route('admin.content.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.content.list'));
        }
    }
}
