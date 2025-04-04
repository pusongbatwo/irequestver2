<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Request Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-red: #8B0000;
            --gold: #D4AF37;
            --light-gold: #F5E7C1;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-gray: #333333;
            --medium-gray: #666666;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--dark-red), #6B0000);
            color: var(--white);
            padding: 25px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .dashboard-header h2 {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .reference-badge {
            background-color: var(--gold);
            color: var(--dark-gray);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
            border-left: 5px solid var(--gold);
        }
        
        .card h3 {
            color: var(--dark-red);
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
        
        .status-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }
        
        .status-processing {
            background-color: #CCE5FF;
            color: #004085;
        }
        
        .status-ready-for-payment {
            background-color: #FFF3CD;
            color: #856404;
        }
        
        .status-ready-for-pickup {
            background-color: #D4EDDA;
            color: #155724;
        }
        
        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 30px;
        }
        
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #E0E0E0;
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }
        
        .step-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            background-color: #E0E0E0;
            color: var(--medium-gray);
            font-size: 18px;
        }
        
        .step-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--medium-gray);
            text-align: center;
        }
        
        .step.completed .step-icon {
            background-color: var(--gold);
            color: var(--dark-red);
            box-shadow: 0 4px 8px rgba(212, 175, 55, 0.3);
        }
        
        .step.completed::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: var(--gold);
            z-index: 1;
        }
        
        .step.current .step-icon {
            background-color: var(--dark-red);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.3);
        }
        
        .step:first-child::before {
            display: none;
        }
        
        .payment-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #EEE;
        }
        
        .payment-label {
            font-weight: 500;
            color: var(--medium-gray);
        }
        
        .payment-value {
            font-weight: 600;
        }
        
        .payment-pending {
            color: #856404;
            background-color: #FFF3CD;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 14px;
        }
        
        .payment-paid {
            color: #155724;
            background-color: #D4EDDA;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 14px;
        }
        
        .payment-actions {
            grid-column: span 2;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        
        .pay-button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .online-pay {
            background-color: var(--dark-red);
            color: var(--white);
        }
        
        .walkin-pay {
            background-color: var(--gold);
            color: var(--dark-gray);
        }
        
        .pay-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #EEE;
        }
        
        .detail-label {
            font-weight: 500;
            color: var(--medium-gray);
        }
        
        .detail-value {
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }
        
        @media (max-width: 768px) {
            .payment-details, .details-grid {
                grid-template-columns: 1fr;
            }
            
            .payment-actions {
                grid-column: span 1;
                flex-direction: column;
            }
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .progress-steps {
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .step {
                flex: none;
                width: calc(50% - 15px);
            }
        }
        .logout-container {
    margin-left: auto;
}

.logout-button {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
}

.logout-button:hover {
    background-color: #c9302c;
}

    </style>
</head>
<body>
    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <h2><i class="fas fa-file-alt"></i> Document Request Dashboard</h2>
            <div class="reference-badge">
                Reference: {{ $document->reference_number }}
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
        </div>

        <!-- Status Overview -->
        <div class="card status-card">
            <div class="status-header">
                <h3><i class="fas fa-tasks"></i> Request Status</h3>
                <div class="status-badge status-{{ strtolower(str_replace(' ', '-', $document->status)) }}">
                    {{ $document->status }}
                </div>
            </div>
            
            <div class="status-progress">
                @php
                    $steps = [
                        'Pending' => ['icon' => 'far fa-clock', 'label' => 'Submitted'],
                        'Processing' => ['icon' => 'fas fa-cog', 'label' => 'Verification'],
                        'Ready for Payment' => ['icon' => 'fas fa-money-bill-wave', 'label' => 'Payment'],
                        'Ready for Pickup' => ['icon' => 'fas fa-box-open', 'label' => 'Proccessing'],
                        'Completed' => ['icon' => 'fas fa-check-circle', 'label' => 'Completed']
                    ];
                    $currentStep = array_search($document->status, array_keys($steps));
                @endphp
                
                <div class="progress-steps">
                    @foreach($steps as $status => $step)
                    <div class="step @if($loop->index < $currentStep) completed 
                                  @elseif($loop->index == $currentStep) current 
                                  @endif">
                        <div class="step-icon">
                            <i class="{{ $step['icon'] }}"></i>
                        </div>
                        <div class="step-label">{{ $step['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="card payment-card">
            <h3><i class="fas fa-credit-card"></i> Payment Information</h3>
            <div class="payment-details">
                <div class="payment-row">
                    <span class="payment-label">Status:</span>
                    <span class="payment-value payment-{{ strtolower($document->payment_status) }}">
                        {{ $document->payment_status }}
                    </span>
                </div>
                <div class="payment-row">
                    <span class="payment-label">Amount:</span>
                    <span class="payment-value">₱{{ number_format($document->amount, 2) }}</span>
                </div>
                <div class="payment-row">
                    <span class="payment-label">Method:</span>
                    <span class="payment-value">
                        {{ $document->payment_method ?? 'Not selected' }}
                    </span>
                </div>
                
                @if($document->status === 'Ready for Payment')
                <div class="payment-actions">
                    <button class="pay-button online-pay" onclick="handleOnlinePayment()">
                        <i class="fas fa-globe"></i> Pay Online
                    </button>
                    <button class="pay-button walkin-pay" onclick="handleWalkInPayment()">
                        <i class="fas fa-store"></i> Pay In Person
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Document Details -->
        <div class="card details-card">
            <h3><i class="fas fa-info-circle"></i> Request Details</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Document Type:</span>
                    <span class="detail-value">{{ $document->document_type }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Request Date:</span>
                    <span class="detail-value">{{ $document->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Purpose:</span>
                    <span class="detail-value">{{ $document->purpose }}</span>
                </div>
                @if($document->special_instructions)
                <div class="detail-item">
                    <span class="detail-label">Special Instructions:</span>
                    <span class="detail-value">{{ $document->special_instructions }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Requester Information -->
        <div class="card requester-card">
            <h3><i class="fas fa-user"></i> Requester Information</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Student ID:</span>
                    <span class="detail-value">{{ $document->personalInformation->student_id }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value">
                        {{ $document->personalInformation->first_name }}
                        {{ $document->personalInformation->middle_name }}
                        {{ $document->personalInformation->last_name }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Course:</span>
                    <span class="detail-value">{{ $document->personalInformation->course }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $document->personalInformation->contact->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $document->personalInformation->contact->mobile }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">
                        {{ $document->personalInformation->contact->barangay }}, 
                        {{ $document->personalInformation->contact->city }}, 
                        {{ $document->personalInformation->contact->province }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleOnlinePayment() {
            alert('Redirecting to secure payment gateway...');
            // In a real implementation, this would redirect to your payment processor
            // window.location.href = '/payment/gateway';
        }
        
        function handleWalkInPayment() {
            alert('Please visit the registrar\'s office during business hours to complete your payment.\n\nOffice Hours: Mon-Fri, 8:00 AM - 5:00 PM');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Any additional JavaScript can go here
            console.log('Dashboard loaded');
        });
    </script>
</body>
</html>