<?php 
/* CLC Project version 4.0
 * Login Success Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Login Success Form
 */
?>
@extends('layouts.appmaster')
@section('title','Login Success Page')

@section('content')

<h2>Congratulation, you have successfully logged in</h2>
<h2>Welcome back </h2> @if(Session::get('principal')== true) <h2> {{Session::get('username')}} {{Session::get('status')}} </h2>
@else
<h2> Please login!</h2>
@endif				 


<br>

@endsection