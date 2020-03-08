<?php
/* CLC Project version 4.0
 * Admin Process Job Delete version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Admin Delete Job Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Process Job Delete Page')

@section('content')
@if(Session::get('principal')== true and Session::get('role') == "admin") 

<h2>Are you sure you want to delete this job?</h2>
<form action='adminJobDelete' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='id' value="{{ $job->getId() }}">
<input type='submit' value='YES'>
</form>

<form action='adminJobs'>
<input type='submit' value='NO'>
</form>

@endif
@endsection