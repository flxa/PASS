<!doctype html>
<!-- Conditional comment for mobile ie7 http://blogs.msdn.com/b/iemobile/ -->
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>PASS</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/h/apple-touch-icon.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/m/apple-touch-icon.png">
  <link rel="apple-touch-icon-precomposed" href="img/l/apple-touch-icon-precomposed.png">
  <link rel="shortcut icon" href="img/l/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
  <link rel="apple-touch-startup-image" href="img/h/splash.png">
  <meta http-equiv="cleartype" content="on">
  <link href='http://fonts.googleapis.com/css?family=Ubuntu:500,700,700italic' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/style.css?v=1">
  <link rel="stylesheet" media="print" href="css/print.css">
  <!-- For progressively larger displays -->
  <link rel="stylesheet" media="only screen and (min-width: 480px)" href="css/480.css">
  <link rel="stylesheet" media="only screen and (min-width: 600px)" href="css/600.css">
  <link rel="stylesheet" media="only screen and (min-width: 768px)" href="css/768.css">
  <link rel="stylesheet" media="only screen and (min-width: 992px)" href="css/992.css">
  <link rel="stylesheet" media="only screen and (min-width: 1382px)" href="css/1382.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/libs/modernizr-2.0.6.min.js"></script>
  <script>Modernizr.mq('(min-width:0)') || document.write('<script src="js/libs/respond.min.js">\x3C/script>')</script>
</head>
<body>
	<div id="container">
		<header>
			<div class="topbar">
				<div class="fill">
					<div class="container">
						<a href="/pass/index.php" title="Print National Appointment Scheduling System" class="logo">PASS</a>
						<ul>
							<li class="dropdown" data-dropdown="dropdown">
								<a href="#" class="dropdown-toggle"><img src="img/template/icons/menu.png"></a>
								<ul class="dropdown-menu">
									<li <?php if ($_REQUEST['c']=='rpt') { echo 'class="active"';  } ?>><a href="index.php?c=rpt" class="icon"><img src="img/template/icons/rpt.png"><span>Reports</span></a></li>
									<li class="divider"></li>
									<li><a href="index.php?c=users&task=logout">Logout</a></li>
								</ul>
							</li>
							<li <?php if ($_REQUEST['c']=='cal') { echo 'class="active"';  } ?>><a href="index.php?c=cal" class="icon"><img src="img/template/icons/cal.png"></a></li>
							<li <?php if ($_REQUEST['c']=='users') { echo 'class="active"';  } ?>><a href="index.php?c=users" class="icon"><img src="img/template/icons/usr.png"></a></li>
							<li <?php if ($_REQUEST['c']=='company') { echo 'class="active"';  } ?>><a href="index.php?c=company" class="icon"><img src="img/template/icons/cmp.png"></a></li>
							<li <?php if ($_REQUEST['c']=='client') { echo 'class="active"';  } ?>><a href="index.php?c=client" class="icon"><img src="img/template/icons/cnt.png"></a></li>
            </ul>
					</div>
				</div>
			</div>
		</header>
		<div id="main" role="main">
