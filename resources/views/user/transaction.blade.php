@extends('layouts.app')

@section('content')
{{--    @if(count($errors) > 0)--}}
{{--        @foreach($errors->all() as $error)<div class="alert-danger alert">{{$error}}</div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    <hr>

    <form method="GET" action="{{ route('dashboard') }}">
        <input type="submit" name="send" value="{{ __('Dashboard') }}" class="btn btn-primary btn-block">
    </form>

    <div>Name: {{ $user->name }}</div>
    <div>Balance: {{ $stats['amount']/100}}</div>

    <div>Blocked: {{ $stats['blockedAmount']/100}} </div>

    <div>Available: {{ $stats['availableAmount']/100}} </div>

<div> Transactions</div>
@if($transactions->isNotEmpty())
<div class="container">
    <table border="1" cellspacing="1" cellpadding="1">
        <tr>
            <td>ID</td>
            <td>FROM</td>
            <td>TO</td>
            <td>AMOUNT</td>
            <td>STATUS</td>
            <td>DATE</td>
        </tr>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->fromUser->name }}</td>
                <td>{{ $transaction->toUser->name }}</td>
                <td>{{ $transaction->amount/100 }}</td>
                <td>{{ $transaction->status->title }}</td>
                <td>{{ $transaction->created_at->timezone(config('user.timezone'))->format('Y-m-d H:i:s') }} </td>
            </tr>
        @endforeach
    </table>
</div>
@else
    No Transactions
@endif

{{ $transactions->links() }}

<div>Scheduled Transactions</div>
@if($scheduledTransactions->isNotEmpty())
<div class="container">
    <table border="1" cellspacing="1" cellpadding="1">
        <tr>
            <td>ID</td>
            <td>FROM</td>
            <td>TO</td>
            <td>AMOUNT</td>
            <td>STATUS</td>
            <td>DATE</td>
        </tr>
        @foreach ($scheduledTransactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->fromUser->name }}</td>
                <td>{{ $transaction->toUser->name }}</td>
                <td>{{ $transaction->amount/100 }}</td>
                <td>{{ $transaction->status->title }}</td>
                <td>{{ $transaction->schedule_at->timezone(config('user.timezone'))->format('Y-m-d H:i:s') }} </td>
            </tr>
        @endforeach
    </table>
</div>
{{ $scheduledTransactions->links() }}
@else
    No Transactions
@endif

@endsection
