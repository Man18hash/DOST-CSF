@extends('layouts.app')

@section('title', 'Respondents List')

@section('content')
<div class="admin-dashboard">
    <div class="main-content">
        <h1>Respondents</h1>

        <table class="respondents-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Client Classification</th>
                    <th>Client Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach($respondents as $respondent)
                <tr>
                    <td>{{ $respondent->name ?? 'N/A' }}</td>
                    <td>{{ $respondent->age }}</td>
                    <td>{{ $respondent->sex }}</td>
                    <td>{{ $respondent->address }}</td>
                    <td>
                        @foreach(json_decode($respondent->client_classification) as $classification)
                            <span class="badge">{{ $classification }}</span>
                        @endforeach
                    </td>
                    <td>{{ $respondent->client_type }}</td>
                    <td>{{ $respondent->date }}</td>
                    <td>
                        <a href="{{ route('admin.respondent.preview', $respondent->id) }}" class="btn-preview">Preview</a>
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
</div>

<style>
    .respondents-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .respondents-table th, .respondents-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .respondents-table th {
        background-color: #3498db;
        color: white;
    }
    .badge {
        display: inline-block;
        background-color: #2ecc71;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 2px;
    }
    .btn-preview {
        background-color: #f39c12;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }
    .btn-preview:hover {
        background-color: #e67e22;
    }
</style>
@endsection
