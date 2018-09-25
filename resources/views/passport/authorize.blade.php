@extends('theme::layouts.main')

@section('title','Authorization Request')

@section('content')
    <style>
        .passport-authorize .container {
            margin-top: 30px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }

        .panel-footer {
            height: 100px !important;
        }

        .panel-footer form {
            display: inline-block !important;
        }
    </style>

    <div class="container passport-authorize">

        <div class="container passport-authorize" id="main">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                Authorization Request
                            </h3>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <!-- Introduction -->
                            <p>
                                <strong>
                                    {{ $client->name }}
                                </strong>
                                is requesting permission to access your {{ config('app.name') }} account.
                            </p>
                            <!-- Scope List -->
                            @if (count($scopes) > 0)
                                <div class="scopes">
                                    <p>
                                        <strong>
                                            This application will be able to:
                                        </strong>
                                    </p>
                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li>
                                                {{ $scope->description }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                        <div class="panel-footer">
                            <p>
                                This app will <b>only</b> receive information in accordance with our <a href="">terms of
                                    service</a> and
                                <a href="">privacy policy</a>.
                            </p>

                            <div class="row">
                                <div class="col-sm-6 pull-left">
                                    <!-- Authorize Button -->
                                    <form action="{{ url('/oauth/authorize') }}" method="post">
                                        {{ csrf_field() }}
                                        <input name="state" type="hidden" value="{{ request('state') }}"/>
                                        <input name="client_id" type="hidden" value="{{ $client->id }}"/>
                                        <button class="btn btn-success btn-approve" type="submit">
                                            Authorize
                                        </button>
                                    </form>
                                </div>
                                <div class="col-sm-6 pull-right">
                                    <!-- Cancel Button -->
                                    <form action="{{ url('/oauth/authorize') }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input name="state" type="hidden" value="{{ request('state') }}"/>
                                        <input name="client_id" type="hidden" value="{{ $client->id }}"/>
                                        <button class="btn btn-danger pull-right">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
