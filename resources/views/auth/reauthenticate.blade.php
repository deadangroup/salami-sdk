@extends('theme::layouts.main')

@section('title','Reenter Password')

@section('content')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="bold text-white text-center">
                    Sensitive data ahead
                </h4>

            </div>
            <div class="panel-body">

                <h4 class="text-center">
                    Enter your password to continue
                </h4>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-horizontal" role="form" method="POST"
                      action="{{ route('reauthenticate.post') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" value="">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @else
                                <span class="help-block">
                                        We won't ask for your password again for a few hours.
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-key"></i> Continue
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
