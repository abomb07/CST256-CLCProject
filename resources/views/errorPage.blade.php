<?php
/* CLC Project version 6.0
 * Error Page version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * Error Form
 */
?>
@extends('layouts.appmaster')
@section('title','ERROR')

@section('content')
<h2>{{ $error }}</h2>
<a href="home">Return Home</a>
@endsection