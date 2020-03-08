<?php
/* CLC Project version 4.0
 * Error Page version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Error Form
 */
?>
@extends('layouts.appmaster')
@section('title','ERROR')

@section('content')
<h2>{{ $error }}</h2>
<a href="home">Return Home</a>
@endsection