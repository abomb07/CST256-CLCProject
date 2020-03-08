<?php
/* CLC Project version 4.0
 * Edit User Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Edit User Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit User Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin") 	
<div class="center">
<h1>Admin User Edit</h1>

<form action="adminSave" method ="POST">
<div class="container">
{{ csrf_field() }}
        <input type="hidden" class="form-control" id="id" value="{{ $user->getId() }} " name="id">
        
        <div class="form-group">
                <input type="hidden" class="form-control" id="username" value="{{ $user->getUsername() }} " name="username">
        </div>

        <div class="form-group">
                
                <input type="hidden" class="form-control" id="password" value="{{ $user->getPassword() }} " name="password">
        </div>
        
        <div class="form-group">
               
                <input type="hidden" class="form-control" id="firstname" value="{{ $user->getFirstname() }} "name="firstname">
        </div>

        <div class="form-group">
                
                <input type="hidden" class="form-control" id="lastname" value="{{ $user->getLastname() }} " name="lastname">
        </div>
        
        <div class="form-group">
                
                <input type="hidden" class="form-control" id="email" value="{{ $user->getEmail() }} " name="email">
        </div>
        
        <div class="form-group">
                
                <input type="hidden" class="form-control" id="phonenumber" value="{{ $user->getPhonenumber() }} " name="phonenumber">
        </div>
        
        <div class="form-group">
               
                <input type="hidden" class="form-control" id="city" value="{{ $user->getCity() }} " name="city">
        </div>

        <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role">
                        <option value="user">user</option>
                        <option value="admin">admin</option>      
                </select>
        </div>
        
        <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                        <option value="active">active</option>
                        <option value="suspended">suspended</option>
                    
                       
                </select>
        </div>
        <button type="submit" value="submit" class="btn btn-default">SUBMIT</button>
</div> 
</form>        
</div>
@else
<h2> User is not authorized!!!</h2>
@endif	
@endsection