<!DOCTYPE html>
<html>
<head>
    <title>Respondents List - {{ $year }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 10px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
        th { background-color: #3498db; color: white; }
        h2, h3 { margin-top: 20px; }
    </style>
</head>
<body>

    <h2>Respondents List for Year {{ $year }}</h2>

    @if(isset($respondentsByQuarter) && count($respondentsByQuarter) > 0)
        @foreach($respondentsByQuarter as $quarterTitle => $respondents)
            <h3>{{ $quarterTitle }}</h3>

            @if(isset($respondents) && !$respondents->isEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
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
                            <td>{{ $respondent->age }}</td>
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
            @else
                <p>No respondents for this quarter.</p>
            @endif
            <hr>
        @endforeach
    @else
        <p>No respondents found for the selected filters.</p>
    @endif

</body>
</html>
