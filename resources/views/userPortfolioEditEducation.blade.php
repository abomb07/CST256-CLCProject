<?php
/*
 * CLC Project version 3.0
 * Edit Education Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Edit Education Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit Education')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>Edit Education</h1>

	<form action="updateEducation" method="POST">
		{{ csrf_field() }}

		<input type="hidden" value="{{ $education->getId() }}" name="id">

		<table>
			<tr>
				<td>School:</td>
				<td><input type="text" name="school" value="{{ $education->getSchool() }}" /></td>
			</tr>
			
			<tr>
				<td>Degree:</td>
				<td><input type="text" name="degree" value="{{ $education->getDegree() }}" /></td>
			</tr>
			
			<tr>
				<td>Field:</td>
				<td><input type="text" name="field" value="{{ $education->getField() }}" /></td>
			</tr>
			
			<tr>
				<td>Graduation Year:</td>
				<td><input type="text" name="graduationyear" value="{{ $education->getGraduationyear() }}" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Update" /></td>
			</tr>
		</table>
		
		<input type='hidden' name='user_id' value="{{Session::get('id')}}"> 
	</form>

</div>
@else
<h2>Must be logged in to view portfolio!!!</h2>
@endif 

<!--  Display all the Data Validation Rule Erros -->
<!-- NOT: the use of Blade Condition, try not and use PHP scriplets! -->
@if($errors->count() != 0)
<h5>Lists of Errors</h5>
@foreach($errors->all() as $message)
	{{ $message}} <br/>
@endforeach
@endif

@endsection
