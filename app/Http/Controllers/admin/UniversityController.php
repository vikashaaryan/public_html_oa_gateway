<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LocationModel;
use App\Models\UniversityModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('university/list');
    }
    public function university_list(Request $request){
        $data = UniversityModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_category = 'university/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_category)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $university_id        = $request->id;
        $university           = UniversityModel::find($university_id);
        $university->status   = $request->status;
        $university->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['locations']  =   LocationModel::where('status','active')->get();
        return admin_view('university/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:university,name'],
            'location' => ['required'],
            'description' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $university             =   new UniversityModel();
            $university->name       =   $request->name;
            $slug_url               =   Str::slug($request->name);
            $university->slug_url   =   $slug_url;
            $university->location_id=   $request->location;
            $description            =   $request->description;
            $description            =   editor_img($description,'university');
            $university->description=   $description;
            $university->status     =   $request->status;
            $university->collaboration = !empty($request->collaboration)?1:0;
            $university->meta_title =   $request->meta_title;
            $university->meta_description=   $request->meta_description;
            $university->meta_keywords   =   $request->meta_keyword;
            $university->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_university'),'redirect'=>route('university.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   UniversityModel::findorFail($id);
        $locations  =   LocationModel::where('status','active')->get();
        return admin_view('university/edit',array('formAction' => route('university.update', ['university' => $id]),'data'=>$datas,'locations'=>$locations));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('university','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'location' => ['required'],
            'description' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $university            =   UniversityModel::find($id);
            $university->name      =   $request->name;
            $slug_url               =   Str::slug($request->name);
            $university->slug_url   =   $slug_url;
            $university->location_id=   $request->location;
            $description            =   $request->description;
            $description            =   editor_img($description,'university');
            $university->description=   $description;
            $university->status    =   $request->status;
            $university->collaboration = !empty($request->collaboration)?1:0;
            $university->meta_title =   $request->meta_title;
            $university->meta_description=   $request->meta_description;
            $university->meta_keywords   =   $request->meta_keyword;
            $university->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_university'),'redirect'=>route('university.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
