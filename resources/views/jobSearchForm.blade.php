<?php
/* CLC Project version 4.0
 * Job Search page version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Job Search Page
 */
?>
@extends('layouts.appmaster')
@section('title','Job Search Page')

@section('content')
@if(Session::get('principal') == true) 	
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
@else
<h2> Must be logged in!!!</h2>
@endif	

@endsection