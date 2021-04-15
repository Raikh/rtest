@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Success message -->
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif
    @if(Session::has('failed'))
        <div class="alert alert-failed">
            {{Session::get('failed')}}
        </div>
    @endif

    Send money using email as identifier for sender & recipient
    <form method="POST" action="{{ route('transaction.send') }}">
        @csrf

        <div class="form-group">
            <label>Send From</label>
            <input type="email" class="form-control {{ $errors->has('send_from') ? 'error' : '' }}" name="send_from" id="input" value="{{ old('send_from') }}" required>
            @if ($errors->has('send_from'))
                <div class="error">
                    {{ $errors->first('send_from') }}
                </div>
            @endif
            <label>Send To</label>
            <input type="email" class="form-control {{ $errors->has('send_to') ? 'error' : '' }}" name="send_to" id="input" value="{{ old('send_to') }}" required>
            <!-- Error -->
            @if ($errors->has('send_to'))
                <div class="error">
                    {{ $errors->first('send_to') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" class="form-control {{ $errors->has('amount') ? 'error' : '' }}" name="amount" id="input" value="{{ old('amount') }}" required>
            <!-- Error -->
            @if ($errors->has('amount'))
                <div class="error">
                    {{ $errors->first('amount') }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class='col-sm-8'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" name="date" id="input" value="{{ old('date') }}" required/>
                        <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
                    </div>
                </div>
                @if ($errors->has('date'))
                    <div class="error">
                        {{ $errors->first('date') }}
                    </div>
                @endif
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker({
                        format:'YYYY-MM-DD H',
                        inline:false,
                        minDate: new Date().setHours(new Date().getHours()+1),
                        sideBySide: true,
                        showClear: true,
                        showClose: true,
                    });
                });
            </script>

        <input type="submit" name="send" id="button" value="{{ __('Send') }}" class="btn btn-primary btn-block">
        </div>
    </form>
</div>

<div class="container-fluid" style="align-self: center;">
    <table class="container-fluid" border="1" cellspacing="1" cellpadding="1">
        <tr><th>Email</th><th>Name</th><th>Balance</th><th>Last transaction</th></tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td><a href="{{ route('users.show', [ 'id' => $user->id ]) }}">{{ $user->name }}</a></td>
                <td>{{ $user->wallet->balance/100 }}</td>
                <td>
                @if(!empty($user->lastTransactionsFromUser))

                    <table border="1" cellspacing="1" cellpadding="1">
                        <tr><th>Send To</th><th>Amount</th><th>Date</th></tr>
                            <tr>
                                <td> {{ $user->lastTransactionsFromUser->toUser->name }}</td>
                                <td> {{ $user->lastTransactionsFromUser->amount/100 }} </td>
                                <td> {{ $user->lastTransactionsFromUser->created_at->timezone(config('user.timezone'))->format('Y-m-d H:i:s') }} </td>
                            </tr>
                    </table>
                @else
                    No transactions
                @endif
                </td>
            </tr>
        @endforeach
    </table>
    <div class="container-fluid" style="align-self: center;">
    {{ $users->links() }}
    </div>
</div>



@endsection
