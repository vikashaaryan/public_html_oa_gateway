<?php
use Illuminate\Support\Facades\Auth;
use App\Models\SettingModel;


function validation($validate='',$form_id='',$post_url='',$redirect_url='',$error_id='',$error_msg= '',$confirm_msg='',$popup_open='',$popup_close='',$message= '') {  

    $return  = '<style>.error{color:#ff0000 !important}</style>';
    if(empty($popup_open) || empty($popup_close)){
      $return .= '<script src="'.asset('js/backend/validate/jquery-1.11.1.min.js').'"></script>';
    }
    
		$return .='<script src="'.asset('js/backend/validate/jquery.validate.min.js').'"></script>
		<script src="'.asset('js/backend/validate/additional-methods.min.js').'"></script>';
    if($validate!=''){
      $return .= '<link href="'.asset('css/backend/sweetalert/sweetalert2.min.css').'" rel="stylesheet">
      <script src="'.asset('js/backend/sweetalert/sweetalert2.min.js').'"></script>';
      $return .= '<script>hideSpinner = ()=>{}
      showSpinner = ()=>{}</script><script>';
      if(empty($post_url)){
          $return .= 	'$( "#'.$form_id.'" ).validate({rules: {'.$validate.'}});</script>';
      }
      else{
          $hide_error = $show_error = '';
          if(!empty($error_id)){
              $hide_error = '$("#'.$error_id.'").hide();';
              $show_error = '$("#'.$error_id.'").show();';
          }
          $return .= 	'$( "#'.$form_id.'" ).validate({
              rules: {
                '.$validate.'
              },';
          if(!empty($message)){
            $return .= 	'messages:{
                            '.$message.'
                          },';
          }
          $return .= 	'submitHandler: function(form) {'.$hide_error.'showSpinner();';
          
          if(!empty($confirm_msg)){
            $return .= "hideSpinner();Swal.fire({
                            title: 'Alert' ,
                            html: '".$confirm_msg."',
                            showCloseButton: true,
                            showCancelButton: true,
                            icon: 'warning',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            allowOutsideClick:false,
                          }).then((response) => {
                            if (response.isConfirmed) {
                            showSpinner();
                        ";

          }
          $return .=  'var formData = new FormData(form);
                $.ajax({
                  url: "'.$post_url.'",
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {';
                        if(!empty($redirect_url)){
                          $return .= ' window.location.href="'.$redirect_url.'"';
                        }else{
                          if(!empty($popup_open)){
                            $return .= "$('#".$popup_open."').modal('show');";
                          }
                          if(!empty($popup_close)){
                            $return .= "$('#".$popup_close."').modal('hide');";
                          }
                          $return .= "var result = JSON.parse(response);
                                      if(result.success ==0){
                                      hideSpinner();
                                        Swal.fire({
                                          title: 'Error' ,
                                          html: result.error_msg,
                                          icon: 'error',
                                          confirmButtonText: 'OK',
                                          allowOutsideClick:false,
                                        });
                                      }
                                      else{
                                      
                                      hideSpinner();
                                        Swal.fire({
                                          title: 'Success' ,
                                          html: result.message,
                                          icon: 'success',
                                          confirmButtonText: 'OK',
                                          allowOutsideClick:false,
                                        }).then((response) => {
                                          if (response.isConfirmed) {
                                            if(result.redirect !='' ){  
                                              window.location.href = result.redirect;
                                            }
                                          }
                                        });
                                        
                                      }
                                      ";
                          
                        }
                        $return .= '}
                      ,error: function(xhr, status, error) {
                          '.$show_error.'
                          console.error("Error:", error);
                          hideSpinner();
                      },
                      complete: function() {
                          console.log("Request completed.");
                          hideSpinner();                        
                      }
                  ';
                
            $return .= '});';
          if(!empty($confirm_msg)){
            $return .= "}});";
          }
          $return .= 'return false;}});</script>';
      }
    }
	return $return;
}
function data_table($table_id, $view_data,$url,$search_id='',$row_coln='',$row_val='',$order_col ='') {
    $csrfToken = csrf_token();
    $data = ' <script src="'.asset('js/backend/datatable/jquery-3.6.0.min.js').'"></script><link rel="stylesheet" href="'.asset('css/backend/datatable/jquery.dataTables.min.css').'"><script src="'.asset('js/backend/datatable/jquery.dataTables.min.js').'"></script>';
    $data .= '<script> if (typeof search !== "undefined") {let search = "";}';
    $data .='$(document).ready(function()  {
      var table =   $("#'.$table_id.'").DataTable( {';
    if($order_col!=''){
      $data .=' "order": [['.$order_col.', "desc"]],';
    }
    $data .='"columns": [
                  '.$view_data.'
              ],';
      if(!empty($row_coln) && !empty($row_val)){
        $data .='        createdRow: function(row, data, dataIndex) {
              if (data.'.$row_coln.' === "'.$row_val.'") {
                  row.style.backgroundColor = "lightgreen";  // Inactive row
              } 
          },';
      }
      $data .='
          "ordering": true,
          "processing": true,
          "serverSide": true,
          "ajax":  {
            "type": "POST",
            "url": "'.$url.'",
            "headers": {
              "X-CSRF-TOKEN": "'.$csrfToken.'" // Include CSRF token in the headers
            },';
      if(!empty($search_id)){
        $data .=' "data": function (d) {
                  d.'.$search_id.' = $("#'.$search_id.'").val(); // Send search as part of POST data
              },';
      }
      $data .=' }
      } );';
  if(!empty($search_id)){
      $data .='  $("#'.$search_id.'").change(function () {
          table.ajax.reload();
        });';
  }
    $data .=' $("#'.$table_id.'_length").hide(); })
  </script>';
    return $data;
}
function validation_errors_message($error_messages){
  $error_msg = '';
  $req_error = '';
  if(!empty($error_messages)){
      $i =0;
      foreach($error_messages as $key=>$messages){
          if (empty($req_error) || $req_error != $messages[0]){
              $cur_message = explode('_',$messages[0]);
              if(!empty($cur_message[1])){
                $messages[0]  = $cur_message[0].' '.$cur_message[1]; 
              }
              $cur_message1 = explode('.',$messages[0]);
              if(!empty($cur_message1[1])){
                $messages[0] = $cur_message1[0].' '.$cur_message1[1];
              }
              $messages[0] = preg_replace_callback('/(\s)(\d+)(\s)/', function ($matches) {
                return $matches[1] . ((int)$matches[2] + 1) . $matches[3];
            }, $messages[0]);
              $error_msg .= '<span style="">'.$messages[0].'</span><br>';
              $req_error = $messages[0];
              $i++;
          }
      }
  }
 return $validation_error = array('success'=>0,'error_msg'=>$error_msg);
}
function remove_img($logo){
  if(!empty($logo) && file_exists(public_path($logo))){
      unlink(public_path($logo));
  }
  return true;
}
function upload_img($image,$file_path){
  $imageName          =   time().'.'.$image->extension();
  $image->move(public_path($file_path), $imageName);
  $imageUrl           =   $file_path.$imageName;
  return $imageUrl;
}
function getFirst100Words($text) {
  $words = explode(' ', $text);
  
  $first100Words = array_slice($words, 0, 10);
  if(str_word_count($text)>10){
    return implode(' ', $first100Words).'....';
  }
  else{
    return $text;
  }
}
function setting(){
  $setting = SettingModel::find(1);
  return $setting;
}
function get_admin_url($url=''){
  return url('journal_admin/'.$url);
}
function date_picker($start_date= '',$end_date=''){
  $return = '<link rel="stylesheet" href="'.asset('css/datepicker.css').'">
  <script src="'.asset('js/datepicker.js').'"></script>';
    $return .= '<script>
      $(function () {
            $(".datepicker").datepicker({
                    format: "dd-mm-yyyy", // Adjust the format as needed
                    autoclose: true,';
    $return .= !empty($start_date)?' startDate: new Date() ':'';//disable past date
    $return .= !empty($end_date)?' endDate: new Date() ':'';//disable future date

    $return .= ' });
        });
    </script>';
  
  return $return;
}
function delete_fn($del_msg,$del_url){
  $alert_css = asset('css/backend/sweetalert/sweetalert2.min.css');
  $alert_js = asset('js/backend/sweetalert/sweetalert2.min.js');
  $csrf_token = 'meta[name="csrf-token"]';
  $message = "You won\'t be able to revert this!";
  $data = '<link href="'.$alert_css.'" rel="stylesheet">
<script src="'.$alert_js.'"></script><script>';
$data .= "delete_fun = (del_id) =>{
        const csrfToken = document.querySelector('".$csrf_token."').getAttribute('content');
        Swal.fire({
            title: 'Are you sure?',
            text: '".$message."',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            allowOutsideClick:false,
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the deletion using Fetch API or other method
                $.ajax({
                    url: '".$del_url."/' + del_id,
                    type: 'DELETE',
                    data: {
                        _token: $('".$csrf_token."').attr('content')
                    },
                    success: function(response) {
                      var result = JSON.parse(response);
                        if(result.success ==1){
                          Swal.fire(
                              'Deleted!',
                              '".$del_msg."',
                              'success'
                          ).then(() => {
                              location.reload(); // Reload the page or update the UI as needed
                          });
                        }
                        else{
                          Swal.fire({
                            title: 'Error' ,
                            html: result.error_msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            allowOutsideClick:false,
                          });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was a problem deleting the item.',
                            'error'
                        );
                    }
                });
            }
        });
    }</script>";
    return $data;
}

