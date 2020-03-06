<?php
/*
 * CLC Project version 4.0
 * New Group Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * New Group Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Affinity Group')

@section('content')
@if(Session::get('principal') == true)
<div class="center">
	<h1>New Group</h1>

	<form action="newGroup" method="POST">
		{{ csrf_field() }}

		<input type='hidden' name='owner_id' value="{{ Session::get('id') }}">
		<table>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="name" value="" />{{$errors->first('name')}}</td>
			</tr>

			<tr>
				<td>Description:</td>
				<td><input type="text" name="description" value="" />{{$errors->first('description')}}</td>
			</tr>


			<tr>
				<td colspan="2" align="center"><input type="submit" value="Create" /></td>
			</tr>
		</table>
	</form>

</div>
@else
<h2>User is not authorized!!!</h2>
@endif @endsection
