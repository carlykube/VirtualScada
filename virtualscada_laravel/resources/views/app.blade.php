<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Virtual Scada</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- MY CUSTOM STYLE SHEETS -->

	<!--<link href="{{ asset('/css/login.css') }}" rel="stylesheet">-->
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

    <!-- we want to force people to click a button, so hide the close link in the toolbar -->
    <style type="text/css">a.ui-dialog-titlebar-close { display:none }</style>

</head>
<body>
    <!-- dialog window markup -->
    <div id="dialog" title="Your session is about to expire!">
        <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
            You will be logged off in <span id="dialog-countdown" style="font-weight:bold"></span> seconds.
        </p>

        <p>Do you want to continue your session?</p>
    </div>

	<nav class="navbar navbar-default" style="position:fixed; top:0; z-index:100;">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">VIRTUAL SCADA</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
					<!--
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					-->
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<footer class="footer" style="background-color:#0b1b3d; position:fixed;">
		<div class="container">
			<p class="text-muted">©2014-2015 <a href="http://smu.edu/lyle" style="text-transform:uppercase">Southern Methodist University's Lyle School of Engineering</a></p>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js" type="text/javascript"></script>

    <script src="../js/jquery.idletimer.js" type="text/javascript"></script>
    <script src="../js/jquery.idletimeout.js" type="text/javascript"></script>

    <script type="text/javascript">
        // setup the dialog
        $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 200,
            closeOnEscape: false,
            draggable: false,
            resizable: false,
            buttons: {
                'Yes, Keep Working': function(){
                    $(this).dialog('close');
                },
                'No, Logoff': function(){
                    // fire whatever the configured onTimeout callback is.
                    // using .call(this) keeps the default behavior of "this" being the warning
                    // element (the dialog in this case) inside the callback.
                    $.idleTimeout.options.onTimeout.call(this);
                }
            }
        });
        // cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
        var $countdown = $("#dialog-countdown");
        // start the idle timer plugin
        $.idleTimeout('#dialog', 'div.ui-dialog-buttonpane button:first', {
            idleAfter: 120,
            pollingInterval: 2,
            keepAliveURL: 'keepalive.php',
            serverResponseEquals: 'OK',
            onTimeout: function(){
                window.location = "timeout.htm"
            },
            onIdle: function(){
                $(this).dialog("open");
            },
            onCountdown: function(counter){
                $countdown.html(counter); // update the counter
            }
        });
    </script>
</body>
</html>
