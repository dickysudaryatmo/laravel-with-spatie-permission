@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Karyawan Management</h2>
        </div>
        <div class="pull-right">
            @can('karyawan-create')
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create Karyawan</a>
            @endcan

        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

@can('karyawan-list')
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Jabatan</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->no_hp }}</td>
        <td>
            @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
            @endforeach
            @endif
        </td>
        <td>
            {{-- <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a> --}}
            @can('karyawan-edit')
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
            @endcan
            @can('karyawan-only')
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
            @endcan
            @can('karyawan-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
            @endcan

        </td>
    </tr>
    @endforeach
</table>


{!! $data->render() !!}
@endcan

@can('karyawan-only')
    @php
        $user = Auth::user();   
    @endphp
    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'value' => '{{ $user->name }}' )) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{-- <input type="email" class="form-control" value="{{ $user->email }}" name="email"> --}}
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'value' => '{{ $user->email }}' )) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>No HP:</strong>
                {{-- <input type="text" class="form-control" value="{{ $user->no_hp }}" name="no_hp"> --}}
                {!! Form::text('no_hp', null, array('placeholder' => 'No HP','class' => 'form-control', 'value' => '{{ $user->no_hp }}')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jabatan:</strong>
                {!! Form::text('roles[]',$userRole['Staff'], array('placeholder' => 'Jabatan','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}

@endcan

<p class="text-center text-primary"><small></small></p>
@endsection
