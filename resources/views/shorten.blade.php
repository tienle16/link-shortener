@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Shorten Link</div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="POST" action="{{ route('clgt.shorten') }}">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {!! $error !!}<br/>
                                    @endforeach
                                </div>
                            @elseif(session()->get('flash_success'))
                                <div class="alert alert-success">
                                    @if(is_array(json_decode(session()->get('flash_success'), true)))
                                        {!! implode('', session()->get('flash_success')->all(':message<br/>')) !!}
                                    @else
                                        {!! session()->get('flash_success') !!}
                                    @endif
                                </div>
                            @elseif(session()->get('flash_danger'))
                                <div class="alert alert-danger">
                                    @if(is_array(json_decode(session()->get('flash_danger'), true)))
                                        {!! implode('', session()->get('flash_danger')->all(':message<br/>')) !!}
                                    @else
                                        {!! session()->get('flash_danger') !!}
                                    @endif
                                </div>
                            @endif
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="url" class="col-md-2 col-sm-offset-1 control-label">Enter Url</label>

                                <div class="col-md-6">
                                    <input id="url" class="form-control" name="url" value="{{ old('url') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        Shorten
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
