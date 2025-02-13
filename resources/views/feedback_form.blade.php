@extends('layouts.app')

@section('title', 'Customer Satisfaction Feedback')

@section('content')
    <div class="form-container">
        <h1 class="title-text">CUSTOMER SATISFACTION FEEDBACK</h1>
    </div>
@endsection

@section('styles')
<style>
    /* Center the container and apply styling */
    .form-container {
        background: rgba(78, 85, 88, 0.85); /* Glass effect */
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        max-width: 1000px;
        width: 100%;
        margin: auto;
        text-align:center;
        backdrop-filter: blur(10px); /* Glassmorphism effect */
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        top: -190px; /* Move the title up slightly */
    }

    /* Improve title appearance */
    .title-text {
        font-family: Arial, sans-serif; /* Arial for a classic, professional look */
        font-size: 55px; /* Bigger and more elegant */
        font-weight: bold; /* Stronger emphasis */
        color: white; /* White text fill */
        text-transform: uppercase;
        letter-spacing: 2px; /* Better readability */
        /* -webkit-text-stroke: 1px black; Black stroke around text */
        text-shadow: 4px 4px 12px rgba(0, 0, 0, 0.3); /* Softer glow effect */
        animation: fadeIn 1.2s ease-in-out;
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

    /* Fade-in animation for a smoother effect */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
