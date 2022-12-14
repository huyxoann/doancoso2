<?php
require_once('../html/modules/connection.php');
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $query_get_job_data = "SELECT * FROM (((((((jobs INNER JOIN corporation ON jobs.corp_id = corporation.id_corp) INNER JOIN career ON career.career_id = jobs.career_id) INNER JOIN experience ON experience.exp_id = jobs.exp_id) INNER JOIN province ON province.province_id = jobs.job_id) INNER JOIN level ON level.level_id = jobs.level_id) INNER JOIN way_to_work ON way_to_work.way_to_work_id = jobs.way_to_work_id) INNER JOIN salary ON salary.salary_id = jobs.salary_id) WHERE job_id = $job_id";
    $result = $conn->query($query_get_job_data);
    $employee_id = isset($_COOKIE['id_user']) ? $_COOKIE['id_user'] : '';
    $query_get_cv_exist = "SELECT employee_id, job_id FROM application WHERE employee_id = '$employee_id' AND job_id = '$job_id'";

    // $query_get_num_application = "SELECT num_of_recruit FROM application INNER JOIN jobs ON jobs.job_id = application.job_id WHERE job_id = '$job_id'";
    // $result_query_get_num_application = mysqli_query($conn, $query_get_num_application);
    // $num_application = mysqli_fetch_assoc($result_query_get_num_application);

    if (mysqli_num_rows($result) > 0) {
        $GLOBALS['rows'] = mysqli_fetch_assoc($result);
    }
    $set_expiration_state = "UPDATE jobs SET state = 0 WHERE DATEDIFF(deadline, CURRENT_DATE) < 0";
    $conn->query($set_expiration_state);
} else {
    header("Location: ../html/page_404.php");
}


