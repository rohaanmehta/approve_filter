<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
</head>
<body>
<div class="container" style='background:#f7f7f7;padding:20px;border-radius:5px;margin-top:30px;'>
<div style='display:flex;justify-content:space-between' class='mb-3'>
<h4>User List</h4>
    <div class='col-lg-3 col-md-5 col-xs-12'>
        <a href='<?= base_url('userform')?>'>
            <button type="button" class="btn btn-primary col-lg-12 col-md-12 col-xs-12 mb-3">Add User</button>
        </a>
    </div>
</div>
<div class="table-responsive-sm">
    <table class="table table-bordered table-striped" id='myTable'>
        <thead>
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Last Login</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($result) && !empty($result)){ $i = 0;
                foreach($result as $row){?>
                    <tr>
                        <td><?= $result[$i]['firstname']?></td>
                        <td><?= $result[$i]['lastname']?></td>
                        <td><?= $result[$i]['email']?></td>
                        <td><?php if($result[$i]['lastlogin'] != '') { echo date('d-m-Y H:i:s',strtotime($result[$i]['lastlogin']));}?></td>
                        <td><div>
                                <a href='<?= base_url('/edit_user/'.$result[$i]['id'])?>' id='<?= $result[$i]['id']?>' class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a style='color:#fff' onclick= 'deleteid(this.id)' id='<?= $result[$i]['id']?>' class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
            <?php $i++;} }?>
        </tbody>
    </table>
</div>
</div>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    });

    function deleteid(id) {
        $.ajax({
            url: '<?php echo base_url('delete_User/'); ?>/' + id,
            Type: 'GET',
            success: function(data) {
                Toastify({
                    text: "Deleted Succesfully !",
                    style: {
                        background:'green',
                    },
                    duration: 1000
                }).showToast();
                setTimeout(function() {
                    location.href = "<?php echo base_url('usermaster'); ?>";
                }, 2000);
            }
        });
    }

</script>
</body>
</html>