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
        $seconds = abs($timeDifference);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = $pastDate->diff($currentDate)->m;
        $weeks = floor($days / 7);

        if ($days >= 30) {
            return $months . " tháng trước";
        } elseif ($days >= 7) {
            return $weeks . " tuần trước";
        } elseif ($days >= 1) {
            return $days . " ngày trước";
        } elseif ($hours >= 1) {
            return $hours . " giờ trước";
        } elseif ($minutes >= 1) {
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
            return 1; // $date1 đứng trước $date2
        } elseif ($dateString1 > $dateString2) {
            return -1; // $date1 đứng sau $date2
        } else {
            return 0; // $date1 và $date2 bằng nhau 
        }
    }

    function DayDifference($date1, $date2)
    {
        $dateTime1 = new DateTime($date1);
        $dateTime2 = new DateTime($date2);

        // Lấy chỉ tháng và ngày
        $ngay1_month_day = $dateTime1->format('m-d');
        $ngay2_month_day = $dateTime2->format('m-d');

        // Tạo một DateTime mới dựa trên cùng một năm
        $dummyYear = 2000; // Năm "giả" không quan trọng, chỉ để tạo đối tượng DateTime
        $dummyDate1 = DateTime::createFromFormat('Y-m-d', $dummyYear . '-' . $ngay1_month_day);
        $dummyDate2 = DateTime::createFromFormat('Y-m-d', $dummyYear . '-' . $ngay2_month_day);
        if ($dummyDate1 > $dummyDate2) {
            // $dummyDate1 đại diện cho ngày lớn hơn $dummyDate2
            // Tính toán độ chênh lệch giữa hai ngày
            $difference = $dummyDate1->diff($dummyDate2);
            return $difference->days;
        }
        return 1111;
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
