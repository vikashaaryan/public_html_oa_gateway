<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LocationModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('location/list');
    }
    public function location_list(Request $request){
        $data = LocationModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_category = 'location/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_category)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $location_id        = $request->id;
        $location           = LocationModel::find($location_id);
        $location->status   = $request->status;
        $location->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('location/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:location,name'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $location            =   new LocationModel();
            $location->name      =   $request->name;
            $location->status    =   $request->status;
            $location->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_location'),'redirect'=>route('location.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   LocationModel::findorFail($id);
        return admin_view('location/edit',array('formAction' => route('location.update', ['location' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('location','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $location            =   LocationModel::find($id);
            $location->name      =   $request->name;
            $location->status    =   $request->status;
            $location->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_location'),'redirect'=>route('location.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
