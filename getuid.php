<?php
//
// getuid.php -- generate a unique ID for a corona App
//

define("DB_DSN",'rmiracle_getuid');
define("DB_HOST",'localhost');
define("DB_USER",'rmiracle_getuid');
define("DB_PASS",'Star*Wars');

// Connecting, selecting database
// print("connecting to database\n");
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS)
    or die('Could not connect: ' . mysql_error());
mysql_select_db(DB_DSN) or die('Could not select database');
    
if(isset($_GET)) {
    if(isset($_GET["appid"])) {
        //echo "logout";
        $appid = $_GET["appid"];
        $time = time();
        $query = sprintf('INSERT INTO uids (appid,time) VALUES ("%s", %d)', mysql_real_escape_string($appid), $time);  
        $dbresult = mysql_query($query, $link);
        if (!$dbresult) {
            //echo "query failed";
            $result = array();
            $result["result"] = 403;
            $result["message"] = mysql_error($link);
            echo json_encode($result);
            //mysql_free_result($dbresult);
            exit;
        }            
            
        $query = sprintf('SELECT id FROM uids WHERE appid="%s" AND time=%d', mysql_real_escape_string($appid), $time);
        $dbresult = mysql_query($query, $link);
        if (!$dbresult) {
            //echo "query failed";
            $result = array();
            $result["result"] = 403;
            $result["message"] = mysql_error($link);
            echo json_encode($result);
            //mysql_free_result($dbresult);
            exit;
        }
        $row = mysql_fetch_row($dbresult);
        $id = $row[0];
        $uid = base64_encode(sprintf("%s%d",$appid,$id));
        mysql_free_result($dbresult);
        $query = sprintf('UPDATE uids SET uid="%s" WHERE id=%d',$uid,$id);
        $dbresult = mysql_query($query,$link);
        if (!$dbresult) {
            //echo "query failed";
            $result = array();
            $result["result"] = 403;
            $result["message"] = mysql_error($link);
            echo json_encode($result);
            //mysql_free_result($dbresult);
            exit;
        }
        $result = array();
        $result["result"] = 200;
        $result["message"] = "Success";
        $result["uid"] = $uid;
        echo json_encode($result);
    } else {
        $result = array();
        $result["result"] = 400;
        $result["message"] = "Bad Request";
        echo json_encode($result);
    }
}
//echo "exiting";
exit;
?>