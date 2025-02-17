<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Satisfaction Feedback')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

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
