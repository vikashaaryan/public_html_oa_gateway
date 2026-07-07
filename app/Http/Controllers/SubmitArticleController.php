<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModel;
use App\Models\SubmitArticleModel;

class SubmitArticleController extends Controller
{
    public function Submitarticle()
    {
        $subjects = SubjectModel::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'public.submit-article',
            compact('subjects')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name'  => 'required|max:100',
            'email'      => 'required|email',
            'institution'=> 'required|max:255',
            'title'      => 'required|max:500',
            'subject'    => 'required|exists:subject,id',
            'abstract'   => 'required|min:10',
            'document'   => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $document = null;

        if ($request->hasFile('document')) {

            $file = $request->file('document');

            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('img/document'),
                $fileName
            );

            $document = 'img/document/' . $fileName;
        }

        SubmitArticleModel::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email_address' => $request->email,
            'institution'   => $request->institution,
            'title'         => $request->title,
            'subject'       => $request->subject,
            'abstract'      => $request->abstract,
            'document'      => $document,
            'comments'      => $request->comments,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Your manuscript has been submitted successfully. Our editorial team will contact you soon.'
            );
    }
}