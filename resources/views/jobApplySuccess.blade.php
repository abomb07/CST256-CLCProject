<?php
/* CLC Project version 5.0
 * Error Page version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Job Apply Success Form
 */
?>
@extends('layouts.appmaster')
@section('title','Job Apply Success Page')

@section('content')
<h2>You have successfully applied to the {{ $title }} position at {{ $company }}</h2>
<a href="home">Find More Jobs</a>
@endsection