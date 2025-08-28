<?php
include 'connect/connect.php';
use Connect as Connect;

class Functions{

    static function CreateConnection() : mysqli {
        $sql = (new Connect)->ConnectToSQLDB();
        return $sql;
    }

    function CheckPostRequest() : bool {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        }
        return false;
    }

    function ValidateURL($url) : bool{
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        }

        print_r("Invalid URL");
        return false;
    }

    function CreateShortCode() : string{
        while(1){
            $shortCode = substr(md5(uniqid(rand(), true)), 0, 6);
            if (Functions::CheckIfCodeExists($shortCode) == false) {
                break;
            }
        }

        return $shortCode;
    }

    function CheckIfCodeExists($code) : bool{
        $sql = Functions::CreateConnection();
        $query = "SELECT * FROM urls WHERE shorturl = '" . $code . "'";

        if(mysqli_query($sql, $query)->num_rows >= 1){
            mysqli_close($sql);
            return true;
        }

        mysqli_close($sql);
        return false;
    }

    function CheckIfWebUrlExists($url) : bool{
        $sql = Functions::CreateConnection();
        $query = "SELECT * FROM urls WHERE weburl = '" . $url . "'";

        if(mysqli_query($sql, $query)->num_rows >= 1){
            mysqli_close($sql);
            return true;
        }

        mysqli_close($sql);
        return false;
    }

    function RetrieveShortUrl($url) : string{
        $sql = Functions::CreateConnection();
        $query = "SELECT shorturl FROM urls WHERE weburl = '" . $url . "'";

        $result = mysqli_query($sql, $query);
        $row = mysqli_fetch_assoc($result);

        mysqli_close($sql);
        return $row['shorturl'];
    }

    function RetrieveUrl($code) : string{
        $sql = Functions::CreateConnection();
        $query = "SELECT weburl FROM urls WHERE shorturl = '" . $code. "'";

        $result = mysqli_query($sql, $query);
        $row = mysqli_fetch_assoc($result);

        mysqli_close($sql);
        return $row['weburl'];
    }

    function RedirectToUrl($shortCode){
        if (Functions::CheckIfCodeExists($shortCode) == false){
            die("Short URL does not exist.");
        }
        header('Location:' . Functions::RetrieveUrl($shortCode));
    }

    function SaveUrlToDatabase($code, $url){
        $sql = Functions::CreateConnection();
        $query = "INSERT INTO urls(shorturl,weburl) VALUES ('".$code."','".$url."')";

        mysqli_query($sql, $query);
        mysqli_close($sql);
        
        return;
    }

    function DisplayUrls(){
        $sql = Functions::CreateConnection();
        $query = "SELECT * FROM urls ORDER BY weburl ASC";
        $result = mysqli_query($sql, $query);
        
        print("<h3>All URLs</h3>");
        print("<table border='1'><tr><th>Short URL</th><th>Web URL</th></tr>");
        while($row = mysqli_fetch_assoc($result)){
            print_r("<tr><td><a href='./".$row['shorturl']."'>".$row['shorturl']."</a></td><td><a href='".$row['weburl']."'>".$row['weburl']."</a></td></tr>");
        }
        print("</table>");

        mysqli_close($sql);
        return;
    }
}
?>