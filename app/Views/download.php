<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>

<body>
    <div class="container" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
        <div class='col-lg-10 col-md-8 col-xs-12'>
            <h4 class='mb-3'>Download CSV</h4>
            <div class='row' style='display:flex'>
                <div class="col-lg-4 col-md-12 col-xs-12">
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
                <div class="col-lg-4 col-md-12 col-xs-12">
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
                <div class="col-lg-4 col-md-12 col-xs-12" style='padding:0px'>
                    <label style='visibility:hidden' for="form-label">End Date </label>
                    <button type="button" id='download_Btn' class="btn btn-primary col-lg-12 col-md-12 col-xs-12">
                        <span style='visibility:hidden' id='loader2' class=" spinner-border spinner-border-sm" role="status" aria-hidden="true">
                        </span>
                    Download CSV</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row" style='justify-content:flex-end'>

        </div>
    <div class="container mb-3" style='margin-top:10px;padding:0px;display:flex;justify-content:center'>

    </div>
    <script>
        $(document).ready(function() {
            $("#date1").datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'bottom',
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate",'now');
            
            $("#date2").datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'bottom',
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate", 'now');

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
        });

        
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