<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Satisfaction Feedback')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background styling */
        body {
            background: url('{{ asset('images/feedback-bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4); /* Dark overlay for readability */
        }

        /* Header styling */
        .header {
            position: fixed;
            top: 7px;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Logo & text container */
        .header-left {
            display: flex;
            align-items: center;
        }

        .header img {
            height: 50px;
            margin-right: 15px;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }

        /* Header right text */
        .header-right {
            font-size: 15px;
            font-weight: bold;
            color: #333;
        }

        /* Main content */
        .container {
            position: relative;
            top: 100px; /* Push content below header */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
            padding: 20px;
        }

        /* Form container */
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            width: 90%;
            text-align: center;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn-add {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-submit {
            background: #007bff;
            color: white;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            opacity: 0.8;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 0;
            font-size: 14px;
            color: #333;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    @yield('styles') <!-- Additional page-specific styles -->
</head>
<body>

    <div class="overlay"></div>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <img src="{{ asset('images/dost-logo.png') }}" alt="DOST Logo">
            <div class="header-text">
                <span style="font-size: 28px">Department of Science and Technology</span>
                <span>Regional Office No. 2 | Tuguegarao City, Cagayan</span>
                <span></span>
            </div>
        </div>
        <div class="header-right">
            QMS 06-FO3 | Revision 06
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} Department of Science and Technology - Region 2 | Tuguegarao City, Cagayan
    </div>

    @yield('scripts') <!-- Additional page-specific scripts -->
</body>
</html>
