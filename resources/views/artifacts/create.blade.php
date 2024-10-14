<!DOCTYPE html>
<html>
<head>
    <title>Artifact App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('artifacts') }}">artifact Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('artifacts') }}">View All artifacts</a></li>
        <li><a href="{{ URL::to('artifacts/create') }}">Create a artifact</a>
    </ul>
</nav>

<h1>Create a artifact</h1>

<!-- if there are creation errors, they will show here -->
<?php //{{ HTML::ul($errors->all()) }} ; ?>
<form method="POST" action="{{ route('artifacts.store') }}">
            
                {{ csrf_field() }}
            
                <div class="mb-3">
                    <label class="form-label" for="inputName">Name:</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="inputName"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Name">
      
                    <!-- Way 2: Display Error Message -->
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
           
               
               
                <div class="mb-3">
                    <button class="btn btn-success btn-submit"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>


</div>
</body>
</html>