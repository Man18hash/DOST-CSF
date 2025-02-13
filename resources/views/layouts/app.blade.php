<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DOST Customer Feedback')</title>

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
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header img {
            height: 50px;
        }

        .header-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        /* Main content */
        .container {
            position: relative;
            top: 80px; /* Push content below header */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
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
        <img src="{{ asset('images/dost-logo.png') }}" alt="DOST Logo">
        <span class="header-title">CUSTOMER SATISFACTION FEEDBACK</span>
        <span>QMS 06-FO3 | Revision 5</span>
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
