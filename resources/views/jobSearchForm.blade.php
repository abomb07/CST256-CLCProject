<?php
/* CLC Project version 5.0
 * Job Search page version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Job Search Page
 */
?>
@extends('layouts.appmaster')
@section('title','Job Search Page')

@section('content')
@if(Session::get('principal') == true) 	
<h2> Job Search Form</h2>
<br>
<form action="findByTitle" method="POST">
{{ csrf_field() }}
  <input type="text" placeholder="Search By Job Title" name="jobtitle">
    <input type='submit' value='Search'>{{$errors->first('jobtitle')}}
</form>

<br>
<form action="findByDescription" method="POST">
{{ csrf_field() }}
  <input type="text" placeholder="Search By Job Description" name="jobdescription">
    <input type='submit' value='Search'>{{$errors->first('jobdescription')}}
</form>

<br>
<form action="findByLocation" method="POST">
{{ csrf_field() }}
  <input type="text" placeholder="Search By Job Location" name="joblocation">
    <input type='submit' value='Search'>{{$errors->first('joblocation')}}
</form>

<br>

<p>Job Match features will find job that matches with skills, education and job history in your portfolio</p>
<form action="jobMatch" method="POST">
{{ csrf_field() }}
	<input type='hidden' name='id' value="{{Session::get('id')}}">
    <input type='submit' value='Job Match'>
</form>
@else
<h2> Must be logged in!!!</h2>
@endif	

@endsection