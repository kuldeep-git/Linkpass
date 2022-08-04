<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enquiry;
use Response;
class EnquiryController extends Controller
{

    public function __construct() {
        $this->middleware(['web','admin']);
        $this->enquiry = new Enquiry();
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
        return view('admin.enquiry.list',array('title' => 'Enquiry List'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listdata(Request $request)
    {
      $columns = array(
        0 =>'id',
        1 =>'subject',
        2=> 'message',
        3=> 'created_at',
      );

        $totalData = $this->enquiry->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = $this->enquiry->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  $this->enquiry->where('subject', 'LIKE',"%{$search}%")
                            ->orWhere('message', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->enquiry->where('subject', 'LIKE',"%{$search}%")
                            ->orWhere('message', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $srnumber = $request->has('start') ? $request->get('start') * 1 + 1 : 1;
            foreach ($posts as $post)
            {
                $destroy =  route('admin.enquiry.destroy',$post->hashid);
                $edit =  route('admin.enquiry.edit',$post->hashid);
                $token =  $request->session()->token();

                $nestedData['id'] = $post->id;
                $nestedData['srnumber'] = $srnumber;
                $nestedData['subject'] = ucfirst($post->subject);
                $nestedData['message'] = \Str::limit($post->message, 100);

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
        return view('admin.enquiry.add',array('title' => 'Enquiry Add'));
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
    public function edit(Enquiry $enquiry)
    {
        return view('admin.enquiry.edit',array('title' => 'Enquiry Edit','enquirydata'=>$enquiry));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Enquiry $enquiry, Request $request)
    {
        $request->validate([
            'subject' => 'required',
        ]);

        try {

          if(!$enquiry){
            return abort(404) ;
          }

          $id                  = $enquiry->id;
          $enquiry->subject       = $request->subject;
          $enquiry->message  = $request->message;

          if($enquiry->save())
          {
              $request->session()->flash('alert-success', 'Enquiry has been updated successfully.');
          }
          return redirect(route('admin.enquiry.list'));

        } catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.enquiry.list'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquiry $enquiry, Request $request)
    {
        try {

            if(!$enquiry){
                return abort(404) ;
            }

            if ($enquiry->delete()) {
                $request->session()->flash('alert-success', 'Enquiry deleted successfully.');
            }
            return redirect(route('admin.enquiry.list'));
        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('admin.enquiry.list'));
        }
    }
}
