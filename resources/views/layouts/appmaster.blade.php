<?php 
/* CLC Project version 6.0
 * appmaster version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * appmaster layout class supports blade
 */?>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<script
      src="http://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/css.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
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