<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRequestsTable extends Migration
{
    public function up()
    {
        // Personal Information Table
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('course');
            $table->timestamps();
        });

        // Contact Information Table
        Schema::create('contact_information', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('mobile');
            $table->string('email');
            $table->timestamps();
            
            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('personal_information');
        });

        // Document Requests Table
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->enum('document_type', [
                'Transcript of Records',
                'Diploma',
                'Certificate of Enrollment',
                'Certificate of Graduation',
                'Other'
            ]);
            $table->enum('purpose', [
                'Further Studies',
                'Employment',
                'Scholarship',
                'Personal Record',
                'Other'
            ]);
            $table->text('special_instructions')->nullable();
            $table->string('reference_number')->unique();
            $table->enum('status', [
                'Pending',
                'Processing',
                'Completed',
                'Ready for Pickup',
                'Delivered',
                'Cancelled'
            ])->default('Pending');
            $table->enum('payment_status', [
                'Unpaid',
                'Paid',
                'Pending'
            ])->default('Unpaid');
            $table->timestamps();
            
            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('personal_information');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_requests');
        Schema::dropIfExists('contact_information');
        Schema::dropIfExists('personal_information');
    }
}