<?php

namespace App\Http\Controllers\admin;

use App\Content;
use App\Category;
use App\SocialAccount;
use App\ContentTags;
use App\User;
use Response;
use Illuminate\Http\Request;
use Storage;

class ContentController extends Controller
{

    public function __construct()
    {
        $this->getrecord        = '12';
        $this->category         = new Category();
        $this->socialAccount    = new SocialAccount();
        $this->content          = new Content();
        $this->contentTags      = new ContentTags();
        $this->user             = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content = $this->content->where('main_title','!=','')->where('status','!=','2')->orderBy('created_at', 'desc')->paginate($this->getrecord);

        if($request->ajax()){
            return view('admin.content.ajaxlist',array('content'=>$content));
        }else{
            $categories = $this->category->categoryList();
            //print_r($categories);
            return view('admin.content.list',array('title' => 'Content List','categories'=>$categories,'content'=>$content));
        }
    }

    public function search(Request $request){

        $content = $this->content->where('main_title','!=','')->where('status','!=','2');
        $keyword = $request->search;

        if($keyword && !empty($keyword)){
            $content = $content->where('main_title','LIKE','%'.$keyword.'%');
            $content = $content->orWhere('description','LIKE','%'.$keyword.'%');
            $content = $content->orWhereHas('content_tags', function ($query) use ($keyword)
            {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            });
        }
        if(isset($request->category_id) && !empty($request->category_id)){
            $content=$content->where('category_id', $request->category_id);
        }
        $content = $content->orderBy('created_at', 'desc')->paginate($this->getrecord);

        return view('admin.content.ajaxlist',array('content'=>$content));
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
        $content = $this->content->create($guidArr);
        return redirect(route('admin.content.edit',['content' => $content ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return redirect(route('organization.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('organization.list'));
        }
    }

    public function mainImgUpload(Request $request, $id)
    {
        $file            = $request->file('file');
        $imageExtensions = implode(',', config('default.image_extensions'));

        if($file && $id){

            $request->validate([
                'file' => 'mimes:'.$imageExtensions.'|max:2048'
            ]);

            $file_name = $file->getClientOriginalName();
            $fileslug = pathinfo($file_name, PATHINFO_FILENAME);
            $imageName = md5($fileslug.time());
            $imgext = $file->getClientOriginalExtension();
            $path = 'content/'.$id.'/'.$imageName.".".$imgext;
            $fileAdded = Storage::disk('public')->putFileAs('content/'.$id.'/',$file,$imageName.".".$imgext);

            if($fileAdded){
                $contentData = $this->content->find($id);
                Storage::disk('public')->delete($contentData->main_image);
                $media = $this->content->where('id',$id)->update(['main_image' => $path]);
                return Response::json(['status' => true, 'message' => 'Media uploaded.']);
            }
            return Response::json(['status' => false, 'message' => 'Something went wrong.']);
        }

        return Response::json(['status' => false, 'message' => 'Something went wrong.']);
    }

    public function removeImage(Request $request)
    {
        $media = $this->contentStepMedia->find($request->imageId);
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
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        return view('admin.content.detail',array('title'=>'Content Details','content'=>$content));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        $categories     = $this->category->categoryList();
        $socialAccounts = $this->socialAccount->where('user_id', $content->user_id)->get();
        $users          = $this->user->where('user_type', '1')->get();
        $contentTags    = $this->contentTags->where('content_id', $content->id)->orderBy('name','asc')->pluck('name');
        $contentTags    = $contentTags->count() > 0 ? implode(',', $contentTags->toArray()) :  '';

        if($content->type == 2)
        {
            $videoLength = explode(':', $content->video_length);
            $content->video_length_h = isset($videoLength[0]) ? $videoLength[0] : 0;
            $content->video_length_m = isset($videoLength[1]) ? $videoLength[1] : 0;
            $content->video_length_s = isset($videoLength[2]) ? $videoLength[2] : 0;
        }

        if($content->type == 3)
        {
            $podcastLength = explode(':', $content->podcast_length);
            $content->podcast_length_h = isset($podcastLength[0]) ? $podcastLength[0] : 0;
            $content->podcast_length_m = isset($podcastLength[1]) ? $podcastLength[1] : 0;
            $content->podcast_length_s = isset($podcastLength[2]) ? $podcastLength[2] : 0;
        }

        return view('admin.content.add',array('title' => 'Add Content','categories'=> $categories, 'content' => $content, 'users' => $users, 'contentTags' => $contentTags, 'socialAccounts' => $socialAccounts));
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
        if(!$content){
            abort(404);
        }

        $messages = array();

        $request->validate([
            'main_title'        => 'required',
            'description'       => 'required',
            'category_id'       => 'required',
            'user_id'           => 'required',
            'social_account_id' => 'required',
            'posted_at'         => 'required',
        ], $messages);

        if(!empty($request->tags))
        {
            $tags = explode(',', $request->tags);

            foreach($tags as $tag)
            {
                $params      = array('content_id' => $content->id, 'name' => $tag);
                $contentTags = ContentTags::updateOrCreate($params);
            }

            ContentTags::whereNotIn('name', $tags)->delete();
        }

        $social_account_id = $request->social_account_id;

        $socialAccount = $this->socialAccount->find($social_account_id);

        if(!isset($socialAccount->id))
        {
            $socialAccount = $this->socialAccount->create(array('user_id' => $request->user_id, 'name' => $social_account_id));
        }

        $videoLength   = $request->get('type') == 2 ? ($request->video_length_h > 0 ? sprintf("%02d", $request->video_length_h).':' : '00:').($request->video_length_m > 0 ? sprintf("%02d", $request->video_length_m).':' : '00:').($request->video_length_s > 0 ? sprintf("%02d", $request->video_length_s) : '00') : '';
        $podcastLength = $request->get('type') == 3 ? ($request->podcast_length_h > 0 ? sprintf("%02d", $request->podcast_length_h).':' : '00:').($request->podcast_length_m > 0 ? sprintf("%02d", $request->podcast_length_m).':' : '00:').($request->podcast_length_s > 0 ? sprintf("%02d", $request->podcast_length_s) : '00') : '';

        $content->type                    = $request->type;
        $content->main_title              = $request->main_title;
        $content->category_id             = $request->category_id;
        $content->user_id                 = $request->user_id;
        $content->social_account_id       = $socialAccount->id;
        $content->description             = $request->description;
        $content->number_of_images        = $request->get('type') == 1 ? $request->number_of_images : 0;
        $content->video_length            = $request->get('type') == 2 ? $videoLength : '';
        $content->podcast_length          = $request->get('type') == 3 ? $podcastLength : '';
        $content->number_of_words         = $request->get('type') == 4 ? $request->number_of_words : 0;
        $content->posted_at               = $request->has('posted_at') ? date("Y-m-d H:i:s", strtotime($request->posted_at)) : '';
        $content->external_link           = $request->external_link;
        $content->status                  = '1';

        if ($content->save()) {
            $request->session()->flash('alert-success', 'Content has beeen updated successfully.');
        }
        return redirect(route('admin.content.list'));
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

            if ($content->delete()) {
                $request->session()->flash('alert-success', 'Content deleted successfully.');
            }
            return redirect(route('admin.content.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.content.list'));
        }
    }
}
