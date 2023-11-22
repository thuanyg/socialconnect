

<?php
class Database
// <!-- Class để thực hiện kết nối - Thực thi câu lệnh SQL  -->
{
    private $server = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'mydb';
    private $conn = null;
    function Connect()
    {
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die . "Lỗi kết nối" . $this->conn->connect_error;
            return false;
        } else return true;
    }
    // RETURN ARRAY
    function Execute($sql)
    {
        if ($this->Connect()) {
            $result = $this->conn->query($sql);
            if (!$result) {
                $this->closeConnect();
                return false;
            } else {
                $this->closeConnect();
                return true;
            }
        }
    }

    function Query($sql)
    {
        if ($this->Connect()) {
            $result = $this->conn->query($sql);
            if (!$result) {
                $this->closeConnect();
                return null;
            } else {
                $data = array(); // Khởi tạo mảng data rỗng
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row; // Đẩy dòng dữ liệu vào mảng data
                }
                $this->closeConnect();
                return $data;
            }
        }
    }

    function escapedString($str){
        $escapedString = mysqli_real_escape_string(new mysqli($this->server, $this->username, $this->password, $this->dbname), $str);
        return $escapedString;
    }
    function closeConnect()
    {
        $this->conn->close();
    }
}

    // $db = new Database();
    // $data = $db->Execute("select * from users");
    // print_r($data);
