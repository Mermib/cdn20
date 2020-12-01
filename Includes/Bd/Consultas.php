<?php

date_default_timezone_set('America/Cancun');
require_once(__DIR__ . '/../Config.php');

Class Bd
{
    private static function Connection()
    {
        try
        {
            $cadena = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);
            $connection = new PDO($cadena, DB_USER, DB_PASS);
            return $connection;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function get_client_ip() 
    {
        $ipaddress = array();
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress["ip"] = explode(",",getenv('HTTP_CLIENT_IP'))[0];
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress["ip"] = explode(",",getenv('HTTP_X_FORWARDED_FOR'))[0];
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress["ip"] = explode(",",getenv('HTTP_X_FORWARDED'))[0];
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress["ip"] = explode(",",getenv('HTTP_FORWARDED_FOR'))[0];
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress["ip"] = explode(",",getenv('HTTP_FORWARDED'))[0];
        else if(getenv('REMOTE_ADDR'))
            $ipaddress["ip"] = explode(",",getenv('REMOTE_ADDR'))[0];
        else
            $ipaddress["ip"] = 'UNKNOWN';
    
        $v6 = preg_match("/^[0-9a-f]{1,4}:([0-9a-f]{0,4}:){1,6}[0-9a-f]{1,4}$/", $ipaddress["ip"]);
        $v4 = preg_match("/^([0-9]{1,3}\.){3}[0-9]{1,3}$/", $ipaddress["ip"]);
    
        if ( $v6 != 0 )
            $ipaddress["type"] = "IPv6";
        elseif ( $v4 != 0 )
            $ipaddress["type"] = "IPv4";
        else
            $ipaddress["type"] = "unknown";
    
        return $ipaddress['ip'];
    }

    public static function saveData($auth)
    {
        $conn = self::Connection();
        $creation = new DateTime();
        $expiration = new DateTime();
        $creation = $creation->format('Y-m-d H:i:s');
        $expiration = $expiration->add(new DateInterval('P0Y0M0DT0H30M'))->format('Y-m-d H:i:s');
        $ip = self::get_client_ip();
        $query = "INSERT INTO download_links(authorization, creation_date, expiration_date, client_ip, guid) values(?, '$creation', '$expiration', '$ip', UUID())";
        $response = $conn->prepare($query);
        $response->bindParam(1, $auth);
        return $response->execute();
    }

    public static function getUrl($auth)
    {
        $conn = self::Connection();
        $query = "SELECT * FROM download_links WHERE authorization = ?";
        $response = $conn->prepare($query);
        $response->bindParam(1, $auth);
        $response->execute();
        $guid = '';
        
        while($row = $response->fetch())
        {
            $guid = $row['guid'];
        }
        return $guid;
    }

    public static function getBuy($code)
    {
        $conn = self::Connection();
        $query = "SELECT * FROM download_links WHERE guid = ?";
        $response = $conn->prepare($query);
        $response->bindParam(1, $code);
        $response->execute();
        $row = $response->fetch();
        
        if($row)
        {
            return $row['used'] == '0';
        }
        else
        {
            return false;
        }
    }

    public static function changeStatus($id)
    {
        $conn = self::Connection();
        $query = "UPDATE download_links SET used = 1 WHERE guid = ?";
        $response = $conn->prepare($query);
        $response->bindParam(1, $id);
        return $response->execute();
    }
}