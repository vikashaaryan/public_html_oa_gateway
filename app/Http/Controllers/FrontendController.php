<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ArticleContentModel;
use App\Models\ArticleModel;
use App\Models\ArticleTypeModel;
use App\Models\AuthorModel;
use App\Models\BannerModel;
use App\Models\FaqModel;
use App\Models\FooterCategoryModel;
use App\Models\IssueModel;
use App\Models\JobModel;
use App\Models\PagesModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SubjectModel;
use App\Models\SubmitArticleModel;
use App\Models\TopicModel;
use App\Models\UniversityModel;
use App\Models\VolumeModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class FrontendController extends Controller
{
    public function home(){
        return view('login');
    }
    public function archive_articles($volume_id,$issue_id){
        $data = ArticleModel::with(['Subjects','Topics','Issues','Volumes','ArticleAuthors','ArticleType'])->orderBy('id', 'desc')->where('volume',$volume_id)->where('issue',$issue_id)->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function archives(Request $request){
        $data = VolumeModel::with(['AllIssues','Issues'])->orderBy('id', 'desc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function article_lists(Request $request){
        $data = ArticleModel::with(['Subjects','Topics','Issues','Volumes','ArticleAuthors','ArticleType'])->orderBy('id', 'desc')->where('status','active');
        if(!empty($request->subject) && $request->subject!='null'){
            $cur_subject = $request->subject;
            $data = $data->whereHas('Subjects', function ($query) use ($cur_subject) {
                $query->where('subject', $cur_subject); // or 'name', depending on your structure
            });
        }
        if(!empty($request->university)  && $request->university!='null'){
            $data = $data->where('university',$request->university);
        }
        if(!empty($request->topic)  && $request->topic!='null'){
            $cur_topic =  $request->topic;
            $data = $data->whereHas('Topics', function ($query) use ($cur_topic) {
                $query->where('topic', $cur_topic); // or 'name', depending on your structure
            });
        }
        if(!empty($request->article_type)){
            $data = $data->where('article_type',$request->article_type);
        }
        if (!empty($request->search)) {
            $data = $data->where('title', 'like', '%' . $request->search . '%');
        }
        
        $data = $data->paginate(10);
        $pagination = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'next_page_url' => $data->nextPageUrl(),
            'prev_page_url' => $data->previousPageUrl(),
            'total' => $data->total(),
        ];
        $issues = IssueModel::with(['Volume'])->orderBy('id', 'desc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data' => $data->items(),'pagination'=>$pagination,'issues'=>$issues);
        echo json_encode($validation_success);
    }
    
    public function articles(Request $request){
        $data = ArticleModel::with(['Subjects','Topics','Issues','Volumes','ArticleAuthors','ArticleType'])->orderBy('id', 'desc')->where('status','active');
        if(!empty($request->subject) && $request->subject!='null'){
            $cur_subject = $request->subject;
            $data = $data->whereHas('Subjects', function ($query) use ($cur_subject) {
                $query->where('subject', $cur_subject); // or 'name', depending on your structure
            });
        }
        if(!empty($request->university)  && $request->university!='null'){
            $data = $data->where('university',$request->university);
        }
        if(!empty($request->topic)  && $request->topic!='null'){
            $cur_topic =  $request->topic;
            $data = $data->whereHas('Topics', function ($query) use ($cur_topic) {
                $query->where('topic', $cur_topic); // or 'name', depending on your structure
            });
        }
        if(!empty($request->article_type)){
            $data = $data->where('article_type',$request->article_type);
        }
        if (!empty($request->search)) {
            $data = $data->where('title', 'like', '%' . $request->search . '%');
        }
        
        $data = $data->get();
        $issues = IssueModel::with(['Volume'])->orderBy('id', 'desc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data,'issues'=>$issues);
        echo json_encode($validation_success);
    }
    public function article_types(){
        $data = ArticleTypeModel::orderBy('name', 'asc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function authors(){
        //$data = AuthorModel::with(['Jobs','Locations','Universities'])->orderBy('id', 'desc')->where('status','active')->get();
        $data = JobModel::with(['Authors.Jobs','Authors.Locations', 'Authors.Universities'])->where('status','active')->whereHas('Authors', function ($query) {
        $query->where('status', 'active'); // Only active authors
    })->OrderBy('sort','asc')->get();

        $data = $data->map(function ($job) {
            $job->Authors = $job->Authors->filter(function ($author) {
                return $author->status == 'active'; // Only active authors
            });
            // Sort the authors for each job by their 'sort' attribute
            $job->Authors = $job->Authors->sortBy('sort');
            return $job;
        });
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function chief_editors(){
        $data = AuthorModel::with(['Jobs','Locations','Universities'])->where('status','active')->whereHas('Jobs', function ($query) {
                $query->where('name','Editor-in-Chief'); // or 'name', depending on your structure
            })->where('status','active')->orderBy('sort', 'asc')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function banners(){
        $data = BannerModel::orderBy('id', 'desc')->where('status','active')->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function faq(){
        $data = FaqModel::orderBy('sort', 'asc')->where('status','active')->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function footers(){
        $data = FooterCategoryModel::with(['Links'])->orderBy('sort', 'asc')->where('status','active')->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
     public function social_media_links(){
        $data = SocialMediaLinkModel::orderBy('sort', 'asc')->where('status','active')->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_article($slug){
        $data = ArticleModel::with(['ArticleContents'=> function ($query) {
        $query->orderBy('content_sort', 'asc');
    },'Subjects','Topics','Issues','Volumes','ArticleAuthors','ArticleType'])->orderBy('id', 'desc')->where('status','active')->where('slug_url',$slug)->first();
       
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_author($slug){
        $data = AuthorModel::with(['Jobs','Locations','Universities'])->where('slug_url',$slug)->first();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_issue($id){
        $data = IssueModel::findOrFail($id);
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_subject($slug){
        $data = SubjectModel::where('slug_url',$slug)->first();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_topic($slug){
        $data = TopicModel::where('slug_url',$slug)->first();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_university($slug){
        $data = UniversityModel::with('Locations')->where('slug_url',$slug)->first();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function get_volume($id){
        $data = VolumeModel::with(['Issues'])->findOrFail($id);
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function latest(){
         $data = ArticleModel::with(['Subjects','Issues','Topics','Volumes','ArticleAuthors','ArticleType'])->orderBy('id', 'desc')->where('status','active')->take(9)->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function latest_subjects(){
        $data = SubjectModel::orderBy('id', 'desc')->where('status','active')->take(6)->get();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function Pages($slug){
        $data = PagesModel::where('slug_url',$slug)->first();
         $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function setting(){
        $data = setting();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function subjects(){
        $data = SubjectModel::orderBy('id', 'desc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function submit_article(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required','min:3','max:150'],
            'last_name' => ['required','min:3','max:150'],
            'email' => ['required','email'],
            'institution' => ['required','min:3','max:150'],
            'manuscript_title' => ['required','min:3','max:150'],
            'subject' => ['required'],
            'abstract' => ['required','max:250'],
            'document' => ['required','mimes:pdf,doc,docx','max:10240'],
            'comments' => ['nullable'],
            'confirm' => ['required'],
            'agree' => ['required'],
        ]);
         if($validator->fails()){
            $validation_error['success'] = 0;
            $validation_error['errors'] = $validator->errors()->messages();
            echo json_encode($validation_error);
            exit;
        }
        else{
            $article          =   new SubmitArticleModel();
            if(!empty($request->file('document'))){
                $document            =   $request->file('document');
                $documentURL         =   upload_img($document,'img/document/');
                $article->document   =   $documentURL;
            }
            $article->first_name     =   $request->first_name;
            $article->last_name      =   $request->last_name;
            $article->email_address  =   $request->email;
            $article->institution    =   $request->institution;
            $article->title          =   $request->manuscript_title;
            $article->article_type   =   (!empty($request->article_type))?$request->article_type:'';
            $article->article_topic  =   (!empty($request->article_topic))?$request->article_topic:'';
            $article->subject        =   $request->subject;
            $article->abstract       =   $request->abstract;
            $article->comments       =   (!empty($request->comments))?$request->comments:'';
            $article->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_article'));
            echo json_encode($validation_success);
            exit;
        }
    }
    public function topics(){
        $data = TopicModel::orderBy('name', 'asc')->where('status','active')->get();
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
    public function Universites(){
        $data1 = UniversityModel::with('Locations')->orderBy('name', 'asc')->where('status','active')->where('collaboration',1)->get();
        $data2 = UniversityModel::with('Locations')->orderBy('name', 'asc')->where('status','active')->where('collaboration',0)->get();

        $data = $data1->merge($data2);;
        
        $validation_success = array('success'=>1,'data'=>$data);
        echo json_encode($validation_success);
    }
}
