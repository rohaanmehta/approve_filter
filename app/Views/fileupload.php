<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
</head>
<body>
    <div class="container">
    <div class="card  mt-3" style='border:none'>
        <form id='file_Upload'>
            <div class="col-lg-5 col-md-8 col-xs-12 login_Container">
                <div class="col">
                    <h3 class='mb-3'> Upload File </h3>
                    <div class="custom-file mb-3">
                    <div class="custom-file">
                        <input type="file" accept=".csv" id='file' name='file' class="custom-file-input" lang="pl-Pl">
                        <label class="custom-file-label" id='name' for="customFileLang"> Select File</label>
                    </div>
                        <a style='font-size:small' href='<?= base_url('public/uploads/new_test_file_sample.csv')?>' download> Download Sample File </a><br><br>
                    </div>
                </div>
                <div class="col mb-3">
                    <button type="submit" disabled id='upload_btn' class="btn btn-primary col-lg-12 col-md-12 col-xs-12 mb-3">
                        <span style='visibility:hidden' id='loader' class=" spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Upload
                    </button>
                    <div id='download' style='display:none'>
                        <a href='<?php $downloadname = date('d-M-Y').'.csv';
                                echo base_url('public/uploads'.'/'.$downloadname)?>' download>
                            <button type="button" id='download_Btn' class="btn btn-secondary col-lg-12 col-md-12 col-xs-12">Download</button>
                        </a>
                    </div>  
                </div>
            </div>
        </form>
    </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#file').change(function(){
                var name = $('#file').val();
                name = name.split('\\');
                name = name[name.length - 1];
                $('#name').html(name);
                $('#upload_btn').attr('disabled',false);
            });
            $('#download_Btn').click(function(){
                $('#download').css('display','none');
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('unlink')?>",
                    data: {},
                    dataType: "json",
                    success: function(data){
                        Toastify({
                            text: "File Downloaded !",
                            style: {
                                background:'green',
                            },
                            duration: 2000
                        }).showToast();
                    }
                });
            });     

            $('#file_Upload').submit(function(e){
                e.preventDefault();
                $('#loader').css('visibility','visible');
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('file_upload')?>",
                    data:  new FormData(this) ,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data){
                        console.log(data.success);
                        if(data.success == '400'){
                            setTimeout(function(){
                                $('#download').css('display','block');
                                $('#loader').css('visibility','hidden');
                            },2000);
                        }
                    }
                });
                $('#upload_btn').attr('disabled',true);
                // $('#name').html('Select File');
            }); 
        });
    </script>
</body>
</html>