<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Đăng tuyển | NiceJob</title>
    <link rel="stylesheet" href="../CSS/bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/stylechung.css">
    <link rel="stylesheet" href="../css/post_recruit.css">
    <script src="../css/bootstrap.bundle.min.js"></script>
    <script src="../css/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php require_once('../includes/header.php'); ?>
    <div class="container">
        <div class="row text-center">
            <div class="title_my_recruit col-md-6">
                <h2>Công việc đã đăng: </h2>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddJob">Thêm +</button>
            </div>
        </div>
        <div class="posted">
            <?php
            require('../html/modules/connection.php');
            $id_user = $_COOKIE['id_user'];
            // $query_get_post = "SELECT jobs.job_id, jobs.job_name, jobs.num_of_recruit, jobs.gender, jobs.work_address, jobs.job_description, corporation.image, corporation.corp_name, career.career_name, experience.exp_name, jobs.employer_id, province.province_name, level.level_name, way_to_work.way_to_work_name, salary.salary_name FROM (((((((jobs INNER JOIN corporation ON jobs.corp_id = corporation.id_corp) INNER JOIN career ON career.career_id = jobs.career_id) INNER JOIN experience ON experience.exp_id = jobs.exp_id) INNER JOIN province ON province.province_id = jobs.job_id) INNER JOIN level ON level.level_id = jobs.level_id) INNER JOIN way_to_work ON way_to_work.way_to_work_id = jobs.way_to_work_id) INNER JOIN salary ON salary.salary_id = jobs.salary_id)";
            $query_get_post = "SELECT jobs.job_name, jobs.job_id, corporation.corp_name, corporation.id_corp, corporation.website,corporation.image, salary.salary_name, province.province_name  FROM (((jobs INNER JOIN corporation ON jobs.corp_id = corporation.id_corp) INNER JOIN province ON province.province_id = jobs.province_id) INNER JOIN salary ON salary.salary_id = jobs.salary_id) WHERE employer_id = '$id_user'";
            $result = $conn->query($query_get_post);

            if (mysqli_num_rows($result) > 0) {

                for ($i = 1; $i <= mysqli_num_rows($result); $i++) {
                    $rows = mysqli_fetch_assoc($result);
            ?>
                    <form action="" method="post">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="jobs_item border p-3 d-flex form-control">
                                <div class="jobs_item_element logo-company p-2">
                                    <h5 class="name-job"><?php echo $i ?></h5>
                                </div>
                                <div class="d-flex justify-self-between">
                                    <div class="jobs_item_element info-company">
                                        <div class="">
                                            <a href="<?php echo '../html/job_detail.php?job_id=' . $rows['job_id'] ?>">
                                                <h5 class="name-job"><?php echo $rows['job_name'] ?></h5>
                                            </a>
                                            <a href="">
                                                <p class="name-company"><?php echo $rows['corp_name'] ?></p>
                                            </a>
                                            <span class="border border-primary p-2 rounded rounded-2"><?php echo $rows['salary_name'] ?></span>
                                            <span class="border border-primary p-2 rounded rounded-2"><?php echo $rows['province_name'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="">
                                    <form action="../html/modules/modal_job.php" method="post"></form>
                                    <a href="../html/view_application.php?job_id=<?php echo $rows['job_id'] ?>" type="button" class="form-control">Xem đơn tuyển</a>
                                    <button class="form-control" data-bs-toggle="modal" data-bs-target="#viewApplication" data-job_name="<?php echo $rows['job_name'] ?>"></button>
                                    <!-- <a class="form-control btn btn-outline-primary" type="submit" data-bs-toggle="modal" data-bs-target="#modalEditJob">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                </a>
                                <a class="form-control btn btn-outline-danger" type="button">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a> -->
                                </div>
                            </div>
                        </div>
                    </form>
            <?php }
            }
            ?>
        </div>
    </div>
    <!-- Modal Add -->
    <div class="modal fade" id="modalAddJob" tabindex="-1" aria-labelledby="modalAddJob" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddJob">Đăng thêm công việc mới</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../html/modules/add_job.php" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>Tên công việc:</h4>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="job_name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <h4>Mô tả công việc:</h4>
                            </div>
                            <div class="row">
                                <textarea name="job_detail" cols="30" rows="15" class="form-control ms-2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Địa chỉ:</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="address" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="col-md-12">
                                    <tr>
                                        <td>
                                            <h4>Giới tính</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="0">Nam</option>
                                                <option value="1">Nữ</option>
                                                <option value="2">Không yêu cầu</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Kinh nghiệm</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="exp">
                                                <?php include('../html/modules/import_exp.php') ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Chức vụ</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="level">
                                                <?php include('../html/modules/import_level.php') ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Mức lương</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="salary">
                                                <?php include('../html/modules/import_salary.php') ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Hạn nộp hồ sơ:</h4>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="deadline">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="col-md-12">
                                    <tr>
                                        <td>
                                            <h4>Công việc</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="career">
                                                <?php include('../html/modules/import_career.php') ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Số lượng tuyển</h4>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="num_of_recruit">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Tỉnh/TP</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="province">
                                                <?php include('../html/modules/import_province.php') ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Phương thức làm việc</h4>
                                        </td>
                                        <td>
                                            <select class="form-control" name="way_to_work">
                                                <?php include('../html/modules/import_way_to_work.php') ?>
                                            </select>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="post">Đăng</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal view application -->
    <!-- <div class="modal fade" id="viewApplication" tabindex="-1" aria-labelledby="viewApplicationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicationLabel">Công việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="">
                            <h3>Danh sách người xin việc:</h3>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#viewApplication').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var job_name = button.data('job_name') // Extract info from data-* attributes
                // We are jquery here to update the modal's content
                var modal = $(this)
                modal.find('.modal-title').text('Đơn xin việc ' + job_name)
                modal.find('.modal-body input').val(job_name)
            })
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script> -->

</body>

</html>