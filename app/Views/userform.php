<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
</head>
<body>
    <div class="container" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
    <div style='display:flex;justify-content:flex-start;padding-left:12px;' class='mb-3'>
        <h4>Add User</h4>
    </div>
    <form id='userform'>
        <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 mb-12">
                    <div class="col-lg-12 col-md-12 col-xs-12 mb-12 mb-3">
                        <div class="form-group">
                            <label for="form-label">First Name </label>
                            <input class="form-control" onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122" type="text" name="firstname" id="firstname" value="<?php if(isset($update)){ echo $update[0]['firstname'];}?>">
                            <div class="text-danger" id="error-firstname"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <label for="form-label">Last Name </label>
                            <input class="form-control" onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122" type="text" name="lastname" id="lastname" value="<?php if(isset($update)){ echo $update[0]['lastname'];}?>">
                            <div class="text-danger" id="error-lastname"></div>
                        </div>
                    </div> 
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <label for="form-label">Email </label>
                            <input class="form-control" type="text" name="email" id="email" value="<?php if(isset($update)){ echo $update[0]['email'];}?>">
                            <div class="text-danger" id="error-email"></div>
                        </div>
                    </div> 
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <label for="form-label">Password </label>
                            <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($update)){ echo $update[0]['password'];}?>">
                            <div class="text-danger" id="error-password"></div>
                        </div>
                    </div> 
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary col-lg-12 col-md-12 col-xs-12 mb-1 mt-2">Save</button>
                            <input type='hidden' id='autoid' name='autoid' value='<?php if(isset($update)){ echo $update[0]['id'];}?>';>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#userform').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('add_User')?>",
                    data:  new FormData(this) ,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data){
                        if (data.error) {
                            var i = 0;
                            $.each(data, function(key, value) {
                                if (value != '') {
                                    $("#error-" + key).html(value);
                                    $("#" + key).addClass("border-danger");
                                    if (i == 1) {
                                        $('#' + key).focus();
                                    }
                                    i++;
                                } else {
                                    $("#error-" + key).html(" ");
                                    $("#" + key).removeClass("border-danger");
                                }
                            });
                        }else{
                            Toastify({
                                text: "Saved Succesfully !",
                                style: {
                                    background:'green',
                                },
                                duration: 1000
                            }).showToast();
                            setTimeout(function(){
                                window.location.href = '<?= base_url('/usermaster')?>';
                            },1000);
                        }
                    }
                });
            }); 
        });
    </script>
</body>
</html>