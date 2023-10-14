<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 9 JavaScript File Upload with Progress Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 900px">
         
        <div class="alert alert-primary mb-4 text-center">
           <h2 class="display-6">Laravel 9 JavaScript File Upload with Progress Bar</h2>
        </div>  
        @csrf
        <div class="card">
            <div class="card-header">Select File</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td width="50%" align="right"><b>Select File</b></td>
                        <td width="50%">
                            <input type="file" id="select_file" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br />
        <div class="progress" id="progress_bar" style="display:none;height:50px; line-height: 50px;">

            <div class="progress-bar" id="progress_bar_process" role="progressbar" style="width:0%;">0%</div>

        </div>

        <div id="uploaded_image" class="row mt-5"></div>
    </div>
    
</body>
</html>

<script>

var file_element = document.getElementById('select_file');

var progress_bar = document.getElementById('progress_bar');

var progress_bar_process = document.getElementById('progress_bar_process');

var uploaded_image = document.getElementById('uploaded_image');

file_element.onchange = function(){

    if(!['image/jpeg', 'image/png'].includes(file_element.files[0].type))
    {
        uploaded_image.innerHTML = '<div class="alert alert-danger">Selected File must be .jpg or .png Only</div>';

        file_element.value = '';
    }
    else
    {
        var form_data = new FormData();

        form_data.append('sample_image', file_element.files[0]);

        form_data.append('_token', document.getElementsByName('_token')[0].value);

        progress_bar.style.display = 'block';

        var ajax_request = new XMLHttpRequest();

        ajax_request.open("POST", "{{ route('upload_file.upload') }}");

        ajax_request.upload.addEventListener('progress', function(event){

            var percent_completed = Math.round((event.loaded / event.total) * 100);

            progress_bar_process.style.width = percent_completed + '%';

            progress_bar_process.innerHTML = percent_completed + '% completed';

        });

        ajax_request.addEventListener('load', function(event){

            var file_data = JSON.parse(event.target.response);

            uploaded_image.innerHTML = '<div class="alert alert-success">Files Uploaded Successfully</div><img src="'+file_data.image_path+'" class="img-fluid img-thumbnail" />';

            file_element.value = '';

        });

        ajax_request.send(form_data);


    }

};

</script>