<?php
class Timer
// <!-- Tính toán thời gian (VD thời gian đăng bài viết, thời gian kết bạn, thời gian comment ...) -->
{
    // tính thời gian kể từ $time
    function TimeSince($datetime)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDateTime = time();

        // Tính khoảng thời gian
        $timeDifference = $currentDateTime - strtotime($datetime);

        // Chuyển khoảng thời gian thành giờ, phút, giây
        $hours = floor($timeDifference / 3600);
        $minutes = floor(($timeDifference % 3600) / 60);
        $seconds = $timeDifference % 60;

        $time = array(
            "hours" => $hours,
            "minutes" => $minutes,
            "seconds" => $seconds
        );
        return $time;
    }

    function formatHourMinute($datetime){
        $dateTime = new DateTime($datetime);
        // Định dạng theo giờ:phút (24-hour format)
        $timeString = $dateTime->format('H:i');
        return $timeString; // Output: "15:09"
    }
}
