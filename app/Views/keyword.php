<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
</head>
<body>
<div class="container" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
    <div style='display:flex;justify-content:flex-start;padding-left:12px;' class='mb-3'>
        <h4>Add Keyword</h4>
    </div>
    <form id='keywordform'>
        <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 mb-12">
                    <div class="col-lg-12 col-md-12 col-xs-12 mb-12 mb-3">
                        <div class="form-group">
                            <label for="form-label">Brand Restrictions </label>
                            <textarea rows='5' class="form-control" name="brand_res" id="brand_res"><?php if(isset($update)){ echo $update[0]['brand_res'];}?></textarea>
                            <div class="text-danger" id="error-brand_res"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <label for="form-label">Item Restrictions </label>
                            <textarea rows='5' class="form-control" name="item_res" id="item_res"><?php if(isset($update)){ echo $update[0]['item_res'];}?></textarea>
                            <div class="text-danger" id="error-item_res"></div>
                        </div>
                    </div> 
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <label for="form-label">Shipping Restrictions </label>
                            <textarea rows='5' class="form-control" name="shipping_res" id="shipping_res"><?php if(isset($update)){ echo $update[0]['shipping_res'];}?></textarea>
                            <div class="text-danger" id="error-shipping_res"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3 col-md-12 col-xs-12 mb-12">
                        <div class="form-group">
                            <span class='text-danger' style='font-size:small'>* Keywords should be seperated with comma </span>
                            <button type="submit" class="btn btn-primary col-lg-12 col-md-12 col-xs-12 mb-1 mt-2">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        
        $(document).ready(function() {
            $('#keywordform').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('add_keyword')?>",
                    data:  new FormData(this) ,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data){
                        Toastify({
                            text: "Saved Succesfully !",
                            style: {
                                background:'green',
                            },
                            duration: 1000
                        }).showToast();
                    }
                });
            }); 
        });
    </script>
</body>
</html>