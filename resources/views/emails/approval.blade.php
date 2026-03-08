<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('layouts.' . $type) }} {{ __('layouts.approved') }} - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            text-align: center;
            padding: 25px;
        }
        .header h1 { margin:0; font-size: 26px; }
        .header .app-name { font-size: 14px; opacity:0.9; margin-top:5px; }
        .content { padding: 30px; }
        .panel {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .panel strong { display:inline-block; min-width:120px; }
        .action {
            background-color: #fff3cd;
            border:1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #856404;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            text-align:center;
            padding: 15px;
            font-size: 13px;
        }
        .timestamp {
            font-size:12px;
            color:#6c757d;
            text-align:center;
            font-style:italic;
            margin-bottom:10px;
        }
        @media only screen and (max-width: 600px) {
            .container { margin: 10px; }
            .header h1 { font-size:22px; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                {{ $type }} 
                @if($mode === 'reminder')
                    {{ __('layouts.reminder') }}
                @else
                    {{ __('layouts.approved') }}
                @endif
            </h1>
        </div>

        <div class="content">
            {{-- <p>{{ __('layouts.hello') }} <strong> {{ $plan->defect->user->name ?? 'User' }}</strong>,</p> --}}

            <div class="panel">
                <p><strong>{{ __('layouts.created_at') }}:</strong> {{ $plan->created_at->format('d/m/Y') }}</p>
                {{-- <p><strong>{{ __('layouts.created_by') }}:</strong> {{ $plan->defect->user->name ?? 'User' }}</p> --}}
                {{-- <p><strong>{{ __('layouts.status') }}:</strong> {{ $plan->defect->status->name }}</p> --}}
                @if($type === 'Proposed Solution Plan')
                    <p><strong>{{ __('layouts.plan') }}:</strong> {{ $plan->proposed_solution_plan }}</p>
                    <p><strong>{{ __('layouts.start_date') }}:</strong> {{ $plan->proposed_solution_plan_start_date }}</p>
                    <p><strong>{{ __('layouts.feedback') }}:</strong> {{ $plan->proposed_solution_feedback ?? __('layouts.no_feedback') }}</p>
                    <p><strong>{{ __('layouts.man_hours') }}:</strong> {{ $plan->lost_man_hours }}</p>
                    <p><strong>{{ __('layouts.loss_amount') }}:</strong> {{ $plan->loss_amount }}</p>
                    {{-- <p><strong>{{ __('layouts.updated_by') }}:</strong> {{ $plan->updatedBy->name ?? '-' }}</p> --}}
                @elseif($type === 'Recurrence Prevention Plan')
                    <p><strong>{{ __('layouts.plan') }}:</strong> {{ $plan->recurrence_prevention_plan }}</p>
                    <p><strong>{{ __('layouts.start_date') }}:</strong> {{ $plan->recurrence_prevention_plan_start_date }}</p>
                    <p><strong>{{ __('layouts.feedback') }}:</strong> {{ $plan->recurrence_prevention_feedback ?? __('layouts.no_feedback') }}</p>
                    {{-- <p><strong>{{ __('layouts.updated_by') }}:</strong> {{ $plan->updatedBy->name ?? '-'}}</p> --}}
                @endif
            </div>
        </div>
    </div>
</body>
</html>
