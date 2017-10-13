@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        Name: {{ Auth::user()->name }}<hr>
                        Email:{{ Auth::user()->email }}<hr>
                            @if (Auth::user()->secondary_email!=null)
                                Secondary Email:{{ Auth::user()->secondary_email }}<hr>
                            @endif
                         @if (Auth::user()->provider==null)
                             <a href="{{ url('auth/facebook') }}">Connect to facebook</a><hr>

                         @else
                            <label>Facebook Connected</label><br/>
                            <a href="{{ url('/disconnect') }}">Disconnect Facebook</a>
                            <ul>
                                @if(isset($message))
                                    <li class="text-danger">{{$message}}</li>
                                @endif
                            </ul><hr>
                                @if (Auth::user()->password==null)
                                    Create New Password
                                    <form class="form-horizontal" method="POST" action="{{ '/newPassword/'.Auth::user()->id }}">
                                        {{ csrf_field() }}
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <input id="newPassword" name="newPassword" type="password" placeholder="New Password" class="form-control input-md" required="">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm Password" class="form-control input-md" required="">

                                                </div>
                                            </div>
                                        <ul>
                                            @foreach($errors->all() as $error)

                                                <li class="text-danger">{{$error}}</li>
                                            @endforeach
                                        </ul>
                                            <!-- Button -->
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <button id="changePassword" name="createPassword" class="btn btn-primary">Create Password</button>
                                                </div>
                                            </div>
                                    </form>


                                @endif
                          @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
