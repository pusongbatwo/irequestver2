<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Request Cashier Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8B0000; /* College dark red */
            --primary-light: #A52A2A;
            --secondary: #D4AF37; /* Gold accent */
            --dark: #222;
            --light: #FFF;
            --success: #4CAF50;
            --warning: #FFC107;
            --danger: #F44336;
            --gray: #E0E0E0;
            --gray-dark: #616161;
            --bg-light: #FAFAFA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-light);
            color: var(--dark);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--primary);
            transition: all 0.3s ease;
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--secondary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
        }

        .logo-text {
            font-weight: 600;
            font-size: 18px;
            color: var(--light);
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--light);
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-title {
            padding: 0 1.5rem 0.5rem;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }

        .menu-link:hover, .menu-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--light);
        }

        .menu-link:hover::before, .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--secondary);
        }

        .menu-icon {
            font-size: 20px;
            margin-right: 12px;
            color: var(--secondary);
        }

        .menu-badge {
            margin-left: auto;
            background: var(--secondary);
            color: var(--primary);
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--light);
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            background: var(--light);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--light);
            border-radius: 8px;
            padding: 8px 12px;
            width: 300px;
            border: 1px solid var(--gray);
        }

        .search-bar input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 4px 8px;
        }

        .search-icon {
            color: var(--gray-dark);
            margin-right: 8px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notification-icon {
            font-size: 20px;
            color: var(--gray-dark);
            position: relative;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--danger);
            color: white;
            font-size: 10px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dashboard Cards */
        .dashboard-content {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary-card {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 12px;
        }

        .card-icon.pending {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .card-icon.paid {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .card-icon.amount {
            background: rgba(139, 0, 0, 0.1);
            color: var(--primary);
        }

        .card-icon.requests {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-light);
        }

        .card-title {
            font-size: 14px;
            color: var(--gray-dark);
            font-weight: 500;
        }

        .card-value {
            font-size: 24px;
            font-weight: 600;
            margin: 8px 0 4px;
            color: var(--primary);
        }

        .card-change {
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .card-change.positive {
            color: var(--success);
        }

        /* Document Types Breakdown */
        .document-types {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            border-top: 3px solid var(--secondary);
        }

        .progress-container {
            margin-top: 1rem;
        }

        .progress-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .progress-label {
            width: 150px;
            font-size: 14px;
        }

        .progress-bar {
            flex-grow: 1;
            height: 8px;
            background: var(--gray);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }

        .progress-fill.transcript {
            background: var(--primary);
            width: 65%;
        }

        .progress-fill.diploma {
            background: var(--secondary);
            width: 20%;
        }

        .progress-fill.certification {
            background: var(--success);
            width: 10%;
        }

        .progress-fill.other {
            background: var(--warning);
            width: 5%;
        }

        /* Recent Requests Table */
        .recent-requests {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
        }

        .view-all {
            color: var(--primary);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            color: var(--gray-dark);
            font-weight: 500;
            text-transform: uppercase;
            border-bottom: 2px solid var(--gray);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--gray);
            font-size: 14px;
        }

        .request-id {
            font-weight: 600;
            color: var(--primary);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .status-paid {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .status-cancelled {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger);
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--gray-dark);
            cursor: pointer;
            font-size: 16px;
            margin-left: 8px;
        }

        .action-btn:hover {
            color: var(--primary);
        }

        /* Payment Modal */
        .payment-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--light);
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray);
            padding-bottom: 1rem;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray-dark);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--gray);
            border-radius: 6px;
            font-size: 14px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 1.5rem 0;
        }

        .payment-option {
            border: 1px solid var(--gray);
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-option:hover {
            border-color: var(--primary);
        }

        .payment-option.selected {
            border-color: var(--primary);
            background: rgba(139, 0, 0, 0.05);
        }

        .payment-icon {
            font-size: 24px;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 1.5rem;
            border-top: 1px solid var(--gray);
            padding-top: 1.5rem;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
        }

        .btn-secondary {
            background: var(--gray);
            color: var(--dark);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--light);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                width: 80px;
            }
            .logo-text, .menu-title, .menu-text, .user-details {
                display: none;
            }
            .menu-link {
                justify-content: center;
                padding: 12px 0;
            }
            .menu-icon {
                margin-right: 0;
                font-size: 22px;
            }
            .search-bar {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .search-bar {
                width: 100%;
            }
        }

        /* Feature UI Styles */
        .feature-ui {
            display: none;
            margin-top: 1.5rem;
        }
        
        .feature-ui.active {
            display: block;
        }
        
        .dashboard-sections {
            display: block;
        }
        
        .dashboard-sections.hidden {
            display: none;
        }
        
        /* Process Payment UI */
        .payment-processor {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }
        
        .payment-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .form-row {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-dark);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray);
            border-radius: 6px;
            font-size: 14px;
        }
        
       
       
        .submit-payment {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
        }
        
        /* Document Requests UI */
        .document-requests {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }
        
        .request-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-select {
            padding: 0.75rem;
            border: 1px solid var(--gray);
            border-radius: 6px;
            min-width: 200px;
        }
        
        /* Transactions UI */
        .transactions-list {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }
        
        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid var(--gray);
        }
        
        .transaction-details {
            flex: 2;
        }
        
        .transaction-amount {
            flex: 1;
            text-align: right;
            font-weight: 600;
        }
        
        /* Reports UI */
        .reports-container {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--secondary);
        }
        
        .report-tabs {
            display: flex;
            border-bottom: 1px solid var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .report-tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .report-tab.active {
            border-bottom-color: var(--primary);
            font-weight: 600;
        }
        
        .report-content {
            display: none;
        }
        
        .report-content.active {
            display: block;
        }
        
        .chart-placeholder {
            height: 300px;
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <span class="logo-text">Cashier Panel</span>
            </div>
            <button class="toggle-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <h3 class="menu-title">Main</h3>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="#" class="menu-link active" data-section="dashboard">
                        <i class="fas fa-home menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="processPayment">
                        <i class="fas fa-cash-register menu-icon"></i>
                        <span class="menu-text">Process Payment</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="documentRequests">
                        <i class="fas fa-file-alt menu-icon"></i>
                        <span class="menu-text">Document Requests</span>
                        <span class="menu-badge">12</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="transactions">
                        <i class="fas fa-exchange-alt menu-icon"></i>
                        <span class="menu-text">Transactions</span>
                    </a>
                </li>
            </ul>

            <h3 class="menu-title">Reports</h3>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="dailySummary">
                        <i class="fas fa-chart-bar menu-icon"></i>
                        <span class="menu-text">Daily Summary</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="exportRecords">
                        <i class="fas fa-file-export menu-icon"></i>
                        <span class="menu-text">Export Records</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User" class="avatar">
                <div class="user-details">
                    <div class="user-name">Maria Garcia</div>
                    <div class="user-role">Document Cashier</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div class="page-title">
                <h1 id="pageTitle">Document Request Payments</h1>
            </div>
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search requests...">
            </div>
           
        </div>

        <!-- Dashboard Sections -->
        <div class="dashboard-sections" id="dashboardSections">
            <!-- Summary Cards -->
            <div class="dashboard-content">
                <div class="summary-card">
                    <div class="card-header">
                        <div class="card-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="card-title">Pending Payments</div>
                            <div class="card-value">12</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 2 from yesterday
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="card-header">
                        <div class="card-icon paid">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="card-title">Paid Today</div>
                            <div class="card-value">24</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 5 from yesterday
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="card-header">
                        <div class="card-icon amount">
                        <i class="fas fa-peso-sign"></i>
                        </div>
                        <div>
                            <div class="card-title">Total Collected</div>
                            <div class="card-value">₱1,245</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 18% from yesterday
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="card-header">
                        <div class="card-icon requests">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <div class="card-title">Total Requests</div>
                            <div class="card-value">36</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 8 from yesterday
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Types Breakdown -->
            <div class="document-types">
                <div class="section-header">
                    <h2 class="section-title">Document Type Breakdown</h2>
                </div>
                <div class="progress-container">
                    <div class="progress-item">
                        <div class="progress-label">Transcripts</div>
                        <div class="progress-bar">
                            <div class="progress-fill transcript"></div>
                        </div>
                        <div class="progress-value">65%</div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label">Diplomas</div>
                        <div class="progress-bar">
                            <div class="progress-fill diploma"></div>
                        </div>
                        <div class="progress-value">20%</div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label">Certifications</div>
                        <div class="progress-bar">
                            <div class="progress-fill certification"></div>
                        </div>
                        <div class="progress-value">10%</div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label">Other</div>
                        <div class="progress-bar">
                            <div class="progress-fill other"></div>
                        </div>
                        <div class="progress-value">5%</div>
                    </div>
                </div>
            </div>

            <!-- Recent Requests Table -->
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">Recent Document Requests</h2>
                    <a href="#" class="view-all">
                        View All
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student</th>
                            <th>Document Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="request-id">#DOC-2023-1025</td>
                            <td>Michael Johnson</td>
                            <td>Official Transcript</td>
                            <td>₱15.00</td>
                            <td><span class="status-badge status-paid">Paid</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-receipt"></i></button>
                                <button class="action-btn"><i class="fas fa-print"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1024</td>
                            <td>Sarah Williams</td>
                            <td>Diploma Copy</td>
                            <td>₱25.00</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn" onclick="openPaymentModal()"><i class="fas fa-credit-card"></i></button>
                                <button class="action-btn"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1023</td>
                            <td>Robert Brown</td>
                            <td>Enrollment Verification</td>
                            <td>₱10.00</td>
                            <td><span class="status-badge status-paid">Paid</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-receipt"></i></button>
                                <button class="action-btn"><i class="fas fa-print"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1022</td>
                            <td>Emily Davis</td>
                            <td>Course Completion Cert</td>
                            <td>₱20.00</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-redo"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1021</td>
                            <td>David Wilson</td>
                            <td>Official Transcript</td>
                            <td>₱15.00</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn" onclick="openPaymentModal()"><i class="fas fa-credit-card"></i></button>
                                <button class="action-btn"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Process Payment UI -->
        <div id="processPaymentUI" class="feature-ui">
            <div class="payment-processor">
                <div class="section-header">
                    <h2 class="section-title">Process Document Payment</h2>
                </div>
                
                <div class="payment-form">
                    <div class="form-row">
                        <label class="form-label">Request ID</label>
                        <input type="text" class="form-control" placeholder="Enter request ID">
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">Student Name</label>
                        <input type="text" class="form-control" placeholder="Search student">
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">Document Type</label>
                        <select class="form-control">
                            <option>Select document type</option>
                            <option>Official Transcript</option>
                            <option>Diploma Copy</option>
                            <option>Enrollment Verification</option>
                            <option>Course Completion Certificate</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">Amount Due</label>
                        <input type="text" class="form-control" value="$25.00" readonly>
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">Amount Received</label>
                        <input type="text" class="form-control" placeholder="Enter amount">
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">Change</label>
                        <input type="text" class="form-control" value="$0.00" readonly>
                    </div>
                </div>
                
               
                
                <button class="submit-payment">
                    <i class="fas fa-check-circle"></i> Process Payment
                </button>
            </div>
        </div>

        <!-- Document Requests UI -->
        <div id="documentRequestsUI" class="feature-ui">
            <div class="document-requests">
                <div class="section-header">
                    <h2 class="section-title">Document Requests</h2>
                   
                </div>
                
                <div class="request-filters">
                    <select class="filter-select">
                        <option>All Statuses</option>
                        <option>Pending</option>
                        <option>Paid</option>
                        <option>Cancelled</option>
                    </select>
                    
                    <select class="filter-select">
                        <option>All Document Types</option>
                        <option>Transcript</option>
                        <option>Diploma</option>
                        <option>Certificate</option>
                    </select>
                    
                    <input type="date" class="filter-select" placeholder="Filter by date">
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student</th>
                            <th>Document Type</th>
                            <th>Date Requested</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="request-id">#DOC-2023-1030</td>
                            <td>Jennifer Lopez</td>
                            <td>Official Transcript</td>
                            <td>05/20/2023</td>
                            <td>₱15.00</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1029</td>
                            <td>Thomas Anderson</td>
                            <td>Diploma Copy</td>
                            <td>05/19/2023</td>
                            <td>₱25.00</td>
                            <td><span class="status-badge status-paid">Paid</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-receipt"></i></button>
                                <button class="action-btn"><i class="fas fa-print"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="request-id">#DOC-2023-1028</td>
                            <td>Lisa Ray</td>
                            <td>Enrollment Verification</td>
                            <td>05/18/2023</td>
                            <td>₱10.00</td>
                            <td><span class="status-badge status-paid">Paid</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-receipt"></i></button>
                                <button class="action-btn"><i class="fas fa-print"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transactions UI -->
        <div id="transactionsUI" class="feature-ui">
            <div class="transactions-list">
                <div class="section-header">
                    <h2 class="section-title">Recent Transactions</h2>
                    <div class="search-bar" style="width: 300px;">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search transactions...">
                    </div>
                </div>
                
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div><strong>#DOC-2023-1027</strong> - Official Transcript</div>
                        <div>Michael Johnson - 05/17/2023 10:30 AM</div>
                    </div>
                    <div class="transaction-amount">
                    ₱15.00
                    </div>
                </div>
                
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div><strong>#DOC-2023-1026</strong> - Diploma Copy</div>
                        <div>Sarah Williams - 05/16/2023 2:15 PM</div>
                    </div>
                    <div class="transaction-amount">
                    ₱25.00
                    </div>
                </div>
                
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div><strong>#DOC-2023-1025</strong> - Enrollment Verification</div>
                        <div>Robert Brown - 05/15/2023 9:45 AM</div>
                    </div>
                    <div class="transaction-amount">
                    ₱10.00
                    </div>
                </div>
                
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div><strong>#DOC-2023-1024</strong> - Course Completion Cert</div>
                        <div>Emily Davis - 05/14/2023 11:20 AM</div>
                    </div>
                    <div class="transaction-amount">
                    ₱20.00
                    </div>
                </div>
                
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div><strong>#DOC-2023-1023</strong> - Official Transcript</div>
                        <div>David Wilson - 05/13/2023 3:30 PM</div>
                    </div>
                    <div class="transaction-amount">
                    ₱15.00
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Summary UI -->
        <div id="dailySummaryUI" class="feature-ui">
            <div class="reports-container">
                <div class="section-header">
                    <h2 class="section-title">Daily Summary Report</h2>
                    <div class="date-range-picker">
                        <input type="date" class="filter-select">
                        <span>to</span>
                        <input type="date" class="filter-select">
                    </div>
                </div>
                
                <div class="report-tabs">
                    <div class="report-tab active">Summary</div>
                    <div class="report-tab">By Document Type</div>
                   
                </div>
                
                <div class="report-content active">
                    <div class="chart-placeholder">
                        [Daily Summary Chart]
                    </div>
                    
                    <div class="dashboard-content">
                        <div class="summary-card">
                            <div class="card-header">
                                <div class="card-icon amount">
                                    <i class="fas fa-peso-sign"></i>
                                </div>
                                <div>
                                    <div class="card-title">Total Collected</div>
                                    <div class="card-value">₱1,245</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="card-header">
                                <div class="card-icon requests">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <div class="card-title">Total Requests</div>
                                    <div class="card-value">36</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="card-header">
                                <div class="card-icon paid">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <div class="card-title">Completed</div>
                                    <div class="card-value">24</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="card-header">
                                <div class="card-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="card-title">Pending</div>
                                    <div class="card-value">12</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Records UI -->
        <div id="exportRecordsUI" class="feature-ui">
            <div class="reports-container">
                <div class="section-header">
                    <h2 class="section-title">Export Records</h2>
                </div>
                
                <div class="form-row">
                    <label class="form-label">Date Range</label>
                    <div style="display: flex; gap: 1rem;">
                        <input type="date" class="form-control">
                        <span style="align-self: center;">to</span>
                        <input type="date" class="form-control">
                    </div>
                </div>
                
                <div class="form-row">
                    <label class="form-label">Report Type</label>
                    <select class="form-control">
                        <option>Transaction Records</option>
                        <option>Document Requests</option>
                        <option>Payment Summary</option>
                        <option>Daily Totals</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <label class="form-label">File Format</label>
                    <div class="payment-methods">
                        <div class="method-card selected">
                            <div class="method-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div>Excel (.xlsx)</div>
                        </div>
                        <div class="method-card">
                            <div class="method-icon">
                                <i class="fas fa-file-csv"></i>
                            </div>
                            <div>CSV (.csv)</div>
                        </div>
                        <div class="method-card">
                            <div class="method-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div>PDF (.pdf)</div>
                        </div>
                    </div>
                </div>
                
                <button class="submit-payment" style="margin-top: 1.5rem;">
                    <i class="fas fa-download"></i> Export Records
                </button>
            </div>
        </div>
    </main>

    <!-- Payment Modal -->
    <div class="payment-modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Process Document Payment</h3>
                <button class="close-btn" onclick="closePaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Request ID</label>
                    <input type="text" class="form-input" value="#DOC-2023-1024" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Student Name</label>
                    <input type="text" class="form-input" value="Sarah Williams" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Document Type</label>
                    <input type="text" class="form-input" value="Diploma Copy" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount Due</label>
                    <input type="text" class="form-input" value="₱25.00" readonly>
                </div>
                
              
                <div class="form-group">
                    <label class="form-label">Amount Received</label>
                    <input type="text" class="form-input" placeholder="Enter amount received">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closePaymentModal()">Cancel</button>
                <button class="btn btn-primary">Process Payment</button>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.querySelector('.toggle-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        // Payment modal functions
        function openPaymentModal() {
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        // Select payment option
       
        // Simulate loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.summary-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Set dashboard as default view
            showSection('dashboard');
        });

        // Navigation between sections
        function showSection(sectionId) {
            // Hide all feature UIs and show dashboard sections by default
            document.querySelectorAll('.feature-ui').forEach(ui => {
                ui.style.display = 'none';
            });
            
            // Update page title
            const pageTitle = document.getElementById('pageTitle');
            
            // Handle each section
            if (sectionId === 'dashboard') {
                // Show dashboard
                document.getElementById('dashboardSections').classList.remove('hidden');
                pageTitle.textContent = 'Document Request Payments';
            } else {
                // Hide dashboard and show the selected feature
                document.getElementById('dashboardSections').classList.add('hidden');
                
                if (sectionId === 'processPayment') {
                    document.getElementById('processPaymentUI').style.display = 'block';
                    pageTitle.textContent = 'Process Payment';
                } else if (sectionId === 'documentRequests') {
                    document.getElementById('documentRequestsUI').style.display = 'block';
                    pageTitle.textContent = 'Document Requests';
                } else if (sectionId === 'transactions') {
                    document.getElementById('transactionsUI').style.display = 'block';
                    pageTitle.textContent = 'Transactions';
                } else if (sectionId === 'dailySummary') {
                    document.getElementById('dailySummaryUI').style.display = 'block';
                    pageTitle.textContent = 'Daily Summary';
                } else if (sectionId === 'exportRecords') {
                    document.getElementById('exportRecordsUI').style.display = 'block';
                    pageTitle.textContent = 'Export Records';
                }
            }
            
            // Update active menu item
            document.querySelectorAll('.menu-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-section') === sectionId) {
                    link.classList.add('active');
                }
            });
        }

        // Add click event listeners to menu items
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                showSection(section);
            });
        });
        
        // Report tab switching
        document.querySelectorAll('.report-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.report-tab').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // You can add logic here to show different report content
                // based on which tab was clicked
            });
        });
    </script>
</body>
</html>