function date_formatting($date)
{
    $time = strtotime($date);
    $date_formatted = date('d-m-Y', $time);
    echo  $date_formatted;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $rows['job_name'] ?></title>
    <link rel="stylesheet" href="../CSS/bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/stylechung.css">
    <link rel="stylesheet" href="../css/post_recruit.css">
    <script src="../css/bootstrap.bundle.min.js"></script>
    <script src="../css/jquery-3.6.0.min.js"></script>

</head>

<body>
    <?php require('../includes/header.php') ?>
    <div class="content container">
        <div class="row"></div>
        <?php
        if ($rows['state'] == 0) { ?>
            <div class="alert">
                <p class="text-danger">C??ng vi???c n??y ???? h???t h???n tuy???n.</p>
            </div>
        <?php }
        ?>

        <div class="row jobs_item m-3 border border-start-5 pt-3 rounded">
            <div class="col-md-9 jobs_item_element">
                <div class="col-md-2">
                    <a href="<?php echo '../html/cong_ty_detail.php?corp_id=' . $rows['corp-id'] ?>">
                        <img src="<?php echo '../html/picture/corps/' . $rows['image'] ?>" alt="img" style="max-width: 100px; max-height: 100px; min-width: 100px; min-height: 100px;">
                    </a>
                </div>
                <div class="col-md-10">
                    <div class="title_text">
                        <h4><?php echo $rows['job_name'] ?></h4>
                    </div>
                    <div class="title_text">
                        <a href="corp_details.php?id_corp=<?= $rows['corp_id'] ?>">
                            <h4><?php echo $rows['corp_name'] ?></h4>
                        </a>
                    </div>
                    <div>
                        <p>
                            <ion-icon name="time"></ion-icon>
                            H???n n???p: <?php date_formatting($rows['deadline']) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex flex-column">
                <?php
                $query_check_expire_date = "SELECT state FROM jobs WHERE job_id = '$job_id' AND state='0'";
                if (mysqli_num_rows(mysqli_query($conn, $query_check_expire_date))) { ?>
                    <div class="">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyJob" disabled>
                            <ion-icon name="mail" class="me-3"></ion-icon>???ng tuy???n ngay
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyJob">
                            <ion-icon name="mail" class="me-3"></ion-icon>???ng tuy???n ngay
                        </button>
                    </div>
                <?php }
                $query_check_save = "SELECT * FROM save WHERE employee_id = '$employee_id' AND job_id = '$job_id'";
                if (mysqli_num_rows(mysqli_query($conn, $query_check_save)) != 0) { ?>
                    <div class="mt-3">
                        <form action="../html/saving_post.php" method="post">
                            <input type="text" name="job_id" value="<?= $rows['job_id'] ?>" style="display: none;">
                            <input type="text" name="state" value="1" style="display: none;">
                            <button class="btn btn-secondary" style="min-width: 147.08px;" type="submit" name="add">
                                <ion-icon name="heart" class="me-3"></ion-icon>???? l??u
                            </button>
                        </form>
                    </div>
                <?php } else { ?>
                    <div class="mt-3">
                        <form action="../html/saving_post.php" method="post">
                            <input type="text" name="job_id" value="<?= $rows['job_id'] ?>" style="display: none;">
                            <input type="text" name="state" value="0" style="display: none;">
                            <button class="btn btn-outline-secondary" style="min-width: 147.08px;" type="submit" name="add">
                                <ion-icon name="heart" class="me-3"></ion-icon>L??u tin
                            </button>
                        </form>
                    </div>
                <?php }
                ?>

            </div>
        </div>
        <div class="row border border-start-5 rounded">
            <div class="">
                <h3 class="mt-3">Chi ti???t tuy???n d???ng</h3>
            </div>
            <div class="detail_box p-3 d-flex flex-column">
                <h4><u>Th??ng tin chung:</u></h4>
                <table>
                    <tr>
                        <td>
                            <div class="salary">
                                <b>
                                    <ion-icon name="cash-outline"></ion-icon>M???c l????ng
                                </b>
                                <p><?php echo $rows['salary_name'] ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="num_of_recruit">
                                <b>
                                    <ion-icon name="people-outline"></ion-icon>S??? l?????ng tuy???n
                                </b>
                                <p><?php echo $rows['num_of_recruit'] ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <div class="way_to_work">
                                <b>
                                    <ion-icon name="briefcase-outline"></ion-icon>H??nh th???c l??m vi???c
                                </b>
                                <p><?php echo $rows['way_to_work_name'] ?></p>
                            </div>
                        </td>

                        <td>
                            <div class="level">
                                <b>
                                    <ion-icon name="medal-outline"></ion-icon>C???p b???c
                                </b>
                                <p><?php echo $rows['level_name'] ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <div class="gender">
                                <b>
                                    <ion-icon name="transgender-outline"></ion-icon>Gi???i t??nh
                                </b>
                                <p><?php if ($rows['gender_job'] == 0) {
                                        echo "Nam";
                                    } elseif ($rows['gender_job'] == 1) {
                                        echo "N???";
                                    } else {
                                        echo "Kh??ng y??u c???u";
                                    } ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="epx">
                                <b>
                                    <ion-icon name="hourglass-outline"></ion-icon>Kinh nghi???m
                                </b>
                                <p><?php echo $rows['exp_name'] ?></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="address">
                <h4><u>?????a ch??? l??m vi???c:</u></h4>
                <p><?php echo $rows['work_address'] ?></p>
            </div>
            <div class="job_detail" style="text-align: justify;">
                <h4><u>M?? t???: </u></h4>
                <p><?php echo $rows['job_description'] ?></p>
            </div>
        </div>
        <div class="row border border-start-5">
            <div class="cach_thuc_tuyen">
                <h3>C??ch ???ng tuy???n</h3>
            </div>
            <div class="button pb-3">
                <p>???ng vi??n n???p h??? s?? b???ng c??ch nh???n v??o n??t "???ng tuy???n ngay"</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyJob">
                    <ion-icon name="mail" class="me-3"></ion-icon>???ng tuy???n ngay
                </button>
                <button class="btn btn-outline-secondary" style="min-width: 147.08px;">
                    <ion-icon name="heart" class="me-3"></ion-icon>L??u tin
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Apply Job -->
    <div class="modal fade" id="applyJob" tabindex="-1" aria-labelledby="applyJobLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php if (mysqli_num_rows(mysqli_query($conn, $query_get_cv_exist)) > 0) { ?>
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="text-danger">B???n ???? n???p cv cho c??ng vi???c n??y r???i!</h4>
                        <p>B???n c?? th??? t??m c??c c??ng vi???c kh??c t???i <a href="../html/vieclam.php">????Y</a></p>
                    </div>

                <?php } elseif (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['role']) && $_COOKIE['role'] == 0) { ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="applyJobLabel">???ng tuy???n
                            <a href="../html/job_detail.php?job_id=<?= $rows['job_id'] ?>">
                                <?= $rows['job_name'] ?>
                            </a>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../html/modules/send_application.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <h4>Ch???n h??? s?? ????? g???i: </h4>
                            <?php
                            $id_user = $_COOKIE['id_user'];
                            $query_get_cv = "SELECT * FROM cv INNER JOIN career ON career.career_id = cv.career_id WHERE id_user = '$id_user'";
                            $result_query_get_cv = $conn->query($query_get_cv);
                            if (mysqli_num_rows($result_query_get_cv) > 0) {
                                while ($cv_data = mysqli_fetch_assoc($result_query_get_cv)) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cv_selected" id="flexRadioDefault1" value="<?= $cv_data['cv_id'] ?>" required>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            <?= $cv_data['cv_name'] . ' (' . $cv_data['career_name'] . ')' ?>
                                        </label>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="alert-secondary">
                                    Kh??ng c?? CV n??o ???????c t???o. Vui l??ng t???o ????? s??? d???ng.
                                </div>
                            <?php }
                            ?>
                            <h4>Vi???t m?? t??? gi???i thi???u b???n th??n: </h4>
                            <textarea name="introduce" id="introduce" cols="30" rows="10" class="form-control" required></textarea>
                            <input type="text" name="job_id" id="job_id" class="form-control" value="<?= $rows['job_id'] ?>" style="display: none;">
                            <input type="text" name="pre_href" id="pre_href" class="form-control" value="<?= $pre_href ?>" style="display: none;">

                            <div class="note">
                                <h4>L??u ??</h4>
                                <p>1. ???ng vi??n n??n l???a ch???n ???ng tuy???n b???ng CV Online & vi???t th??m mong mu???n t???i ph???n th?? gi???i thi???u ????? ???????c Nh?? tuy???n d???ng xem CV s???m h??n.</p>
                                <p>2. ????? c?? tr???i nghi???m t???t nh???t, b???n n??n s??? d???ng c??c tr??nh duy???t ph??? bi???n nh?? Google Chrome ho???c Firefox.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">????ng</button>
                            <input type="submit" class="btn btn-primary" name="apply" value="???ng tuy???n">
                        </div>
                    </form>
                    <!-- <?php } elseif (mysqli_num_rows($result_query_get_num_application) >= $num_application['num_of_recruit']) { ?>
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="text-danger"></h4>
                        <small>Note: Ch??? t??i kho???n ng?????i ???ng tuy???n m???i th???c hi???n h??nh ?????ng n??y!</small>
                        <p>Click v??o <a href="../html/sign_out.php">????Y</a> ????? nh???p v???i t?? c??ch ng?????i ???ng tuy???n.</p>
                    </div> -->
                <?php } else { ?>
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="text-danger">Vui l??ng ????ng nh???p tr?????c khi th???c hi???n ???ng tuy???n.</h4>
                        <small>Note: Ch??? t??i kho???n ng?????i ???ng tuy???n m???i th???c hi???n h??nh ?????ng n??y!</small>
                        <p>Click v??o <a href="../html/sign_out.php">????Y</a> ????? nh???p v???i t?? c??ch ng?????i ???ng tuy???n.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php require('../includes/footer.php') ?>

</body>

</html>