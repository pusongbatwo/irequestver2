<!DOCTYPE html>
<html>
<head>
    <title>Document Request Submitted</title>
</head>
<body>
    <h2>Document Request Submitted</h2>
    <p>Hello {{ $documentRequest->first_name }},</p>
    
    <p>Your document request has been received. Here are your details:</p>
    
    <ul>
        <li><strong>Reference Number:</strong> {{ $documentRequest->reference_number }}</li>
        <li><strong>Document Type:</strong> {{ $documentRequest->document_type }}</li>
        <li><strong>Purpose:</strong> {{ $documentRequest->purpose }}</li>
        <li><strong>Status:</strong> {{ $documentRequest->status }}</li>
    </ul>
    
    <p>You can track your request using the reference number above.</p>
    
    <p>Thank you,<br>
    iRequest System</p>
</body>
</html>