<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iRequest - Document Request System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-red: #8B0000;
            --gold: #FFD700;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-gray: #333333;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            overflow-x: hidden;
        }
        
        /* Navbar Styles */
        .navbar {
            background-color: var(--dark-red);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }
        
        .navbar.scrolled {
            padding: 0.5rem 5%;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        
        .logo-text {
            color: var(--gold);
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-links a:hover {
            color: var(--gold);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--gold);
            transition: var(--transition);
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .hamburger {
            display: none;
            cursor: pointer;
            color: var(--white);
            font-size: 1.5rem;
        }
        
        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('images/heros.png');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 0 5%;
            margin-top: 70px;
        }
        
        .hero-content {
            max-width: 600px;
            color: var(--white);
            animation: fadeInUp 1s ease;
        }
        
        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-title span {
            color: var(--gold);
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            background-color: var(--gold);
            color: var(--dark-red);
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            width: fit-content;
        }
        
        .cta-button:hover {
            background-color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        /* Steps Section */
        .steps-section {
            padding: 5rem 5%;
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--dark-red);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--gold);
        }
        
        .steps-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
        }
        
        .step-card {
            flex: 1;
            min-width: 250px;
            background-color: var(--light-gray);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .step-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: var(--dark-red);
        }
        
        .step-icon {
            font-size: 3rem;
            color: var(--dark-red);
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }
        
        .step-card:hover .step-icon {
            transform: scale(1.1);
        }
        
        .step-number {
            background-color: var(--gold);
            color: var(--dark-red);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .step-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark-red);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .step-description {
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        /* Promo Section */
        .promo-section {
            padding: 5rem 5%;
            background-color: var(--light-gray);
        }
        
        .promo-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        
        .promo-card {
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
        }
        
        .promo-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .promo-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .promo-card:hover .promo-img {
            transform: scale(1.05);
        }
        
        .promo-content {
            padding: 1.5rem;
            position: relative;
        }
        
        .promo-icon {
            position: absolute;
            top: -30px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: var(--dark-red);
            color: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .promo-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-red);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .promo-text {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .promo-button {
            background-color: var(--dark-red);
            color: var(--white);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .promo-button:hover {
            background-color: var(--gold);
            color: var(--dark-red);
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 5rem 5%;
            background-color: var(--white);
        }
        
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .faq-item {
            margin-bottom: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .faq-question {
            background-color: var(--light-gray);
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
            color: var(--dark-red);
            transition: var(--transition);
        }
        
        .faq-question:hover {
            background-color: #e9e9e9;
        }
        
        .faq-question i {
            transition: var(--transition);
        }
        
        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: var(--white);
        }
        
        .faq-item.active .faq-question {
            background-color: var(--dark-red);
            color: var(--white);
        }
        
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        
        .faq-item.active .faq-answer {
            padding: 1.5rem;
            max-height: 500px;
        }
        
        /* Footer */
        .footer {
            background-color: var(--dark-red);
            color: var(--white);
            padding: 4rem 5% 2rem;
        }
        
        .footer-container {
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            justify-content: space-between;
        }
        
        .footer-logo {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        
        .footer-about {
            line-height: 1.6;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .social-icon:hover {
            background-color: var(--gold);
            color: var(--dark-red);
            transform: translateY(-3px);
        }
        
        .footer-links {
            flex: 1;
            min-width: 200px;
        }
        
        .footer-title {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-list {
            list-style: none;
        }
        
        .footer-list li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-list a {
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            opacity: 0.9;
        }
        
        .footer-list a:hover {
            color: var(--gold);
            padding-left: 5px;
        }
        
        .footer-contact {
            flex: 1;
            min-width: 250px;
        }
        
        .contact-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: flex-start;
        }
        
        .contact-icon {
            color: var(--gold);
            margin-top: 3px;
        }
        
        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1500;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        .modal-content {
            background-color: var(--white);
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--dark-red);
            color: var(--white);
            border-radius: 10px 10px 0 0;
        }
        
        .modal-title {
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .close-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--white);
            transition: var(--transition);
        }
        
        .close-button:hover {
            color: var(--gold);
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .form-input.error {
            border-color: #dc3545;
        }
        
        .form-input:focus {
            border-color: var(--dark-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 2.5rem;
            color: var(--dark-red);
        }
        
        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        
        .modal-button {
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .primary-button {
            background-color: var(--dark-red);
            color: var(--white);
            border: none;
        }
        
        .primary-button:hover {
            background-color: #6d0000;
        }
        
        .secondary-button {
            background-color: transparent;
            border: 1px solid #ddd;
            color: var(--dark-gray);
        }
        
        .secondary-button:hover {
            background-color: #f5f5f5;
        }
        
        /* Track Document Modal */
        .track-input-group {
            display: flex;
            gap: 0;
        }
        
        .track-input {
            flex: 1;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            padding-left: 3rem;
        }
        
        .track-button {
            background-color: var(--gold);
            color: var(--dark-red);
            border: none;
            padding: 0 1.5rem;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .track-button:hover {
            background-color: #e6c200;
        }
        
        /* Terms Modal */
        .terms-content {
            max-height: 300px;
            overflow-y: auto;
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            border: 1px solid #eee;
        }
        
        .terms-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: var(--dark-red);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .terms-text {
            line-height: 1.6;
            margin-bottom: 1rem;
            display: flex;
            gap: 0.5rem;
        }
        
        .terms-text::before {
            content: '•';
            color: var(--dark-red);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 0.5rem;
        }
        
        .checkbox-input {
            margin-right: 0.7rem;
        }
        
        /* Request Form Modal */
        .form-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .form-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #eee;
            z-index: 1;
        }
        
        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 30%;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: bold;
            transition: var(--transition);
        }
        
        .step.active .step-number {
            background-color: var(--gold);
            color: var(--dark-red);
        }
        
        .step.completed .step-number {
            background-color: var(--dark-red);
            color: var(--white);
        }
        
        .step-label {
            font-size: 0.9rem;
            color: #999;
            transition: var(--transition);
        }
        
        .step.active .step-label {
            color: var(--dark-red);
            font-weight: 500;
        }
        
        .step.completed .step-label {
            color: var(--dark-gray);
        }
        
        /* FORM STEP FIX */
        .form-step {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .form-step.active {
            display: block;
            opacity: 1;
            animation: fadeIn 0.5s ease;
        }
        
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        
        .back-button {
            background-color: transparent;
            border: 1px solid #ddd;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .next-button {
            background-color: var(--dark-red);
            color: var(--white);
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .submit-button {
            background-color: var(--gold);
            color: var(--dark-red);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Confirmation Modal Styles */
        .summary-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .summary-section h5 {
            color: var(--dark-red);
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .summary-section p {
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }
        
        .summary-section strong {
            color: var(--dark-gray);
            min-width: 150px;
            display: inline-block;
        }
        
        /* Track Result Modal */
        .track-result {
            text-align: center;
            padding: 2rem;
        }
        
        .track-status {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .status-icon {
            font-size: 2rem;
        }
        
        .status-pending {
            color: #ffc107;
        }
        
        .status-processing {
            color: #0d6efd;
        }
        
        .status-ready {
            color: #198754;
        }
        
        .status-delivered {
            color: #0dcaf0;
        }
        
        .status-cancelled {
            color: #dc3545;
        }
        
        .track-details {
            text-align: left;
            margin-top: 2rem;
        }
        
        .detail-item {
            margin-bottom: 1rem;
            display: flex;
            gap: 0.5rem;
        }
        
        .detail-label {
            font-weight: 500;
            color: var(--dark-red);
            min-width: 120px;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: var(--dark-red);
                flex-direction: column;
                align-items: center;
                padding: 2rem 0;
                gap: 2rem;
                transition: var(--transition);
                z-index: 999;
            }
            
            .nav-links.active {
                left: 0;
            }
            
            .hamburger {
                display: block;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .steps-container, .promo-cards {
                flex-direction: column;
            }
            
            .step-card, .promo-card {
                min-width: 100%;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
        
        .doc-type-group {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 18px 18px 8px 18px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        
        .doc-type-checkbox {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f2f2f2;
        }
        
        .doc-type-checkbox:last-child {
            margin-bottom: 0;
            border-bottom: none;
        }
        
        .doc-type-checkbox input[type="checkbox"] {
            accent-color: var(--dark-red);
            width: 18px;
            height: 18px;
            margin-right: 12px;
        }
        
        .doc-type-checkbox label {
            flex: 1;
            margin-left: 8px;
            font-size: 1.08rem;
            color: #333;
            font-weight: 500;
            cursor: pointer;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            background: #f7f7f7;
            border-radius: 6px;
            padding: 2px 8px;
            gap: 4px;
            min-width: 100px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        
        .qty-btn {
            background: var(--dark-red);
            color: #fff;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .qty-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .doc-qty {
            width: 38px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 28px;
            background: #fff;
            margin: 0 2px;
            font-size: 1rem;
        }
        
        /* Floating FAQs */
        .floating-faqs-bottom {
            position: fixed;
            right: 30px;
            bottom: 30px;
            z-index: 9999;
            background: #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            border-radius: 50px;
            padding: 10px 22px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }
        
        .floating-faqs-bottom:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.22);
        }
        
        .faqs-icon-label i {
            font-size: 22px;
            color: #8B0000;
            margin-right: 10px;
        }
        
        .faqs-icon-label span {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        
        #faqsModal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.3);
            justify-content: center;
            align-items: center;
        }
        
        #faqsModal .modal-content {
            max-width: 500px;
            width: 90vw;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            padding: 30px;
        }
        
        #faqsModal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        
        #faqsModal .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #8B0000;
        }
        
        #faqsModal .close-button {
            background: none;
            border: none;
            font-size: 28px;
            color: #333;
            cursor: pointer;
        }
        
        #faqsModal .faq-container {
            margin-top: 10px;
        }
        
        #faqsModal .faq-item {
            margin-bottom: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        #faqsModal .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            cursor: pointer;
            color: #333;
        }
        
        #faqsModal .faq-answer {
            display: none;
            color: #555;
            margin-top: 8px;
            font-size: 15px;
        }
        
        #faqsModal .faq-item.active .faq-answer {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="images/logo.png" alt="iRequest Logo" class="logo-img">
            <span class="logo-text">iRequest</span>
        </div>
        
        <div class="nav-links">
            <a href="#home"><i class="fas fa-home"></i> Home</a>
            <a href="#" id="trackDocumentBtn"><i class="fas fa-search"></i> Track Document</a>
        </div>
        
        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1 class="hero-title">IBACMI <span>ODRMS</span></h1>
            <p class="hero-subtitle">Our streamlined process makes requesting transcripts, diplomas, and other academic records simple and efficient.</p>
            <button class="cta-button" id="requestDocumentBtn">
                <i class="fas fa-file-import"></i> Request a Document
            </button>
        </div>
    </section>
    
    <!-- Steps Section -->
    <section class="steps-section">
        <h2 class="section-title">How It Works</h2>
        
        <div class="steps-container">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-icon"><i class="fas fa-file-alt"></i></div>
                <h3 class="step-title">
                    <i class="fas fa-pen-fancy"></i> Submit Request
                </h3>
                <p class="step-description">Fill out our simple online form with your personal and document details.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                <h3 class="step-title">
                    <i class="fas fa-clipboard-check"></i> Review & Payment
                </h3>
                <p class="step-description">Verify your information and complete the secure payment process.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-icon"><i class="fas fa-truck"></i></div>
                <h3 class="step-title">
                    <i class="fas fa-envelope-open-text"></i> Receive Documents
                </h3>
                <p class="step-description">Get notified when your documents are ready for pickup or delivery.</p>
            </div>
        </div>
    </section>
    
    <!-- Promo Section -->
    <section class="promo-section">
        <h2 class="section-title">Why Choose iRequest</h2>
        
        <div class="promo-cards">
            <div class="promo-card">
                <div class="promo-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fast Processing" class="promo-img">
                <div class="promo-content">
                    <h3 class="promo-title">
                        <i class="fas fa-clock"></i> Fast Processing
                    </h3>
                    <p class="promo-text">Our automated system ensures your requests are processed quickly, often within 24-48 hours.</p>
                    <button class="promo-button">
                        <i class="fas fa-arrow-right"></i> Learn More
                    </button>
                </div>
            </div>
            
            <div class="promo-card">
                <div class="promo-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Secure Tracking" class="promo-img">
                <div class="promo-content">
                    <h3 class="promo-title">
                        <i class="fas fa-lock"></i> Secure Tracking
                    </h3>
                    <p class="promo-text">Monitor your document's status in real-time with our secure tracking system.</p>
                    <button class="promo-button">
                        <i class="fas fa-arrow-right"></i> Learn More
                    </button>
                </div>
            </div>
            
            <div class="promo-card">
                <div class="promo-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="24/7 Support" class="promo-img">
                <div class="promo-content">
                    <h3 class="promo-title">
                        <i class="fas fa-phone-alt"></i> 24/7 Support
                    </h3>
                    <p class="promo-text">Our dedicated support team is available around the clock to assist you.</p>
                    <button class="promo-button">
                        <i class="fas fa-arrow-right"></i> Learn More
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Floating FAQs Chat Icon -->
    <div id="floatingFaqs" class="floating-faqs-bottom">
        <div class="faqs-icon-label">
            <i class="fas fa-comments"></i>
            <span>FAQs</span>
        </div>
    </div>
    
    <!-- FAQs Modal -->
    <div class="modal" id="faqsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-question-circle"></i> Frequently Asked Questions</h3>
                <button class="close-button" id="closeFaqsModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>How long does it take to process my document request?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Processing times vary depending on the type of document requested. Typically, requests are processed within 3-5 business days. You'll receive an email notification when your documents are ready.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>What payment methods do you accept?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We accept all major credit cards, PayPal, and bank transfers. Payment is required at the time of request submission.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Can I request multiple documents at once?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, you can request multiple documents in a single request. Simply select all the documents you need during the request process.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>How do I track my document request?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>After submitting your request, you'll receive a reference number via email. Use this number to track your request status through our tracking system.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>What if I need to cancel my request?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Requests can be canceled within 24 hours of submission if processing hasn't begun. Please contact our support team immediately if you need to cancel your request.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Track Document Modal -->
    <div class="modal" id="trackDocumentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-search"></i> Track Your Document</h3>
                <button class="close-button" id="closeTrackModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="trackDocumentForm" action="{{ route('track.document') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="referenceNumber" class="form-label">
                            <i class="fas fa-hashtag"></i> Enter Reference Number
                        </label>
                        <div class="track-input-group">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" name="reference_number" id="referenceNumber" 
                                   class="form-input track-input" placeholder="e.g. REQ-2023-12345" required>
                            <button type="submit" class="track-button">
                                <i class="fas fa-search"></i> Track
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-button secondary-button" id="cancelTrackModal">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div class="modal" id="termsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-file-contract"></i> Terms and Conditions</h3>
                <button class="close-button" id="closeTermsModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    <h4 class="terms-title"><i class="fas fa-gavel"></i> Document Request Agreement</h4>
                    <p class="terms-text">
                        By proceeding with your document request, you agree to the following terms and conditions:
                    </p>
                    <p class="terms-text">
                        1. All information provided must be accurate and complete. Falsification of information may result in cancellation of your request.
                    </p>
                    <p class="terms-text">
                        2. Document processing times may vary depending on the type of document requested and current workload.
                    </p>
                    <p class="terms-text">
                        3. Fees for document requests are non-refundable once processing has begun.
                    </p>
                    <p class="terms-text">
                        4. You are responsible for ensuring the delivery address is correct. Additional fees may apply for address corrections.
                    </p>
                    <p class="terms-text">
                        5. The institution reserves the right to refuse requests that violate policies or regulations.
                    </p>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="agreeTerms" class="checkbox-input">
                    <label for="agreeTerms">I have read and agree to the terms and conditions</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button secondary-button" id="cancelTermsModal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="modal-button primary-button" id="agreeTermsBtn" disabled>
                    <i class="fas fa-check"></i> I Agree
                </button>
            </div>
        </div>
    </div>
    
    <!-- Request Form Modal -->
    <div class="modal" id="requestFormModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-file-alt"></i> Document Request Form</h3>
                <button class="close-button" id="closeRequestModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-steps">
                    <div class="step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Personal Info</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Contact Info</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Document Info</div>
                    </div>
                </div>
                
                <!-- Step 1: Personal Information -->
                <div class="form-step active" data-step="1">
                    <div class="form-group">
                        <label for="studentId" class="form-label">
                            <i class="fas fa-id-card"></i> Student ID
                        </label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="studentId" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="course" class="form-label">
                            <i class="fas fa-graduation-cap"></i> Course
                        </label>
                        <i class="fas fa-book input-icon"></i>
                        <select id="course" class="form-input" required>
                            <option value="">Select Course</option>
                            <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</option>
                            <option value="BACHELOR OF SCIENCE IN ENTREPRENEURSHIP">BACHELOR OF SCIENCE IN ENTREPRENEURSHIP</option>
                            <option value="BACHELOR OF SCIENCE IN CRIMINOLOGY">BACHELOR OF SCIENCE IN CRIMINOLOGY</option>
                            <option value="BACHELOR OF ELEMENTARY EDUCATION">BACHELOR OF ELEMENTARY EDUCATION</option>
                            <option value="BACHELOR OF EARLY CHILDHOOD EDUCATION">BACHELOR OF EARLY CHILDHOOD EDUCATION</option>
                            <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT">BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT</option>
                            <option value="BACHELOR OF PUBLIC ADMINISTRATION">BACHELOR OF PUBLIC ADMINISTRATION</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="form-label">
                            <i class="fas fa-user"></i> First Name
                        </label>
                        <i class="fas fa-signature input-icon"></i>
                        <input type="text" id="firstName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="middleName" class="form-label">
                            <i class="fas fa-user"></i> Middle Name
                        </label>
                        <i class="fas fa-signature input-icon"></i>
                        <input type="text" id="middleName" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="form-label">
                            <i class="fas fa-user"></i> Last Name
                        </label>
                        <i class="fas fa-signature input-icon"></i>
                        <input type="text" id="lastName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Year Level (Optional)
                        </label>
                        <i class="fas fa-calendar input-icon"></i>
                        <select id="yearLevel" class="form-input">
                            <option value="">Select Year Level</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="Alumni">Alumni</option>
                        </select>
                        <div id="schoolYearsGroup" style="margin-top:10px;">
                            <label for="schoolYears" class="form-label"><i class="fas fa-calendar"></i> School Years Enrolled</label>
                            <select id="schoolYears" class="form-input" multiple size="4">
                                <option value="2021-2022">2021-2022</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2024-2025">2024-2025</option>
                                <option value="2025-2026">2025-2026</option>
                            </select>
                        </div>
                        <div id="alumniSchoolYearGroup" style="display:none;margin-top:10px;">
                            <label for="alumniSchoolYear" class="form-label"><i class="fas fa-calendar"></i> School Year Graduated</label>
                            <select id="alumniSchoolYear" class="form-input">
                                <option value="">Select School Year</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2024-2025">2024-2025</option>
                                <option value="2025-2026">2025-2026</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Contact Information -->
                <div class="form-step" data-step="2">
                    <div class="form-group">
                        <label for="province" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Province
                        </label>
                        <i class="fas fa-map input-icon"></i>
                        <select id="province" class="form-input" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">
                            <i class="fas fa-city"></i> City
                        </label>
                        <i class="fas fa-building input-icon"></i>
                        <select id="city" class="form-input" required>
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay" class="form-label">
                            <i class="fas fa-map-pin"></i> Barangay
                        </label>
                        <i class="fas fa-map-marked-alt input-icon"></i>
                        <select id="barangay" class="form-input" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="form-label">
                            <i class="fas fa-mobile-alt"></i> Mobile Number
                        </label>
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" id="mobile" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <i class="fas fa-at input-icon"></i>
                        <input type="email" id="email" class="form-input" required>
                    </div>
                </div>
                
                <!-- Step 3: Document Information -->
                <div class="form-step" data-step="3">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file"></i> Select Document Type(s)
                        </label>
                        <div class="doc-type-group" id="documentTypesGroup">
                            <div class="doc-type-checkbox">
                                <input type="checkbox" id="doc-tor" name="document_types" value="Transcript of Records">
                                <label for="doc-tor">Transcript of Records</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" disabled><i class="fas fa-minus"></i></button>
                                    <input type="number" min="1" value="1" class="doc-qty" data-doc="Transcript of Records" disabled>
                                    <button type="button" class="qty-btn plus" disabled><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="doc-type-checkbox">
                                <input type="checkbox" id="doc-diploma" name="document_types" value="Diploma">
                                <label for="doc-diploma">Diploma</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" disabled><i class="fas fa-minus"></i></button>
                                    <input type="number" min="1" value="1" class="doc-qty" data-doc="Diploma" disabled>
                                    <button type="button" class="qty-btn plus" disabled><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="doc-type-checkbox">
                                <input type="checkbox" id="doc-coe" name="document_types" value="Certificate of Enrollment">
                                <label for="doc-coe">Certificate of Enrollment</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" disabled><i class="fas fa-minus"></i></button>
                                    <input type="number" min="1" value="1" class="doc-qty" data-doc="Certificate of Enrollment" disabled>
                                    <button type="button" class="qty-btn plus" disabled><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="doc-type-checkbox">
                                <input type="checkbox" id="doc-cog" name="document_types" value="Certificate of Graduation">
                                <label for="doc-cog">Certificate of Graduation</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" disabled><i class="fas fa-minus"></i></button>
                                    <input type="number" min="1" value="1" class="doc-qty" data-doc="Certificate of Graduation" disabled>
                                    <button type="button" class="qty-btn plus" disabled><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="doc-type-checkbox">
                                <input type="checkbox" id="doc-other" name="document_types" value="Other">
                                <label for="doc-other">Other</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" disabled><i class="fas fa-minus"></i></button>
                                    <input type="number" min="1" value="1" class="doc-qty" data-doc="Other" disabled>
                                    <button type="button" class="qty-btn plus" disabled><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purpose" class="form-label">
                            <i class="fas fa-bullseye"></i> Purpose of Request
                        </label>
                        <i class="fas fa-crosshairs input-icon"></i>
                        <select id="purpose" class="form-input" required>
                            <option value="">Select Purpose</option>
                            <option value="Further Studies">Further Studies</option>
                            <option value="Employment">Employment</option>
                            <option value="Scholarship">Scholarship</option>
                            <option value="Personal Record">Personal Record</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="specialInstructions" class="form-label">
                            <i class="fas fa-comment-alt"></i> Special Instructions (Optional)
                        </label>
                        <i class="fas fa-edit input-icon"></i>
                        <textarea id="specialInstructions" class="form-input" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="form-navigation">
                    <button class="modal-button back-button" id="backButton" disabled>
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button class="modal-button next-button" id="nextButton">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="modal-button submit-button" id="submitButton" style="display: none;">
                        <i class="fas fa-paper-plane"></i> Submit Request
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal" id="summaryModal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-list"></i> Review Your Request</h3>
                <button class="close-button" id="closeSummaryModal">&times;</button>
            </div>
            <div class="modal-body" id="summaryContent">
                <!-- Summary will be injected here -->
            </div>
            <div class="modal-footer">
                <button class="modal-button secondary-button" id="editRequestBtn">
                    <i class="fas fa-edit"></i> Edit Request
                </button>
                <button class="modal-button primary-button" id="finalSubmitBtn">
                    <i class="fas fa-paper-plane"></i> Submit Final Request
                </button>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <div class="footer-logo-text">
                    <img src="images/logo.png" alt="iRequest Logo" class="footer-logo-img">
                    iRequest
                </div>
                <p class="footer-about">
                    iRequest simplifies the process of requesting academic documents from educational institutions, saving you time and effort.
                </p>
                <div class="footer-social">
                    <div class="social-icon"><i class="fab fa-facebook-f"></i></div>
                    <div class="social-icon"><i class="fab fa-twitter"></i></div>
                    <div class="social-icon"><i class="fab fa-instagram"></i></div>
                    <div class="social-icon"><i class="fab fa-linkedin-in"></i></div>
                </div>
            </div>
            <div class="footer-links">
                <h3 class="footer-title">
                    <i class="fas fa-link"></i> Quick Links
                </h3>
                <ul class="footer-list">
                    <li><i class="fas fa-chevron-right"></i> <a href="#home">Home</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h3 class="footer-title">
                    <i class="fas fa-envelope"></i> Contact Us
                </h3>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt contact-icon"></i>
                    <span>123 University Ave, Academic City, Philippines</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt contact-icon"></i>
                    <span>(+63) 912 345 6789</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope contact-icon"></i>
                    <span>support@irequest.edu</span>
                </div>
            </div>
        </div>
        <div class="copyright">
            <i class="far fa-copyright"></i> 2023 iRequest. All rights reserved.
        </div>
    </footer>
    
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Mobile Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.querySelector('.nav-links');
        
        hamburger.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            hamburger.innerHTML = navLinks.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                hamburger.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
        
        // Modal Handling
        const trackDocumentBtn = document.getElementById('trackDocumentBtn');
        const trackDocumentModal = document.getElementById('trackDocumentModal');
        const closeTrackModal = document.getElementById('closeTrackModal');
        const cancelTrackModal = document.getElementById('cancelTrackModal');
        
        trackDocumentBtn.addEventListener('click', function() {
            trackDocumentModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        closeTrackModal.addEventListener('click', function() {
            trackDocumentModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        cancelTrackModal.addEventListener('click', function() {
            trackDocumentModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        // Terms Modal Handling
        const requestDocumentBtn = document.getElementById('requestDocumentBtn');
        const termsModal = document.getElementById('termsModal');
        const closeTermsModal = document.getElementById('closeTermsModal');
        const cancelTermsModal = document.getElementById('cancelTermsModal');
        const agreeTermsBtn = document.getElementById('agreeTermsBtn');
        const agreeTermsCheckbox = document.getElementById('agreeTerms');
        
        requestDocumentBtn.addEventListener('click', function() {
            termsModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        closeTermsModal.addEventListener('click', function() {
            termsModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        cancelTermsModal.addEventListener('click', function() {
            termsModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        agreeTermsCheckbox.addEventListener('change', function() {
            agreeTermsBtn.disabled = !this.checked;
        });
        
        // Request Form Modal Handling
        const requestFormModal = document.getElementById('requestFormModal');
        const closeRequestModal = document.getElementById('closeRequestModal');
        
        agreeTermsBtn.addEventListener('click', function() {
            termsModal.style.display = 'none';
            requestFormModal.style.display = 'flex';
        });
        
        closeRequestModal.addEventListener('click', function() {
            requestFormModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        // Show/hide alumni school year dropdown
        document.getElementById('yearLevel').addEventListener('change', function() {
            var alumniGroup = document.getElementById('alumniSchoolYearGroup');
            var schoolYearsGroup = document.getElementById('schoolYearsGroup');
            if (this.value) {
                schoolYearsGroup.style.display = 'block';
            } else {
                schoolYearsGroup.style.display = 'none';
                // Optionally clear selection
                Array.from(document.getElementById('schoolYears').options).forEach(opt => opt.selected = false);
            }
            if (this.value === 'Alumni') {
                alumniGroup.style.display = 'block';
            } else {
                alumniGroup.style.display = 'none';
                document.getElementById('alumniSchoolYear').value = '';
            }
        });

        // Hide school years group by default on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('schoolYearsGroup').style.display = 'none';
        });

        // Form Step Navigation
        const backButton = document.getElementById('backButton');
        const nextButton = document.getElementById('nextButton');
        const submitButton = document.getElementById('submitButton');
        const formSteps = document.querySelectorAll('.form-step');
        const stepIndicators = document.querySelectorAll('.step');
        
        let currentStep = 1;
        const totalSteps = 3;
        
        nextButton.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    // Hide current step
                    document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('active');
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
                    
                    // Show next step
                    currentStep++;
                    document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
                    
                    // Mark previous step as completed
                    document.querySelector(`.step[data-step="${currentStep-1}"]`).classList.add('completed');
                    
                    // Update button visibility
                    backButton.disabled = false;
                    if (currentStep === totalSteps) {
                        nextButton.style.display = 'none';
                        submitButton.style.display = 'block';
                    }
                }
            }
        });
        
        backButton.addEventListener('click', function() {
            // Hide current step
            document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('active');
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
            
            // Show previous step
            currentStep--;
            document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
            
            // Update button visibility
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
            if (currentStep === 1) {
                backButton.disabled = true;
            }
        });
        
        function validateStep(step) {
            // Simple validation - in a real app you'd want more robust validation
            let isValid = true;
            
            if (step === 1) {
                const requiredFields = ['studentId', 'course', 'firstName', 'lastName'];
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('error');
                    } else {
                        input.classList.remove('error');
                    }
                });
            } else if (step === 2) {
                const requiredFields = ['province', 'city', 'barangay', 'mobile', 'email'];
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('error');
                    } else {
                        input.classList.remove('error');
                    }
                    
                    // Additional email validation
                    if (field === 'email') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(input.value.trim())) {
                            isValid = false;
                            input.classList.add('error');
                        }
                    }
                });
            }
            
            return isValid;
        }
        
        // Form Submission with Confirmation Modal
        submitButton.addEventListener('click', function() {
            if (!validateStep(currentStep)) return;

            // Gather all form data
            const docTypes = [];
            document.querySelectorAll('#documentTypesGroup input[type="checkbox"]:checked').forEach(checkbox => {
                const qty = checkbox.parentElement.querySelector('.doc-qty').value;
                docTypes.push({ type: checkbox.value, quantity: qty });
            });


            // School years enrolled (multi-select)
            const schoolYearsSelect = document.getElementById('schoolYears');
            const schoolYears = Array.from(schoolYearsSelect.selectedOptions).map(opt => opt.value);
            let alumniYear = '';
            if(document.getElementById('yearLevel').value === 'Alumni') {
                alumniYear = document.getElementById('alumniSchoolYear').value;
            }

            // Build summary HTML
            let docSummary = '';
            docTypes.forEach(doc => {
                docSummary += `<p><strong>${doc.type}:</strong> ${doc.quantity} copy/copies</p>`;
            });

            let schoolYearsHtml = '';
            if (schoolYears.length > 0) {
                schoolYearsHtml = `<p><strong>School Years Enrolled:</strong> ${schoolYears.join(', ')}</p>`;
            }
            let alumniYearHtml = '';
            if (alumniYear) {
                alumniYearHtml = `<p><strong>Year Graduated:</strong> ${alumniYear}</p>`;
            }

            const summaryHtml = `
                <div class="summary-section">
                    <h5><i class="fas fa-user"></i> Personal Information</h5>
                    <p><strong>Student ID:</strong> ${document.getElementById('studentId').value}</p>
                    <p><strong>Name:</strong> ${document.getElementById('firstName').value} ${document.getElementById('middleName').value} ${document.getElementById('lastName').value}</p>
                    <p><strong>Course:</strong> ${document.getElementById('course').value}</p>
                    <p><strong>Year Level:</strong> ${document.getElementById('yearLevel').value}</p>
                    ${schoolYearsHtml}
                    ${alumniYearHtml}
                </div>
                <div class="summary-section">
                    <h5><i class="fas fa-address-book"></i> Contact Information</h5>
                    <p><strong>Address:</strong> ${document.getElementById('barangay').value}, ${document.getElementById('city').value}, ${document.getElementById('province').value}</p>
                    <p><strong>Mobile:</strong> ${document.getElementById('mobile').value}</p>
                    <p><strong>Email:</strong> ${document.getElementById('email').value}</p>
                </div>
                <div class="summary-section">
                    <h5><i class="fas fa-file-alt"></i> Document Information</h5>
                    ${docSummary}
                    <p><strong>Purpose:</strong> ${document.getElementById('purpose').value}</p>
                    ${document.getElementById('specialInstructions').value ? `<p><strong>Special Instructions:</strong> ${document.getElementById('specialInstructions').value}</p>` : ''}
                </div>
            `;

            document.getElementById('summaryContent').innerHTML = summaryHtml;
            document.getElementById('summaryModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        // Edit Request button
        document.getElementById('editRequestBtn').addEventListener('click', function() {
            document.getElementById('summaryModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        // Final Submit button
        document.getElementById('finalSubmitBtn').addEventListener('click', async function() {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            // Gather all form data again
            const docTypes = [];
            document.querySelectorAll('#documentTypesGroup input[type="checkbox"]:checked').forEach(checkbox => {
                const qty = checkbox.parentElement.querySelector('.doc-qty').value;
                docTypes.push({ type: checkbox.value, quantity: qty });
            });

            try {
                const response = await fetch('/submit-request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        student_id: document.getElementById('studentId').value,
                        course: document.getElementById('course').value,
                        first_name: document.getElementById('firstName').value,
                        middle_name: document.getElementById('middleName').value,
                        last_name: document.getElementById('lastName').value,
                        year_level: document.getElementById('yearLevel').value,
                        school_years: Array.from(document.getElementById('schoolYears').selectedOptions).map(opt => opt.value),
                        alumni_school_year: (document.getElementById('yearLevel').value === 'Alumni') ? document.getElementById('alumniSchoolYear').value : '',
                        province: document.getElementById('province').value,
                        city: document.getElementById('city').value,
                        barangay: document.getElementById('barangay').value,
                        mobile: document.getElementById('mobile').value,
                        email: document.getElementById('email').value,
                        document_types: docTypes,
                        purpose: document.getElementById('purpose').value,
                        special_instructions: document.getElementById('specialInstructions').value
                    })
                });

                let resultText = await response.text();
                let errorMessage = "Submission failed";
                try {
                    // Try to parse JSON error message if available
                    const json = JSON.parse(resultText);
                    if (json && json.message) {
                        errorMessage = json.message;
                    }
                } catch (e) {
                    // Not JSON, fallback to text
                    if (resultText) errorMessage = resultText;
                }

                document.getElementById('summaryModal').style.display = 'none';
                requestFormModal.style.display = 'none';
                document.body.style.overflow = 'auto';

                if (response.ok) {
                    Swal.fire({
                        title: "Success!",
                        text: "Your request has been submitted successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: errorMessage,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: "Error!",
                    text: error.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });

        // Close summary modal with X
        document.getElementById('closeSummaryModal').addEventListener('click', function() {
            document.getElementById('summaryModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        // PSGC API base URL
        const PSGC_API = "https://psgc.gitlab.io/api";

        // Elements
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');

        // Helper: Show loading or error
        function setSelectLoading(select, message = 'Loading...') {
            select.innerHTML = `<option value="">${message}</option>`;
            select.disabled = true;
        }
        function setSelectError(select, message = 'Failed to load') {
            select.innerHTML = `<option value="">${message}</option>`;
            select.disabled = true;
        }
        function setSelectReady(select) {
            select.disabled = false;
        }

        // Fetch and populate provinces
        setSelectLoading(provinceSelect);
        fetch(`${PSGC_API}/provinces/`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(provinces => {
                provinces.sort((a, b) => a.name.localeCompare(b.name));
                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.setAttribute('data-code', province.code);
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
                setSelectReady(provinceSelect);
            })
            .catch(() => {
                setSelectError(provinceSelect, 'Failed to load provinces');
            });

        // When province changes, fetch cities/municipalities
        provinceSelect.addEventListener('change', function() {
            setSelectLoading(citySelect);
            setSelectLoading(barangaySelect, 'Select Barangay');
            if (!this.value) {
                citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                citySelect.disabled = false;
                barangaySelect.disabled = false;
                return;
            }

            const selectedOption = this.options[this.selectedIndex];
            const provinceCode = selectedOption.getAttribute('data-code');

            fetch(`${PSGC_API}/provinces/${provinceCode}/cities-municipalities/`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(cities => {
                    cities.sort((a, b) => a.name.localeCompare(b.name));
                    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.setAttribute('data-code', city.code);
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                    setSelectReady(citySelect);
                })
                .catch(() => {
                    setSelectError(citySelect, 'Failed to load cities');
                });
        });

        // When city changes, fetch barangays
        citySelect.addEventListener('change', function() {
            setSelectLoading(barangaySelect);
            if (!this.value) {
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                barangaySelect.disabled = false;
                return;
            }

            const selectedOption = this.options[this.selectedIndex];
            const cityCode = selectedOption.getAttribute('data-code');

            fetch(`${PSGC_API}/cities-municipalities/${cityCode}/barangays/`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(barangays => {
                    barangays.sort((a, b) => a.name.localeCompare(b.name));
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                    barangays.forEach(barangay => {
                        const option = document.createElement('option');
                        option.value = barangay.name;
                        option.textContent = barangay.name;
                        barangaySelect.appendChild(option);
                    });
                    setSelectReady(barangaySelect);
                })
                .catch(() => {
                    setSelectError(barangaySelect, 'Failed to load barangays');
                });
        });

        document.querySelectorAll('#documentTypesGroup input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const qtyInput = this.parentElement.querySelector('.doc-qty');
                const minusBtn = this.parentElement.querySelector('.qty-btn.minus');
                const plusBtn = this.parentElement.querySelector('.qty-btn.plus');
                const quantitySelector = this.parentElement.querySelector('.quantity-selector');
                qtyInput.disabled = !this.checked;
                minusBtn.disabled = !this.checked;
                plusBtn.disabled = !this.checked;
                if (this.checked && !qtyInput.value) qtyInput.value = 1;
            });
        });

        // Plus/minus button logic
        document.querySelectorAll('.qty-btn.plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const qtyInput = this.parentElement.querySelector('.doc-qty');
                qtyInput.value = parseInt(qtyInput.value) + 1;
            });
        });
        document.querySelectorAll('.qty-btn.minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const qtyInput = this.parentElement.querySelector('.doc-qty');
                if (parseInt(qtyInput.value) > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                }
            });
        });
        
        // Floating FAQs Modal Logic
        const floatingFaqs = document.getElementById('floatingFaqs');
        const faqsModal = document.getElementById('faqsModal');
        const closeFaqsModal = document.getElementById('closeFaqsModal');
        if (floatingFaqs) {
            floatingFaqs.addEventListener('click', function() {
                faqsModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        if (closeFaqsModal) {
            closeFaqsModal.addEventListener('click', function() {
                faqsModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
        
        // FAQ Accordion in Modal
        faqsModal.querySelectorAll('.faq-item').forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
    </script>
</body>
</html>