@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Carian</a></li>
@endsection

@section('content')
<div class="row  justify-content-center">
    <div class="col-md-6">
        <div class="card card-default">
            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'route' => 'carian.search']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('nokp') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('nokp', 'No Kad Pengenalan') !!}
                            {!! Form::text('nokp', null, ['class' => 'form-control','required']) !!}
                            <small class="text-danger">{{ $errors->first('nokp') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-block" id="search"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $("#nokp").keyup(function(){
		var s= $("#nokp").val();
		if(s.length == 6){
			$("#nokp").val(s+"-");
		}

		if(s.length == 9){
			$("#nokp").val(s+"-");
		}
	});
</script>
@endsection

