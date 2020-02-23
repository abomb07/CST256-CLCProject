<?php 
/* CLC Project version 2.0
 * appmaster version 2.0
 * Adam Bender and Jim Nguyen
 * February 5th, 2020
 * appmaster layout class supports blade
 */?>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>

<body>	
<div class="d-flex flex-column sticky-footer-wrapper">
    @include('layouts.header')
	@include('layouts._navbar')
	
	<div class="flex-fill" align="center"> 
		@yield('content')
	</div>
	<div class="fixed-bottom" align="center" style="background-color:#F8F8F8;">
	@include('layouts.footer')
	</div>
</div>
</body>

</html>