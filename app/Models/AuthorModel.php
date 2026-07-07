<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{
    protected $table    = 'author';
    protected $fillable = ['name','photo','email','location_id','university_id','job_id','about','status'];

    // Author belongs to a Job
    public function Jobs()
    {
        return $this->belongsTo(JobModel::class, 'job_id', 'id');
    }

    // Author belongs to one Location
    public function Locations()
    {
        return $this->belongsTo(LocationModel::class, 'location_id', 'id');
    }

    // Author belongs to one University
    public function Universities()
    {
        return $this->belongsTo(UniversityModel::class, 'university_id', 'id');
    }
    
}
