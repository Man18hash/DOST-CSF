@extends('layouts.app')

@section('title', 'Customer Satisfaction Feedback')

@section('content')
    <div class="form-container">
        <h1>CUSTOMER SATISFACTION FEEDBACK</h1>
    </div>
@endsection

@section('styles')
<style>
    /* Center the container and apply styling */
    .form-container {
        background: rgba(255, 255, 255, 0.8); /* Glass effect */
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        max-width: 700px;
        width: 90%;
        margin: auto;
        text-align: center;
        backdrop-filter: blur(8px); /* Glassmorphism effect */
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Improve text appearance */
    h1 {
        font-size: 40px;
        font-weight: bold;
        color: #333;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* Background overlay with gradient for better contrast */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.2));
    }
</style>
@endsection
