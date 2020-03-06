<?php
/*
 * CLC Project version 4.0
 * Edit Group Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Edit Group Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit Group')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>Edit Group</h1>

	<form action="updateGroup" method="POST">
		{{ csrf_field() }}

		<input type="hidden" value="{{ $group->getId() }}" name="group_id">

		<table>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="name" value="{{ $group->getName() }}" />{{$errors->first('name')}}</td>
			</tr>
			
			<tr>
				<td>Description:</td>
				<td><input type="text" name="description" value="{{ $group->getDescription() }}" />{{$errors->first('description')}}</td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Update" /></td>
			</tr>
		</table>
		
		<input type='hidden' name='owner_id' value="{{ $group->getOwner_id() }}"> 
	</form>

</div>
@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
