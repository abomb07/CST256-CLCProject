<?php
/*
 * CLC Project version 3.0
 * New Education Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * New Education Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Education')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>New Education</h1>

	<form action="addEducation" method="POST">
		{{ csrf_field() }}

		<table>
			<tr>
				<td>School:</td>
				<td><input type="text" name="school" value="" /></td>
			</tr>

			<tr>
				<td>Degree:</td>
				<td><input type="text" name="degree" value="" /></td>
			</tr>

			<tr>
				<td>Field:</td>
				<td><input type="text" name="field" value="" /></td>
			</tr>

			<tr>
				<td>Graduation Year:</td>
				<td><input type="text" name="graduationyear" value="" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Add" /></td>
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