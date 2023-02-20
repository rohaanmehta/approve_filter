<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #8860c9;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body>
    <form id='file_Upload'>
        <div class="container" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
            <div class='col-lg-5 col-md-8 col-xs-12'>
                <h4 class='mb-3'>Upload CSV</h4>
                <div class="custom-file mb-1" style='display:flex'>
                    <div class="custom-file mr-3">
                        <input type="file" accept=".csv" id='file' name='file' class="custom-file-input" lang="pl-Pl">
                        <label class="custom-file-label" id='name' for="customFileLang"> Select File</label>
                    </div>
                    <button type="submit" disabled id='upload_btn' class="btn btn-primary" style='width:200px;padding-left:0px;'>
                        <span style='visibility:hidden' id='loader' class=" spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Upload
                    </button>
                </div>
                <a style='font-size:small' href='<?= base_url('public/uploads/new_test_file_sample.csv') ?>' download> Download Sample File </a><br><br>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">

            </div>
        </div>
    </form>
    <div class="container mb-3" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
        <div style='display:flex;justify-content:space-between' class=''>
            <h4>CSV Details</h4>
            <div class='col-lg-3 col-md-5 col-xs-12'>
                <a href='<?= base_url('userform') ?>'>
                </a>
            </div>
        </div>
        <div class="row" style='justify-content:flex-end'>
            <div class="col-lg-3">
                <div class="wd-200 mg-b-20">
                    <label for="form-label">Start Date </label>
                    <div class="input-group">
                        <input class="form-control input-date" name="date1" id='date1'>
                        <div class="input-group-text" autocomplete="off">
                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="wd-200 mg-b-20">
                    <label for="form-label">End Date </label>
                    <div class="input-group">
                        <input class="form-control input-date" name="date2" id='date2'>
                        <div class="input-group-text" autocomplete="off">
                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table table-bordered table-striped" id='myTable'>
                <thead>
                    <tr>
                        <th width='90' scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Price</th>
                        <th scope="col">Date</th>
                        <th width='50' scope="col">Approved</th>
                        <th width='50' scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($result) && !empty($result)) {
                        $i = 0;
                        foreach ($result as $row) { ?>
                            <tr>
                                <td><?= '<img width="100" height="100" src=' . $result[$i]['image'] . '>' ?><?php if($result[$i]['bad_image'] == '1'){echo ' (Poor Image)';} ?></td>
                                <td><?= $result[$i]['name'] ?></td>
                                <td><?= $result[$i]['sku'] ?><?php if($result[$i]['repeated_sku'] == '1'){echo ' (Repeated SKU)';} ?></td>
                                <td><?= $result[$i]['price'] ?></td>
                                <td><?= date('d-m-Y',strtotime($result[$i]['date'])) ?></td>
                                <td style="text-align:center">
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" <?= $result[$i]['is_approved'] == '1' ? 'checked' : ''; ?> id='<?= $result[$i]['id'] ?>' onclick='approval(this.id)'>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </td>
                                <td style="text-align:center">
                                    <div>
                                        <a style='color:#fff' onclick='deleteid(this.id)' id='<?= $result[$i]['id'] ?>' class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                    <?php $i++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="container mb-3" style='margin-top:10px;padding:0px;display:flex;justify-content:center'>
        <div class="col-lg-4 col-md-4 col-xs-12" style='padding:0px'>
            <button type="button" id='download_Btn' class="btn btn-primary col-lg-12 col-md-12 col-xs-12">
                <span style='visibility:hidden' id='loader2' class=" spinner-border spinner-border-sm" role="status" aria-hidden="true">
                </span>
            Download CSV</button>
        </div>
    </div> -->
    <script>
        $(document).ready(function() {
            $("#date1").datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'bottom',
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate",'<?= $startdate ?>');
            
            $("#date2").datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'bottom',
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate", '<?= $enddate ?>');

            $("#date1").change(function(){
                var date = $("#date1").val();
                var date2 = $("#date2").val();
                window.location.href = '<?= base_url('csv')?>'+'/'+date +'|'+ date2;
            });
            $("#date2").change(function(){
                var date = $("#date1").val();
                var date2 = $("#date2").val();
                window.location.href = '<?= base_url('csv')?>'+'/'+date +'|'+ date2;
            });
            $('#download_Btn').click(function(){
                $('#loader2').css('visibility','visible');
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('download_csv') ?>",
                    data: {
                        startdate:$('#date1').val(),
                        enddate:$('#date2').val(),
                    },
                    dataType: "json",
                    success: function(data) {
                        var name = data.name;
                        setTimeout(function(){
                            $('#loader2').css('visibility','hidden');
                            window.location.href = '<?= base_url('public/uploads')?>'+'/'+name;
                            setTimeout(function(){
                                unlink(name);
                            },5000);
                        },10000);
                    }
                });
            });

            $('#file').change(function() {
                var name = $('#file').val();
                name = name.split('\\');
                name = name[name.length - 1];
                $('#name').html(name);
                $('#upload_btn').attr('disabled', false);
            });
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [   ]
            });

            $('#file_Upload').submit(function(e) {
                e.preventDefault();
                $('#loader').css('visibility', 'visible');
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('file_upload') ?>",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        console.log(data.success);
                        if (data.success == '400') {
                            setTimeout(function() {
                                $('#loader').css('visibility', 'hidden');
                                Toastify({
                                    text: "CSV Uploaded !",
                                    style: {
                                        background: 'green',
                                    },
                                    duration: 1000
                                }).showToast();
                                setTimeout(function() {
                                    location.href = "<?php echo base_url('csv'); ?>";
                                },1000);
                            }, 2000);
                        }
                    }
                });
                $('#upload_btn').attr('disabled', true);
            });
        });

        function deleteid(id) {
            $.ajax({
                url: '<?php echo base_url('delete_csv/'); ?>/' + id,
                Type: 'GET',
                success: function(data) {
                    Toastify({
                        text: "Deleted Succesfully !",
                        style: {
                            background: 'green',
                        },
                        duration: 1000
                    }).showToast();
                    setTimeout(function() {
                        location.href = "<?php echo base_url('csv'); ?>";
                    }, 2000);
                }
            });
        }

        function approval(id) {
            $.ajax({
                url: '<?php echo base_url('approve_csv/'); ?>/' + id,
                Type: 'GET',
                success: function(data) {}
            });
        }
        
        function unlink(name){
            $.ajax({
                type: "POST",
                url: "<?= base_url('unlink') ?>",
                data: {
                    name:name
                },
                dataType: "json",
                success: function(data) {
                }
            });
        }
    </script>
</body>

</html>