function alert_fn($message,$url=''){
  $csrf_token = 'meta[name="csrf-token"]';
  if(!empty($url)){
    $alert_css = asset('css/backend/sweetalert/sweetalert2.min.css');
    $alert_js = asset('js/backend/sweetalert/sweetalert2.min.js');
    $data = '<link href="'.$alert_css.'" rel="stylesheet">
            <script src="'.$alert_js.'"></script>';
  }
$data .= "<script>alert_fun = () =>{
        const csrfToken = document.querySelector('".$csrf_token."').getAttribute('content');
        Swal.fire({
            
            text: '".$message."',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            allowOutsideClick:false,
            confirmButtonText:'Ok'
        });
    }</script>";
    return $data;
}
function change_status($message,$url=''){
  $csrf_token = 'meta[name="csrf-token"]';
    $alert_css = asset('css/backend/sweetalert/sweetalert2.min.css');
    $alert_js = asset('js/backend/sweetalert/sweetalert2.min.js');
    $data = '<link href="'.$alert_css.'" rel="stylesheet">
            <script src="'.$alert_js.'"></script>';

$data .= "<script>change_status = (id,cat_staus) =>{
        var cur_url = '".$url."?id='+id+'&status='+cat_staus;
        const csrfToken = document.querySelector('".$csrf_token."').getAttribute('content');
        Swal.fire({
            title: 'Are you sure?',
            text: '".$message."',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            allowOutsideClick:false,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                
                $.ajax({
                    url: cur_url,
                    type: 'GET',
                    data: {
                        _token: $('".$csrf_token."').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            '',
                            'Status changed successfully.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page or update the UI as needed
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was a problem ',
                            'error'
                        );
                    }
                });
            }
        });
    }</script>";
    return $data;
}
function ins_date_format($gn_date){
  return date('Y-m-d',strtotime($gn_date));
}
function ins_date_time_format($gn_date){
  return date('Y-m-d H:i:s',strtotime($gn_date));
}
function site_date_format($gn_date){
  return date('d-m-Y',strtotime($gn_date));
}
function site_date_format_time($gn_date){
  return date('d-m-Y H:i',strtotime($gn_date));
}
function admin_view($view,$data=[]){
  return view('admin.'.$view,$data);
}
function editor_img($description,$cur_path){
  preg_match_all('/data:image\/(\w+);base64,([^\"]*)/', $description, $matches);
  if (count($matches[0]) > 0) {
      foreach ($matches[0] as $index => $match) {
          // Get the base64 encoded image data
          $imageData = $matches[2][$index];

          // Decode the image
          $image = base64_decode($imageData);

          // Generate a unique filename
          $filename = 'image_' . uniqid() . '.png';  // You can modify the extension depending on the image type
          $directory = public_path('img/'.$cur_path);

          // Ensure the directory exists, create it if it doesn't
          if (!file_exists($directory)) {
              mkdir($directory, 0775, true);  // 0775 gives write permissions
          }

          $path = $directory . '/' . $filename;
          // Save the image to storage
          file_put_contents($path, $image);
          // Replace the base64 image in the description with the stored image URL
          $imageUrl = url('img/'.$cur_path.'/' . $filename);
          $description = str_replace($match, $imageUrl, $description);
      }
  }
  return $description;
}