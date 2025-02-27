<!DOCTYPE html>
<html>
<head>
    <title>Respondents List - {{ $year }}</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf-style.css') }}">
</head>
<body>

    <!-- HEADER SECTION -->
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/dost-logo.png') }}" alt="DOST Logo" class="logo">
        </div>
        <div class="header-text">
            <h1>DEPARTMENT OF SCIENCE AND TECHNOLOGY</h1>
            <h2>Regional Office No. 02</h2>
            <p class="sub-header">SUMMARY OF CUSTOMER SATISFACTION FEEDBACK</p>
            <p class="quarter-title">
                {{ $quarter ? 'QUARTER ' . $quarter : 'FULL YEAR' }} {{ $year }}
            </p>
        </div>
    </div>

    <!-- HEADER LINE -->
    <div class="header-line"></div>

    @if(isset($respondentsByQuarter) && count($respondentsByQuarter) > 0)
        @foreach($respondentsByQuarter as $quarterTitle => $respondents)
            <h3 class="quarter-title">{{ $quarterTitle }}</h3>

            @if(isset($respondents) && !$respondents->isEmpty())
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Unit Provider</th>
                                <th>Service Availed</th>
                                <th>DOST Employee</th>
                                <th>SQD0</th>
                                <th>SQD1</th>
                                <th>SQD2</th>
                                <th>SQD3</th>
                                <th>SQD4</th>
                                <th>SQD5</th>
                                <th>SQD6</th>
                                <th>SQD7</th>
                                <th>SQD8</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($respondents as $respondent)
                            <tr>
                                <td>{{ $respondent->name }}</td>
                                <td>{{ $respondent->sex }}</td>
                                <td>{{ $respondent->unit_provider }}</td>
                                <td>{{ $respondent->assistance_availed }}</td>
                                <td>{{ $respondent->DOST_employee }}</td>
                                <td>{{ $respondent->SQD0 }}</td>
                                <td>{{ $respondent->SQD1 }}</td>
                                <td>{{ $respondent->SQD2 }}</td>
                                <td>{{ $respondent->SQD3 }}</td>
                                <td>{{ $respondent->SQD4 }}</td>
                                <td>{{ $respondent->SQD5 }}</td>
                                <td>{{ $respondent->SQD6 }}</td>
                                <td>{{ $respondent->SQD7 }}</td>
                                <td>{{ $respondent->SQD8 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="no-data">No respondents for this quarter.</p>
            @endif
            <hr>
        @endforeach
    @else
        <p class="no-data">No respondents found for the selected filters.</p>
    @endif

</body>
</html>
