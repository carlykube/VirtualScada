@extends('app')

@section('content')

<div id="registration-container" class="container" style="margin-top:10%">
	<div>
		<div class="panel member_register">

			<div class="panel-body">
				<div class="fa_user">
          			<i class="fa fa-dot-circle-o"></i>
        		</div>

        		@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>REGISTRATION ISSUES</strong><br/><br/>
							@foreach ($errors->all() as $error)
								<p><small>{{ $error }}</small></p>
							@endforeach
					</div>
				@endif

				<form class="registrationform" role="form" method="POST" action="{{ url('/auth/register') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">




					<div class="form-group">
						<label class="sr-only">Name</label>
						<div class="input-group">
							<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="NAME">
						</div>
					</div>

					<div class="form-group">
						<label class="sr-only">E-Mail Address</label>
						<div class="input-group">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-MAIL ADDRESS">
						</div>
					</div>

					<div class="form-group">
						<label class="sr-only control-label">Password</label>
						<div class="input-group">
							<input type="password" class="form-control" name="password" placeholder="PASSWORD">
						</div>
					</div>

					<div class="form-group">
						<label class="sr-only control-label">Confirm Password</label>
						<div class="input-group">
							<input type="password" class="form-control" name="password_confirmation" placeholder="CONFIRM PASSWORD">
						</div>
					</div>


					<div class="form-group">
						<div class="input-group">
							<button type="submit" class="btn btn-primary btn-md register">Register</button>
						</div>
					</div>


				</form>

			</div>
		</div>	
	</div>
	<p style="text-transform:uppercase;">Already Have an Account? <a href="{{ url('/auth/login') }}">SIGN IN</a></p>
</div>
@endsection
