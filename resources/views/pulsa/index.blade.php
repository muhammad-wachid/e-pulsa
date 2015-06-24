@extends('app')

@section('content')

<div style="margin:10%;">
	<form action="/topup" method="post">
		<input type="text" name="nohp" id="nominal" placeholder='enter your phone number here'>
		<select name="nominal" id="nominal">
			<option value="s50">50.000</option>
			<option value="s100">100.000</option>
		</select>
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="submit" value="Topup">
	</form>
	<br />
	<form action="/inquiry" method="post">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="hidden" name="server_trxid" value="{{$respon['server_trxid']}}">
		<input type="submit" value="Inquiry">
	</form>
	<br />
	<a href="/">Index</a>

	<!--/*{!! Form::open(array('route' => 'topup', 'method' => 'post')) !!}
		<div class="form-group">
	    {!! Form::text('nohp', null, 
	        array('required', 
	              'class'=>'form-control', 
	              'placeholder'=>'enter your phone number here')) !!}
		</div>

		<br />

		<div class="form-group">
			<select name="nominal" id="nominal">
				<option value="s50">50.000</option>
				<option value="s100">100.000</option>
			</select>
		</div>

		<br />

		<div class="form-group">
		    {!! Form::submit('Topup!', 
		      array('class'=>'btn btn-primary')) !!}
		</div>

	{!! Form::close() !!}

	<br />

	{!! Form::open(array('route' => 'inquiry', 'method' => 'post')) !!}

		<div class="form-group">
		    {!! Form::submit('Inquiry!', 
		      array('class'=>'btn btn-primary')) !!}
		</div>

	{!! Form::close() !!}*/-->

	<div style="width:50%">
		<p id="response-div">{{$respon['rescode']}}</p>
		<p id="response-div">{{$respon['hp']}}</p>
		<p id="response-div">{{$respon['vtype']}}</p>
		<p id="response-div">{{$respon['server_trxid']}}</p>
		<p id="response-div">{{$respon['partner_trxid']}}</p>
		<p id="response-div">{{$respon['scrmessage']}}</p>
		<p id="response-div">{{$respon['resmessage']}}</p>
		<p id="response-div">{{$respon['sn']}}</p>
	</div>

	<div style="width:50%">
		<p id="response-div">{{$error}}</p>
	</div>
</div>
@endsection