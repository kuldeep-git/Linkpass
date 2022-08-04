<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Category;
use Response;
class CategoryController extends Controller
{

    public function __construct() {
        $this->middleware(['web','admin']);
        $this->category = new Category();
        $this->messages = [
            'required' => 'The :attribute is required.',
            'mime_types' => 'Only excel file allowed.'
        ];

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.list',array('title' => 'Category List'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listdata(Request $request)
    {
      // echo "<pre>"; print_r($request->session()->token()); exit();
      $columns = array(
                            0 =>'id',
                            1 =>'name',
                            2=> 'status',
                            3=> 'created_at',
                        );

        $totalData = $this->category->where('status','!=','2')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = $this->category->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->where('status','!=','2')
                         ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  $this->category->orWhere('name', 'LIKE',"%{$search}%")
                            ->where('status','!=','2')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->category->where('status','!=','2')
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $srnumber = $request->has('start') ? $request->get('start') * 1 + 1 : 1;
            foreach ($posts as $post)
            {
                $destroy =  route('admin.category.destroy',$post->hashid);
                $edit =  route('admin.category.edit',$post->hashid);
                $token =  $request->session()->token();

                $nestedData['id'] = $post->id;
                $nestedData['srnumber'] = $srnumber;
                $nestedData['name'] = ucfirst($post->name);
                if($post->status == '1'){
                  $nestedData['status'] = '<span class="badge badge-pill badge-success">Active</span>';
                }elseif($post->status == '0'){
                  $nestedData['status'] = '<span class="badge badge-pill badge-warning">Inactive</span>';
                }else{
                  $nestedData['status'] = '<span class="badge badge-pill badge-danger">Deleted</span>';
                };
                $nestedData['created_at'] = date('d-M-Y',strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$edit}' class='btn btn-primary btn-sm mr-0' title='EDIT' >Edit</a>
                                          &emsp;<form action='{$destroy}' method='POST' style='display: contents;' id='frm_{$post->hashid}'> <input type='hidden' name='_method' value='DELETE'> <input type='hidden' name='_token' value='{$token}'> <a type='submit' class='btn btn-danger btn-sm' style='color: white;' onclick='return deleteConfirm(this);' id='{$post->hashid}'>Delete</a></form>";

                $srnumber++;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );

        echo json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.add',array('title' => 'Category Add'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $input = $request->all();
        $input['status'] = (isset($input['status']))?'1':'0';
        $input['parent_id'] = !empty($input['parent_id']) ? $input['parent_id'] : '0';

        try {
            $category = $this->category->create($input);

            if(isset($category->id)){

                $id = $category->id;
                // Image Upload
                $file            = $request->file('categoryIcon');
                $imageExtensions = implode(',', config('default.image_extensions'));

                if($file){

                    $request->validate([
                        'file' => 'mimes:'.$imageExtensions.'|max:2048'
                    ]);

                    $file_name  = $file->getClientOriginalName();
                    $fileslug   = pathinfo($file_name, PATHINFO_FILENAME);
                    $imageName  = md5($fileslug.time());
                    $imgext     = $file->getClientOriginalExtension();
                    $path       = 'category/'.$id.'/'.$imageName.".".$imgext;
                    $fileAdded  = Storage::disk('public')->putFileAs('category/'.$id.'/',$file,$imageName.".".$imgext);

                    if($fileAdded){
                        $categoryData = $this->category->find($id);
                        Storage::disk('public')->delete($categoryData->icon);
                        $media = $this->category->where('id',$id)->update(['icon' => $path]);
                    }
                }

              $request->session()->flash('alert-success', 'Category added successfully.');
            }
        } catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.category.add'));
        }
        return redirect(route('admin.category.list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',array('title' => 'Category Edit','categorydata'=>$category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {

          if(!$category){
            return abort(404) ;
          }

          $id                   = $category->id;
          $category->name       = $request->name;
          $category->parent_id  = $request->parent_id;
          $category->status     = (isset($request->status))?'1':'0';

          $file                 = $request->file('categoryIcon');
          $imageExtensions      = implode(',', config('default.image_extensions'));

          if($file){

            $request->validate([
                'file' => 'mimes:'.$imageExtensions.'|max:2048'
            ]);

            if ($category->icon_url) {
                Storage::disk('public')->delete($category->icon);
            }

            $file_name  = $file->getClientOriginalName();
            $fileslug   = pathinfo($file_name, PATHINFO_FILENAME);
            $imageName  = md5($fileslug.time());
            $imgext     = $file->getClientOriginalExtension();
            $path       = 'category/'.$id.'/'.$imageName.".".$imgext;
            $fileAdded  = Storage::disk('public')->putFileAs('category/'.$id.'/',$file,$imageName.".".$imgext);

            $category->icon = $path;
        }

          if($category->save())
          {
              $request->session()->flash('alert-success', 'Category updated successfully.');
          }
          return redirect(route('admin.category.list'));

        } catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.category.list'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        try {

            if(!$category){
                return abort(404) ;
            }

            if ($category->delete()) {
                $request->session()->flash('alert-success', 'Category deleted successfully.');
            }
            return redirect(route('admin.category.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.category.list'));
        }
    }
}
