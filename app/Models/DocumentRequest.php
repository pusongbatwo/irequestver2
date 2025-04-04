<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'document_type',
        'purpose',
        'special_instructions',
        'reference_number',
        'status',
        'payment_status'
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
    
}