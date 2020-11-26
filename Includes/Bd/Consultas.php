<?php

date_default_timezone_set('America/Cancun');

Class Bd
{
    private static function Connection()
    {
        try
        {
            $cadena = sprintf('mysql:host=%s;dbname=%s', '127.0.0.1', 'nl20');
            $connection = new PDO($cadena, 'root', '');
            return $connection;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    function get_client_ip() 
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

    public static function saveData()
    {
        $conn = self::Connection();
        $auth = 'qwerty';
        $creation = new DateTime();
        $expiration = $creation->add(new DateInterval('P0Y0M0DT0H5M'));
        $creation = $creation->format('Y-m-d H:i:s');
        $expiration = $expiration->format('Y-m-d H:i:s');
        $ip = self::get_client_ip();
        $query = "INSERT INTO download_links(authorization, creation_date, expiration_date, client_ip, guid) values('$auth', '$creation', '$expiration', '$ip', UUID())";
        $response = $conn->prepare($query);
        return $response->execute();
    }

    public static function getData()
    {
        $conn = self::Connection();
        $query = "SELECT * FROM download_links";
        $response = $conn->prepare($query);
        $response->execute();
        $data = [];
        
        while($row = $response->fetch())
        {
            $data[] = [
                'id' => $row['id'],
                'authorization' => $row['authorization'],
                'creationDate' => $row['creation_date'],
                'expirationDate' => $row['expiration_date'],
                'clientIp' => $row['client_ip'],
                'guid' => $row['guid']
            ]; 
        }
        return $data;
    }
}

var_dump(Bd::saveData());