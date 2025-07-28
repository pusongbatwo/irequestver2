<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_requests';
    protected $fillable = [
        'student_id', 'first_name', 'middle_name', 'last_name', 'course',
        'province', 'city', 'barangay', 'mobile_number', 'email',
        'purpose', 'special_instructions', 'status', 'payment_status',
        'request_date', 'reference_number', 'year_level', 'alumni_school_year', 'school_years'
    ];

    public $timestamps = false; // If you only have created_at, not updated_at

    protected $casts = [
        'created_at' => 'datetime',
        'request_date' => 'datetime',
        'school_years' => 'array',
    ];

    // Relationship to PersonalInformation
    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'student_id', 'student_id');
    }

    // Access contact information through personal information
    public function getContactInformationAttribute()
    {
        return $this->personalInformation->contact;
    }

    public function requestedDocuments()
    {
        return $this->hasMany(RequestedDocument::class, 'request_id');
    }
}