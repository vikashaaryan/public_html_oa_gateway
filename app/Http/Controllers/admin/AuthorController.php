<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AuthorModel;
use App\Models\JobModel;
use App\Models\LocationModel;
use App\Models\UniversityModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('author/list');
    }
    public function author_list(Request $request){
        $data = AuthorModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_issue = 'author/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_issue)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $author_id        = $request->id;
        $author           = AuthorModel::find($author_id);
        $author->status   = $request->status;
        $author->save();
    }

    public function get_university(Request $request){
        $location         =   $request->location;
        $universities     =   UniversityModel::where('location_id', $location)->where('status','active')->OrderBy('name','asc')->pluck('name', 'id');
        return response()->json($universities);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['jobs']           =   JobModel::where('status','active')->get();
        $data['locations']      =   LocationModel::where('status','active')->get();
        $data['universities']   =   UniversityModel::where('status','active')->get();
        return admin_view('author/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150'],
            'image' => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'email' => ['required','email','unique:author,email'],
            'location' => ['required'],
            'university' => ['required'],
            'job' => ['required'],
            'description' => ['required'],
            'sort' => ['required','numeric'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $author             =   new AuthorModel();
            if(!empty($request->file('image'))){
                $image              =   $request->file('image');
                $imageUrl           =   upload_img($image,'img/author/');
                $author->image      =   $imageUrl;
            }
            $slug_url               =   Str::slug($request->name.''. $request->job);
            $author->slug_url       =   $slug_url;
            $description            =   $request->description;
            $description            =   editor_img($description,'editor');
            $author->name           =   $request->name;
            $author->email          =   $request->email;
            $author->location_id    =   $request->location;
            $author->job_id         =   $request->job;
            $author->university_id  =   $request->university;
            $author->about          =   $description;
            $author->status         =   $request->status;
            $author->sort           =   $request->sort;
            $author->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_editor'),'redirect'=>route('author.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas          =   AuthorModel::findorFail($id);
        $jobs           =   JobModel::where('status','active')->get();
        $locations      =   LocationModel::where('status','active')->get();
        $universities   =   UniversityModel::where('status','active')->get();
        return admin_view('author/edit',array('formAction' => route('author.update', ['author' => $id]),'data'=>$datas,'jobs'=>$jobs,'locations'=>$locations,'universities'=>$universities));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'email' => ['required','min:3','max:200',Rule::unique('author','email')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'location' => ['required'],
            'university' => ['required'],
            'job' => ['required'],
            'description' => ['required'],
            'sort' => ['required','numeric'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $author                 =   AuthorModel::find($id);
            if(!empty($request->file('image'))){
                $image              =   $request->file('image');
                $imageUrl           =   upload_img($image,'img/author/');
                $author->image      =   $imageUrl;
            }
            $slug_url               =   Str::slug($request->name.''. $request->job);
            $author->slug_url       =   $slug_url;
            $description            =   $request->description;
            $description            =   editor_img($description,'editor');
            $author->name           =   $request->name;
            $author->email          =   $request->email;
            $author->location_id    =   $request->location;
            $author->job_id         =   $request->job;
            $author->university_id  =   $request->university;
            $author->about          =   $description;
            $author->status         =   $request->status;
            $author->sort           =   $request->sort;
            $author->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_editor'),'redirect'=>route('author.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
