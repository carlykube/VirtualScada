@extends('app')

@section('content')

<div id="login-container" class="container" style="margin-top:10%">
	<div>
    	<div class="panel member_signin">
      		<div class="panel-body">
        		<div class="fa_user">
          			<i class="fa fa-dot-circle-o"></i>
        		</div>


        		@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<	ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							</ul>
					</div>
				@endif


        		<form class="loginform" role="form" method="POST" action="{{ url('/auth/login') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<label class="sr-only">E-Mail Address</label>
						<div class="input-group">
							<input type="email" class="form-control" name="email" placeholder="E-MAIL ADDRESS">
						</div>
					</div>

					<div class="form-group">
						<label class="sr-only">Password</label>
						<div class="input-group">
							<input type="password" class="form-control" name="password" placeholder="PASSWORD">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<button type="submit" class="btn btn-primary btn-md login">Login</button>
						</div>
					</div>
				</form>

        		<p class="forgotpass"><a href="#" class="small">FORGOT PASSWORD?</a></p>
    		</div>
		</div>
	</div>
	<p>DON'T HAVE AN ACCOUNT? <a href="{{ url('/auth/register') }}">SIGN UP</a></p>
</div>



@endsection
