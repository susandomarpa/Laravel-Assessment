<!DOCTYPE html>
<html>
<head>
    <title>laravel Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
    
<body>
<div class="container">
     
    <div class="panel panel-primary">
      <div class="panel-heading"><h2>Upload JSONFile</h2></div>
      <div class="panel-body">
     
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif
    
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('json_file.upload.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <input type="text" name="title" class="form-control">
                </div>
    
                <div class="col-md-6">
                    <input type="file" name="data" class="form-control">
                </div>
     
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
     
            </div>
        </form>
        <br>
        <h3>JSON Files</h3>
        
        @foreach ($json_files as $json_file)
             <!-- <p> {{ $json_file->title }}</p> -->
             <a href="{{ route('convertArrayToSheet',$json_file->id) }}" >{{ $json_file->title }} (Sheet Download)</a>
        @endforeach

      </div>
    </div>
</div>
</body>
  
</html>