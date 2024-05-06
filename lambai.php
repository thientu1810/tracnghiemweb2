<?php

include('includes/header.php');
include('includes/database.php');
if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_de_thi']) &&
isset($_POST['thoi_gian_lam_bai']) && isset($_POST['ten_de_thi'])) {
    $ma_de_thi = $_POST['ma_de_thi'];
    $ma_bai_thi = $_POST['ma_bai_thi'];
    $thoi_gian_lam_bai = $_POST['thoi_gian_lam_bai'];
    $ten_de_thi = $_POST['ten_de_thi'];
}
?>


<div class="container">
    <h1 class="text-center">
        <?php echo $ten_de_thi; ?>
    </h1>
    <div class="row">
        <div class="col-8">
            <div class="text-danger mb-2">
                <span style="font-weight: bold;">Số lần vi phạm (chuyển tab): </span> 
                <span>2</span>
            </div>
            <div class="mb-2">
                <span style="font-weight: bold;">Thời gian làm bài: </span>
                <span><?php echo $thoi_gian_lam_bai .":00"; ?></span>
            </div>
            <div class="mb-2">
                <span style="font-weight: bold;">Thời gian còn lại: </span>
                <span  id="time"><?php echo $thoi_gian_lam_bai .":00"; ?></span>
            </div>
        </div>
        <div class="col-4" >
        <ul>
        <div class="text-danger mb-2" style="font-weight: bold;">Quy định làm bài</div>
            <li>Không được tab ra trang khác hay ứng dụng khác.</li>
            <li>Nếu tab quá 3 lần sẽ tự động nộp bài.</li>
        </ul>
        </div>
    </div>
    
    <form action="ket_qua.php" method = "POST">
    <?php 
    $query = "select ch.* from chi_tiet_de_thi ctdt 
    join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi 
    join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi 
    where dt.ma_de_thi = $ma_de_thi";
    $select_cauhoi = mysqli_query($connect,$query);
    $i = 0;  
    while($row = mysqli_fetch_assoc($select_cauhoi)) {
        $i++;
        $ma_cau_hoi = $row['ma_cau_hoi'];
        $noi_dung = $row['noi_dung'];
        echo '
        <div class="question mb-3">';
        $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
        $select_cautl = mysqli_query($connect,$query2); 
        while($row2 = mysqli_fetch_assoc($select_cautl)) { 
            $la_dap_an = $row2['la_dap_an'];
            $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
            echo '<div class="row mb-2">'. 'Câu ' . $i . ': ' . $noi_dung .'</div>'; 
            echo '<div role="group" aria-label="Basic radio toggle button group">';
            $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
            $select_cautl = mysqli_query($connect,$query2); 
            $index = 0;
            while($row2 = mysqli_fetch_assoc($select_cautl)) {
                ++$index;
                $la_dap_an = $row2['la_dap_an'];
                $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
                $noi_dung_ctl = $row2['noi_dung'];
                
                switch($index) {
                    case 1: 
                        echo
                        '   
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> A </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 2: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> B </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 3: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> C </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 4: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> D </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                }
            }
        }
        echo '
        </div>
        ';
    }

    echo '</div>';
    ?>
    <input type="text" hidden name="ma_bai_thi" value=" <?php echo $ma_bai_thi; ?> ">
    <div class="button-submit">
        <input class="btn btn-primary" id="submitButton" type="submit" name="submit" value = "Submit">
    <div>
</form>
</div>

<script>
    let time = <?php echo $thoi_gian_lam_bai; ?>;
    function startCountdown() {
    var countdownElement = document.getElementById("time");
    var timeLeft = <?php echo $thoi_gian_lam_bai; ?> * 60;

    var countdownInterval = setInterval(function() {
        // Chuyển thời gian còn lại thành phút và giây
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;

        // Định dạng thời gian hiển thị (phút:giây)
        var formattedTime = minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
        
        // Hiển thị thời gian còn lại trong phần tử HTML
        countdownElement.textContent = formattedTime;

        // Giảm thời gian còn lại
        timeLeft--;

        // Kiểm tra nếu thời gian còn lại là âm hoặc bằng 0, dừng đếm ngược
        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            document.getElementById("submitButton").click();
        }
    }, 1000); // Cập nhật thời gian mỗi giây
}

document.getElementById("submitButton").addEventListener('click', function() {

})

window.onload = function() {
    startCountdown();
};
</script>

<?php
    include('includes/footer.php');
?>