<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\SocialAccountRequest;
use Auth;
use App\GuideCompletion;
use PDF;
use App\SocialAccount;
use Response;
use Storage;

class SocialAccountController extends Controller
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
        return view('social-account.list',array('title' => 'Social Account List'));
    }

    public function listdata(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'url',
            2 => 'account_url',
            3 => 'created_at'
        );

        $totalData = SocialAccount::where('user_id', Auth::user()->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $socialAccounts = SocialAccount::where('user_id', Auth::user()->id)
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,'asc')
                         ->get();
        }
        else {
            $search = $request->input('search.value');

            $socialAccounts = SocialAccount::where('user_id', Auth::user()->id)
                            ->where('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered  = SocialAccount::where('user_id', Auth::user()->id)
                            ->where('name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($socialAccounts))
        {   $srnumber = 1;
            foreach ($socialAccounts as $account)
            {
                $editRoute =  route('user.social-account.edit', $account->hashid);
                $deleteRoute =  route('user.social-account.destroy', $account->hashid);
                $token =  $request->session()->token();

                $nestedData['id']          = $account->id;
                $nestedData['srnumber']    = $srnumber;
                $nestedData['image']       = '<img src="'.$account->image_url.'" width="50" class="mr-3">';
                $nestedData['name']        = $account->name;
                $nestedData['url']         = $account->url;
                $nestedData['account_url'] = $account->account_url;
                $nestedData['created_at']  = date('d-M-Y',strtotime($account->created_at));
               // $nestedData['actions']     = "<a href='{$editRoute}' class='btn btn-success btn-xs mr-0' title='Edit'><i class='fa fa-edit'></i></i> Edit</a> <a href='javascript:void(0);' class='btn btn-danger btn-xs mr-0' title='View'><i class='fa fa-trash'></i></i> Delete</a>";

                $nestedData['actions'] = "&emsp;<a href='{$editRoute}' class='btn btn-success btn-xs mr-0' title='EDIT' >Edit</a>
                                          &emsp;<form action='{$deleteRoute}' method='POST' style='display: contents;' id='frm_{$account->hashid}'> <input type='hidden' name='_method' value='DELETE'> <input type='hidden' name='_token' value='{$token}'> <a type='submit' class='btn btn-danger btn-xs mr-0' style='color: white;' onclick='return deleteConfirm(this);' id='{$account->hashid}'>Delete</a></form>";

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

    public function create()
    {
        return view('social-account.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\SocialAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialAccountRequest $request)
    {
        $file = $request->file('image');

        $paramsArr = array();
        $paramsArr['name']        = $request->name;
        $paramsArr['host_name']   = $request->host_name;
        $paramsArr['url']         = $request->url;
        $paramsArr['account_url'] = $request->account_url;
        $paramsArr['user_id']     = Auth::user()->id;

        $socialAccount = SocialAccount::create($paramsArr);

        if($file){

            $file_name  = $file->getClientOriginalName();
            $fileslug   = pathinfo($file_name, PATHINFO_FILENAME);
            $imageName  = md5($fileslug.time());
            $imgext     = $file->getClientOriginalExtension();
            $path       = 'social-account-images/'.$socialAccount->id.'/'.$imageName.".".$imgext;

            Storage::disk('public')->putFileAs('social-account-images/'.$socialAccount->id,$file,$imageName.".".$imgext);

            $socialAccount->update(['image' => $path]);
        }

        return redirect(route('user.account'))->withStatus(__('Social account details has been created successfully.'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function show(SocialAccount $socialAccount)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialAccount $socialAccount)
    {
        return view('social-account.edit', array('socialAccount'=> $socialAccount));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\SocialAccountRequest $request
     * @param  \App\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function update(SocialAccountRequest $request, SocialAccount $socialAccount)
    {
        $file = $request->file('image');

        $paramsArr = array();
        $paramsArr['name']        = $request->name;
        $paramsArr['host_name']   = $request->host_name;
        $paramsArr['url']         = $request->url;
        $paramsArr['account_url'] = $request->account_url;

        if($file){

            if (is_file(public_path($socialAccount->image))) {
                unlink(public_path($socialAccount->image));
            }

            $file_name  = $file->getClientOriginalName();
            $fileslug   = pathinfo($file_name, PATHINFO_FILENAME);
            $imageName  = md5($fileslug.time());
            $imgext     = $file->getClientOriginalExtension();
            $path       = 'social-account-images/'.$socialAccount->id.'/'.$imageName.".".$imgext;

            Storage::disk('public')->putFileAs('social-account-images/'.$socialAccount->id,$file,$imageName.".".$imgext);

           $paramsArr['image'] = $path;
        }

        $socialAccount->update($paramsArr);

        $request->session()->flash('alert-success', 'Host Details has been updated successfully.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialAccount $socialAccount, Request $request)
    {
        try {

            if(!$socialAccount){
                return abort(404) ;
            }

            if ($socialAccount->delete()) {
                $request->session()->flash('alert-success', 'Listing Group has been deleted successfully.');
            }

            return redirect(route('user.social-account.list'));

        }catch (ModelNotFoundException $exception) {
            $request->session()->flash('alert-danger', $exception->getMessage());
            return redirect(route('user.social-account.list'));
        }
    }

    public function deleteSocialAccount(Request $request)
    {
        $socialAccount = SocialAccount::find($request->social_account_id);

        if($socialAccount){

            $socialAccount->delete();

            return Response::json(['status' => true, 'message' => 'Listing Group has been deleted successfully.']);
        }

        return Response::json(['status' => false, 'message' => 'Something went wrong while deleting Listing Group.']);
    }
}
