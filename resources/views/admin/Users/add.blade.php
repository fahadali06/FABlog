@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users <button class="btn btn-primary btn-sm pull-right" onclick="OpenUsers();">User List</button></h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Add
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {{ Form::open(['url' => url('admin/user/management/store'), 'mehtod' => 'POST', 'id' => 'FormAdd', 'enctype' => 'multipart/form-data']) }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'Name') }}
                        {{ Form::text('name',  old('name') , ['class' => 'form-control', 'id' => 'name']) }}
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'Email') }}
                        {{ Form::email('email',  old('email') , ['class' => 'form-control', 'id' => 'email']) }}
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        {{ Form::label('role_id', 'Role') }}
                        {{ Form::select('role_id',$role, null, ['class' => 'form-control']) }}
                        @if ($errors->has('role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        {{ Form::label('status', 'Status') }}
                        {{ Form::select('status', ['Yes' => 'Active', 'No' => 'Inactive'], null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {{ Form::label('password', 'Password') }}
                        {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        {{ Form::label('password_confirmation', 'Password') }}
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirm']) }}
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="progress hidden">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">

                                </div>
                            </div>
                            <div id="output"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>

                    {{ Form::close() }}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->

    <!-- /.row -->

    <!-- /.row -->
</div>
@endsection
<script>
    function OpenUsers() {
        window.location.href = '{{ url("admin/user/management") }}';
    }
</script>
