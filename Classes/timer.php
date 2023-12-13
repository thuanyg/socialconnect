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

    function timeAgo($dateString)
    {
        $currentDate = new DateTime();
        $pastDate = new DateTime($dateString);
        $timeDifference = $currentDate->getTimestamp() - $pastDate->getTimestamp();
        $seconds = floor($timeDifference);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);

        if ($days > 0) {
            return $days . " ngày trước";
        } elseif ($hours > 0) {
            return $hours . " giờ trước";
        } elseif ($minutes > 0) {
            return $minutes . " phút trước";
        } else {
            return "vài giây trước";
        }
    }

    function formatHourMinute($datetime)
    {
        $dateTime = new DateTime($datetime);
        // Định dạng theo giờ:phút (24-hour format)
        $timeString = $dateTime->format('H:i');
        return $timeString; // Output: "15:09"
    }
    
    function DateCompare($date1, $date2)
    {
        $dateTime1 = new DateTime($date1);
        $dateTime2 = new DateTime($date2);
    
        $dateString1 = $dateTime1->format('m-d');
        $dateString2 = $dateTime2->format('m-d');
    
        if ($dateString1 < $dateString2) {
            return 1; // $date1 đứng trước $date2 và chênh lệch không quá 3 ngày
        } elseif ($dateString1 > $dateString2) {
            return -1; // $date1 đứng sau $date2
        } else {
            return 0; // $date1 và $date2 bằng nhau hoặc chênh lệch ngày lớn hơn 3
        }
    }
    

    function calculateAge($birthday)
    {
        $currentDate = new DateTime(); // Ngày hiện tại
        $birthdate = new DateTime($birthday); // Ngày sinh

        // Tính khoảng cách giữa ngày sinh và ngày hiện tại
        $age = $birthdate->diff($currentDate)->y; // Lấy số tuổi

        return $age;
    }

}
