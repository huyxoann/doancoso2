<?php
include 'includes/header.php';
require '../config/connectdb.php'
?>

<div class="container">
    <div class="row">
        <!-- content -->
        <div class="col-md-12">
            <div class="card">
            <!-- card-header -->
                <div class="card-header">
                    
                    <h1 style="text-align: center;"> Thêm công ty</h1>
                </div>
                <!-- card-body -->
                <div class="card-body">
                    <form action="code-list-corporation.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                        <div class="col-md-6">
                                <label for="">Corporation ID</label>
                                <input type="text" name="id_corp" placeholder="Enter Corporation ID" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Corporation Name</label>
                                <input type="text" name="corp_name" placeholder="Enter Corporation Name" class="form-control"required>
                            </div>
                            <div class="col-md-6">
                                <label for=""> Corporation field</label>
                                <select name="corp_field_id" class="form-control select" required>
                                    <option selected disabled>Select Corporation Field</option>
                                    <?php
                                    $query = "SELECT * FROM `corp_field`";
                                    $query_run = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $item) {
                                    ?>
                                        <option value="<?= $item['field_id'] ?>"><?php echo $item['field_id'].' - '.$item['field_name'] ?></option>
                                    <?php }
                                        }else {
                                            echo "No record avaliable";
                                        }  
                                    ?>
                                </select>
                            </div>

                           
                            <div class="col-md-6">
                                <label for="">Corporation email</label>
                                <input type="text" name="corp_mail" placeholder="Enter Corporation email" class="form-control">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="">Upload Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="description" rows="3" placeholder="Enter Description" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="">Website</label>
                                <input type="text" name="website" placeholder="Enter Corporation Website" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Corporation Address</label>
                                <input type="text" name="address" placeholder="Enter Corporation Address" class="form-control">
                            </div>
                            
                           
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mt-3" name="add_corporation_btn">Save</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>



        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>