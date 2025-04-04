<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8B0000;
            --primary-light: #A52A2A;
            --secondary: #D4AF37;
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

        .sidebar.collapsed {
            width: 80px;
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

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--light);
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .toggle-btn:hover {
            opacity: 1;
        }

        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
            margin: 0 auto;
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
            letter-spacing: 0.5px;
        }

        .sidebar.collapsed .menu-title {
            display: none;
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
            border-radius: 0 4px 4px 0;
        }

        .menu-icon {
            font-size: 20px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
            color: var(--secondary);
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .menu-icon {
            margin-right: 0;
            font-size: 22px;
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

        .sidebar.collapsed .user-details {
            display: none;
        }

        .sidebar.collapsed .user-profile {
            justify-content: center;
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
            margin-bottom: 2px;
            color: var(--light);
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            width: 300px;
            border: 1px solid var(--gray);
        }

        .search-bar input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 4px 8px;
            font-size: 14px;
            background: transparent;
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

        .notification-icon, .message-icon {
            font-size: 20px;
            color: var(--gray-dark);
            position: relative;
            cursor: pointer;
            transition: color 0.2s;
        }

        .notification-icon:hover, .message-icon:hover {
            color: var(--primary);
        }

        .notification-badge, .message-badge {
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

        .message-badge {
            background: var(--secondary);
            color: var(--primary);
        }

        .dashboard-content {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .analytics-card {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 3px solid var(--primary);
        }

        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            background: rgba(139, 0, 0, 0.1);
            color: var(--primary);
        }

        .card-icon.pending {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .card-icon.processed {
            background: rgba(139, 0, 0, 0.1);
            color: var(--primary);
        }

        .card-icon.completed {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .card-icon.rejected {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger);
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

        .card-change.negative {
            color: var(--danger);
        }

        .progress-card {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s ease;
            border-top: 3px solid var(--secondary);
            position: relative;
        }

        .progress-card:hover {
            transform: translateY(-5px);
        }

        .progress-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
        }

        .circular-progress {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-light);
        }

        .circular-progress::before {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--light);
        }

        .progress-value {
            position: relative;
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
        }

        .progress-number {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
            z-index: 2;
        }

        .progress-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .progress-subtitle {
            font-size: 12px;
            color: var(--gray-dark);
        }

        .recent-requests {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
            border-top: 3px solid var(--primary);
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
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s;
        }

        .view-all:hover {
            color: var(--secondary);
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
            letter-spacing: 0.5px;
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

        .status-processing {
            background: rgba(139, 0, 0, 0.1);
            color: var(--primary);
        }

        .status-completed {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .status-rejected {
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
            transition: color 0.2s;
        }

        .action-btn:hover {
            color: var(--primary);
        }

        .progress-svg {
            position: absolute;
            width: 120px;
            height: 120px;
            transform: rotate(-90deg);
        }

        .progress-circle {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
            stroke-dasharray: 314;
            stroke-dashoffset: 314;
            animation: progress-animation 1.5s ease-in-out forwards;
        }

        .progress-pending {
            stroke: var(--warning);
        }

        .progress-processing {
            stroke: var(--primary);
        }

        .progress-completed {
            stroke: var(--success);
        }

        .progress-rejected {
            stroke: var(--danger);
        }

        @keyframes progress-animation {
            to {
                stroke-dashoffset: var(--dash-offset);
            }
        }

        @media (max-width: 1200px) {
            .sidebar {
                width: 80px;
            }

            .sidebar.collapsed {
                width: 0;
                overflow: hidden;
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

            .user-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
        .empty-state {
            padding: 2rem;
            text-align: center;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-pending { background-color: #FEF3C7; color: #92400E; }
        .status-processing { background-color: #DBEAFE; color: #1E40AF; }
        .status-completed { background-color: #D1FAE5; color: #065F46; }
        .status-unknown { background-color: #F3F4F6; color: #6B7280; }

        /* New styles for feature UIs */
        .feature-ui {
            display: none;
            margin-top: 1.5rem;
        }
        
        .feature-ui.active {
            display: block;
        }
        
        .document-actions, .student-actions, .report-actions {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }
        
        .action-btn.primary {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-btn.secondary {
            background: var(--gray);
            color: var(--dark);
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 1rem;
        }
        
        .filter-tab {
            padding: 8px 16px;
            background: var(--gray);
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .filter-tab.active {
            background: var(--primary);
            color: white;
        }
        
        .filter-options {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-select, .filter-date {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--gray);
        }
        
        .settings-tabs {
            display: flex;
            gap: 2rem;
        }
        
        .settings-sidebar {
            width: 250px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .settings-tab {
            padding: 12px 16px;
            text-align: left;
            border: none;
            background: var(--gray);
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .settings-tab.active {
            background: var(--primary);
            color: white;
        }
        
        .settings-content {
            flex-grow: 1;
        }
        
        .settings-panel {
            display: none;
            padding: 1rem;
            background: white;
            border-radius: 8px;
        }
        
        .settings-panel.active {
            display: block;
        }
        
        .setting-item {
            margin-bottom: 1.5rem;
        }
        
        .setting-item label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .setting-item input, .setting-item select {
            width: 100%;
            max-width: 400px;
            padding: 8px 12px;
            border: 1px solid var(--gray);
            border-radius: 6px;
        }
        
        .report-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 1.5rem;
        }
        
        .report-tab {
            padding: 8px 16px;
            background: var(--gray);
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .report-tab.active {
            background: var(--primary);
            color: white;
        }
        
        .report-charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .chart-container {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .chart-container h4 {
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .date-range-picker {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Dashboard sections that need to be hidden */
        .dashboard-sections {
            display: block;
        }
        
        .dashboard-sections.hidden {
            display: none;
        }

        /* Import Button Styles */
        .import-btn {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 10px;
            transition: background-color 0.2s;
        }

        .import-btn:hover {
            background: var(--primary-light);
        }

        .import-modal {
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

        .import-modal-content {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            width: 500px;
            max-width: 90%;
        }

        .import-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .import-modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }

        .import-modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-dark);
        }

        .import-modal-body {
            margin: 1.5rem 0;
        }

        .file-upload {
            border: 2px dashed var(--gray);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: block;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            color: var(--gray-dark);
        }

        .file-upload-hint {
            font-size: 0.875rem;
            color: var(--gray-dark);
            margin-top: 0.5rem;
        }

        .import-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-university"></i>
                </div>
                <span class="logo-text">Registrar Panel</span>
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
                    <a href="#" class="menu-link" data-section="documentRequests">
                        <i class="fas fa-file-alt menu-icon"></i>
                        <span class="menu-text">Document Requests</span>
                        <span class="menu-badge">24</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="studentRecords">
                        <i class="fas fa-users menu-icon"></i>
                        <span class="menu-text">Student Records</span>
                    </a>
                </li>
            </ul>
            <h3 class="menu-title">Administration</h3>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="settings">
                        <i class="fas fa-cog menu-icon"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="reports">
                        <i class="fas fa-chart-bar menu-icon"></i>
                        <span class="menu-text">Reports</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" data-section="notifications">
                        <i class="fas fa-bell menu-icon"></i>
                        <span class="menu-text">Notifications</span>
                        <span class="menu-badge">5</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User" class="avatar">
                <div class="user-details">
                    <div class="user-name">Sarah Johnson</div>
                    <div class="user-role">Registrar Admin</div>
                </div>
            </div>
        </div>
    </aside>
    <main class="main-content">
        <div class="header">
            <div class="page-title">
                <h1 id="pageTitle">Document Request Dashboard</h1>
            </div>
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search requests...">
            </div>
        </div>

        <!-- Dashboard Sections -->
        <div class="dashboard-sections" id="dashboardSections">
            <div class="dashboard-content">
                <div class="analytics-card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Pending Requests</div>
                            <div class="card-value" id="pendingRequests">0</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 0% from last week
                            </div>
                        </div>
                        <div class="card-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="analytics-card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">In Process</div>
                            <div class="card-value" id="inProcessRequests">0</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 0% from last week
                            </div>
                        </div>
                        <div class="card-icon processed">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="analytics-card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Completed</div>
                            <div class="card-value" id="completedRequests">0</div>
                            <div class="card-change positive">
                                <i class="fas fa-arrow-up"></i> 0% from last week
                            </div>
                        </div>
                        <div class="card-icon completed">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="analytics-card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Rejected</div>
                            <div class="card-value" id="rejectedRequests">0</div>
                            <div class="card-change negative">
                                <i class="fas fa-arrow-down"></i> 0% from last week
                            </div>
                        </div>
                        <div class="card-icon rejected">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="progress-card">
                    <div class="progress-container">
                        <svg class="progress-svg">
                            <circle class="progress-circle progress-pending" cx="60" cy="60" r="50" style="--dash-offset: 188.4;"></circle>
                        </svg>
                        <div class="circular-progress">
                            <div class="progress-number" id="pendingRequestsProgress">0</div>
                        </div>
                    </div>
                    <h3 class="progress-title">Pending Requests</h3>
                    <p class="progress-subtitle">Current active requests</p>
                </div>
                <div class="progress-card">
                    <div class="progress-container">
                        <svg class="progress-svg">
                            <circle class="progress-circle progress-processing" cx="60" cy="60" r="50" style="--dash-offset: 125.6;"></circle>
                        </svg>
                        <div class="circular-progress">
                            <div class="progress-number" id="inProcessRequestsProgress">0</div>
                        </div>
                    </div>
                    <h3 class="progress-title">In Process</h3>
                    <p class="progress-subtitle">Being processed now</p>
                </div>
                <div class="progress-card">
                    <div class="progress-container">
                        <svg class="progress-svg">
                            <circle class="progress-circle progress-completed" cx="60" cy="60" r="50" style="--dash-offset: 219.8;"></circle>
                        </svg>
                        <div class="circular-progress">
                            <div class="progress-number" id="completedRequestsProgress">0</div>
                        </div>
                    </div>
                    <h3 class="progress-title">Completed</h3>
                    <p class="progress-subtitle">This month</p>
                </div>
                <div class="progress-card">
                    <div class="progress-container">
                        <svg class="progress-svg">
                            <circle class="progress-circle progress-rejected" cx="60" cy="60" r="50" style="--dash-offset: 282.6;"></circle>
                        </svg>
                        <div class="circular-progress">
                            <div class="progress-number" id="rejectedRequestsProgress">0</div>
                        </div>
                    </div>
                    <h3 class="progress-title">Rejected</h3>
                    <p class="progress-subtitle">This month</p>
                </div>
            </div>
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">Recent Document Requests</h2>
                    <a href="#" class="view-all">
                        View All
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <table id="requestTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Document Type</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($requests) && $requests->count() > 0)
                            @foreach($requests as $request)
                                <tr>
                                    <td class="request-id">{{ $request->student_id }}</td>
                                    <td>
                                        @if(isset($request->first_name) && isset($request->last_name))
                                            {{ $request->first_name }} {{ $request->last_name }}
                                        @elseif(isset($request->personalInfo))
                                            {{ $request->personalInfo->first_name }} {{ $request->personalInfo->last_name }}
                                        @else
                                            Name Not Available
                                        @endif
                                    </td>
                                    <td>{{ $request->document_type ?? 'N/A' }}</td>
                                    <td>{{ $request->date_requested ? $request->date_requested->format('m/d/Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ isset($request->status) ? strtolower($request->status) : 'unknown' }}">
                                            {{ $request->status ?? 'Status Unknown' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="font-medium">No document requests found</p>
                                        @if(!isset($requests))
                                            <p class="text-sm">(Request data not loaded)</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Document Requests UI -->
        <div id="documentRequestsUI" class="feature-ui">
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">Document Requests Management</h2>
                </div>
                <div class="document-actions">
                    <div class="search-bar" style="width: 300px; margin-right: auto;">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search documents...">
                    </div>
                </div>
                <div class="document-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active">All Requests</button>
                        <button class="filter-tab">Pending</button>
                        <button class="filter-tab">In Process</button>
                        <button class="filter-tab">Completed</button>
                        <button class="filter-tab">Rejected</button>
                    </div>
                    <div class="filter-options">
                        <select class="filter-select">
                            <option>All Document Types</option>
                            <option>Transcript</option>
                            <option>Diploma</option>
                            <option>Certificate</option>
                        </select>
                        <input type="date" class="filter-date" placeholder="Filter by date">
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student</th>
                            <th>Document Type</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DR-2023-001</td>
                            <td>John Smith</td>
                            <td>Official Transcript</td>
                            <td>05/15/2023</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-print"></i></button>
                                <button class="action-btn"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>DR-2023-002</td>
                            <td>Emily Johnson</td>
                            <td>Diploma Copy</td>
                            <td>05/18/2023</td>
                            <td><span class="status-badge status-processing">Processing</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student Records UI -->
        <div id="studentRecordsUI" class="feature-ui">
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">Student Records Management</h2>
                    <div class="student-actions">
                        <button class="import-btn" onclick="openImportModal()">
                            <i class="fas fa-file-import"></i> Import Records
                        </button>
                        <div class="search-bar" style="width: 300px; margin-left: auto;">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" placeholder="Search students...">
                        </div>
                    </div>
                </div>
                <div class="student-filters">
                    <div class="filter-options">
                        <select class="filter-select">
                            <option>All Programs</option>
                            <option>Computer Science</option>
                            <option>Business Administration</option>
                            <option>Engineering</option>
                        </select>
                        <select class="filter-select">
                            <option>All Years</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                        </select>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Year Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2020-001</td>
                            <td>Michael Brown</td>
                            <td>Computer Science</td>
                            <td>4th Year</td>
                            <td><span class="status-badge status-completed">Active</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                                <button class="action-btn"><i class="fas fa-file-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2021-045</td>
                            <td>Sarah Williams</td>
                            <td>Business Administration</td>
                            <td>3rd Year</td>
                            <td><span class="status-badge status-processing">On Leave</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                                <button class="action-btn"><i class="fas fa-file-alt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Import Records Modal -->
        <div id="importModal" class="import-modal">
            <div class="import-modal-content">
                <div class="import-modal-header">
                    <h3 class="import-modal-title">Import Student Records</h3>
                    <button class="import-modal-close" onclick="closeImportModal()">&times;</button>
                </div>
                <div class="import-modal-body">
                    <div class="file-upload">
                        <input type="file" id="fileInput" class="file-upload-input" accept=".csv, .xlsx, .xls">
                        <label for="fileInput" class="file-upload-label">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="file-upload-text">Click to upload or drag and drop</div>
                            <div class="file-upload-hint">CSV, XLSX (Max. 10MB)</div>
                        </label>
                    </div>
                    <div id="fileInfo" style="display: none;">
                        <p>Selected file: <span id="fileName"></span></p>
                    </div>
                </div>
                <div class="import-modal-footer">
                    <button class="btn btn-secondary" onclick="closeImportModal()">Cancel</button>
                    <button class="btn btn-primary" onclick="importFile()">Import</button>
                </div>
            </div>
        </div>

        <!-- Settings UI -->
        <div id="settingsUI" class="feature-ui">
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">System Settings</h2>
                </div>
                <div class="settings-tabs">
                    <div class="settings-sidebar">
                        <button class="settings-tab active" data-tab="general">
                            <i class="fas fa-cog"></i> General Settings
                        </button>
                        
                        <button class="settings-tab" data-tab="notifications">
                            <i class="fas fa-bell"></i> Notifications
                        </button>
                    </div>
                    <div class="settings-content">
                        <div id="generalSettings" class="settings-panel active">
                            <h3>General System Settings</h3>
                            <div class="setting-item">
                                <label>Institution Name</label>
                                <input type="text" value="University of Example">
                            </div>
                            <div class="setting-item">
                                <label>System Timezone</label>
                                <select>
                                    <option>(UTC+00:00) London</option>
                                    <option selected>(UTC+08:00) Manila</option>
                                    <option>(UTC-05:00) New York</option>
                                </select>
                            </div>
                            <div class="setting-item">
                                <label>Date Format</label>
                                <select>
                                    <option>MM/DD/YYYY</option>
                                    <option selected>DD/MM/YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>
                            <button class="action-btn primary">Save Settings</button>
                        </div>
                       
                        <div id="notificationSettings" class="settings-panel">
                            <h3>Notification Preferences</h3>
                            <p>Notification settings would appear here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports UI -->
        <div id="reportsUI" class="feature-ui">
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">System Reports</h2>
                    <div class="report-actions">
                        <button class="action-btn primary">
                            <i class="fas fa-file-export"></i> Export Report
                        </button>
                        <div class="date-range-picker">
                            <input type="date" class="filter-date">
                            <span>to</span>
                            <input type="date" class="filter-date">
                        </div>
                    </div>
                </div>
                <div class="report-tabs">
                    <button class="report-tab active">Document Requests</button>
                    <button class="report-tab">Student Records</button>
                    <button class="report-tab">User Activity</button>
                </div>
                <div class="report-content">
                    <div class="report-filters">
                        <select class="filter-select">
                            <option>All Document Types</option>
                            <option>Transcript</option>
                            <option>Diploma</option>
                        </select>
                        <select class="filter-select">
                            <option>All Statuses</option>
                            <option>Pending</option>
                            <option>Completed</option>
                        </select>
                    </div>
                    <div class="report-charts">
                        <div class="chart-container">
                            <h4>Requests by Month</h4>
                            <div class="chart-placeholder" style="height: 300px; background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                [Chart: Document Requests by Month]
                            </div>
                        </div>
                        <div class="chart-container">
                            <h4>Requests by Type</h4>
                            <div class="chart-placeholder" style="height: 300px; background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                [Chart: Document Requests by Type]
                            </div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Report</th>
                                <th>Period</th>
                                <th>Generated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Document Requests - May 2023</td>
                                <td>05/01/2023 - 05/31/2023</td>
                                <td>06/02/2023</td>
                                <td>
                                    <button class="action-btn"><i class="fas fa-download"></i></button>
                                    <button class="action-btn"><i class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Student Records - Spring 2023</td>
                                <td>01/01/2023 - 05/31/2023</td>
                                <td>06/05/2023</td>
                                <td>
                                    <button class="action-btn"><i class="fas fa-download"></i></button>
                                    <button class="action-btn"><i class="fas fa-print"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notifications UI -->
        <div id="notificationsUI" class="feature-ui">
            <div class="recent-requests">
                <div class="section-header">
                    <h2 class="section-title">Notifications</h2>
                    <button class="action-btn secondary">
                        <i class="fas fa-check-circle"></i> Mark All as Read
                    </button>
                </div>
                <div class="notifications-list">
                    <div class="notification-item unread">
                        <div class="notification-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">New Document Request</div>
                            <div class="notification-message">John Smith requested an official transcript</div>
                            <div class="notification-time">2 hours ago</div>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Student Record Updated</div>
                            <div class="notification-message">Sarah Williams changed her program to Business Administration</div>
                            <div class="notification-time">1 day ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.querySelector('.toggle-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
        function setCircularProgress(selector, percent) {
            const circle = document.querySelector(selector);
            const radius = 50;
            const circumference = 2 * Math.PI * radius;
            const offset = circumference - (percent / 100) * circumference;
            circle.style.strokeDashoffset = offset;
        }
        setCircularProgress('.progress-pending', 60);
        setCircularProgress('.progress-processing', 40);
        setCircularProgress('.progress-completed', 70);
        setCircularProgress('.progress-rejected', 10);
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.analytics-card, .progress-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            fetchData();
        });
        async function fetchData() {
            try {
                const response = await fetch('fetch_requests.php');
                const data = await response.json();
                populateTable(data.requests);
                updateAnalytics(data.analytics);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }
        function populateTable(requests) {
            const tableBody = document.querySelector('#requestTable tbody');
            tableBody.innerHTML = '';
            requests.forEach(request => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="request-id">${request.request_id}</td>
                    <td>${request.first_name} ${request.last_name}</td>
                    <td>${request.document_type}</td>
                    <td>${request.date_requested}</td>
                    <td><span class="status-badge status-${request.status.toLowerCase()}">${request.status}</span></td>
                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
        function updateAnalytics(analytics) {
            document.getElementById('pendingRequests').textContent = analytics.pending;
            document.getElementById('inProcessRequests').textContent = analytics.processing;
            document.getElementById('completedRequests').textContent = analytics.completed;
            document.getElementById('rejectedRequests').textContent = analytics.rejected;
            document.getElementById('pendingRequestsProgress').textContent = analytics.pending;
            document.getElementById('inProcessRequestsProgress').textContent = analytics.processing;
            document.getElementById('completedRequestsProgress').textContent = analytics.completed;
            document.getElementById('rejectedRequestsProgress').textContent = analytics.rejected;
            setCircularProgress('.progress-pending', (analytics.pending / 100) * 60);
            setCircularProgress('.progress-processing', (analytics.processing / 100) * 60);
            setCircularProgress('.progress-completed', (analytics.completed / 100) * 60);
            setCircularProgress('.progress-rejected', (analytics.rejected / 100) * 60);
        }

        // Import Modal Functions
        function openImportModal() {
            document.getElementById('importModal').style.display = 'flex';
        }

        function closeImportModal() {
            document.getElementById('importModal').style.display = 'none';
            document.getElementById('fileInfo').style.display = 'none';
            document.getElementById('fileInput').value = '';
        }

        function importFile() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length === 0) {
                alert('Please select a file to import');
                return;
            }
            
            const file = fileInput.files[0];
            const fileName = file.name;
            
            // Here you would typically handle the file upload to your server
            // For this example, we'll just show a success message
            alert(`File "${fileName}" imported successfully!`);
            closeImportModal();
            
            // In a real application, you would use something like:
            /*
            const formData = new FormData();
            formData.append('file', file);
            
            fetch('/api/import/students', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('Import successful!');
                closeImportModal();
                // Optionally refresh the student records table
            })
            .catch(error => {
                alert('Error during import: ' + error.message);
            });
            */
        }

        // Handle file selection display
        document.getElementById('fileInput').addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                document.getElementById('fileName').textContent = fileName;
                document.getElementById('fileInfo').style.display = 'block';
            } else {
                document.getElementById('fileInfo').style.display = 'none';
            }
        });

        // Handle drag and drop
        const fileUpload = document.querySelector('.file-upload');
        fileUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUpload.style.borderColor = 'var(--primary)';
            fileUpload.style.backgroundColor = 'rgba(139, 0, 0, 0.05)';
        });

        fileUpload.addEventListener('dragleave', () => {
            fileUpload.style.borderColor = 'var(--gray)';
            fileUpload.style.backgroundColor = 'transparent';
        });

        fileUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUpload.style.borderColor = 'var(--gray)';
            fileUpload.style.backgroundColor = 'transparent';
            
            if (e.dataTransfer.files.length) {
                document.getElementById('fileInput').files = e.dataTransfer.files;
                const fileName = e.dataTransfer.files[0].name;
                document.getElementById('fileName').textContent = fileName;
                document.getElementById('fileInfo').style.display = 'block';
            }
        });

        // Navigation between sections
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                
                // Hide all feature UIs and show dashboard sections by default
                document.querySelectorAll('.feature-ui').forEach(ui => {
                    ui.style.display = 'none';
                });
                document.getElementById('dashboardSections').classList.remove('hidden');
                
                // Update page title
                const pageTitle = document.getElementById('pageTitle');
                
                // Handle each section
                if (section === 'dashboard') {
                    // Show dashboard
                    document.getElementById('dashboardSections').classList.remove('hidden');
                    pageTitle.textContent = 'Document Request Dashboard';
                } else {
                    // Hide dashboard and show the selected feature
                    document.getElementById('dashboardSections').classList.add('hidden');
                    
                    if (section === 'documentRequests') {
                        document.getElementById('documentRequestsUI').style.display = 'block';
                        pageTitle.textContent = 'Document Requests Management';
                    } else if (section === 'studentRecords') {
                        document.getElementById('studentRecordsUI').style.display = 'block';
                        pageTitle.textContent = 'Student Records Management';
                    } else if (section === 'settings') {
                        document.getElementById('settingsUI').style.display = 'block';
                        pageTitle.textContent = 'System Settings';
                    } else if (section === 'reports') {
                        document.getElementById('reportsUI').style.display = 'block';
                        pageTitle.textContent = 'System Reports';
                    } else if (section === 'notifications') {
                        document.getElementById('notificationsUI').style.display = 'block';
                        pageTitle.textContent = 'Notifications';
                    }
                }
                
                // Update active menu item
                document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Settings tab switching
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active tab
                document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Show corresponding panel
                document.querySelectorAll('.settings-panel').forEach(panel => {
                    panel.classList.remove('active');
                });
                document.getElementById(tabId + 'Settings').classList.add('active');
            });
        });
        
        // Report tab switching
        document.querySelectorAll('.report-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.report-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>