<?php
/**
 * Created by PhpStorm.
 * User: PHPDuck.nl
 * Date: 15-03-16
 * Time: 09:48
 * Version: 1.0;
 *
 * Use this file only if u are too lazy to rebuild your PHP / Mysql script
 * People, stop using mysql_ please and go to mysqli_ or PDO
 */

!defined ('MYSQL_CLIENT_COMPRESS') && define ('MYSQL_CLIENT_COMPRESS', 32);
!defined ('MYSQL_CLIENT_IGNORE_SPACE') && define ('MYSQL_CLIENT_IGNORE_SPACE', 256);
!defined ('MYSQL_CLIENT_INTERACTIVE') && define ('MYSQL_CLIENT_INTERACTIVE', 1024);
!defined ('MYSQL_CLIENT_SSL') && define ('MYSQL_CLIENT_SSL', 2048);
!defined ('MYSQL_ASSOC') && define ('MYSQL_ASSOC', 1);
!defined ('MYSQL_BOTH') && define ('MYSQL_BOTH', 3);
!defined ('MYSQL_NUM') && define ('MYSQL_NUM', 2);

if (!function_exists('mysql_connect')) {
    /**
     * var connection
     */
    $mysqlConnection = NULL;

    /**
     * @param null $server
     * @param null $username
     * @param null $password
     * @param bool $new_link
     * @param int $client_flags
     * @return mysqli
     */
    function mysql_connect($server = NULL, $username = NULL, $password = NULL, $new_link = false, $client_flags = 0)
    {
        global $mysqlConnection;
        $server = ($server !== NULL) ? $server : ini_get("mysqli.default_host");
        $username = ($username !== NULL) ? $username : ini_get("mysqli.default_user");
        $password = ($password !== NULL) ? $password : ini_get("mysqli.default_pw");
        return $mysqlConnection = mysqli_connect($server, $username, $password, "", ini_get("mysqli.default_port"), ini_get("mysqli.default_socket"));
    }


    /**
     * @param $query
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_query($query, $link_identifier = NULL)
    {
        global $mysqlConnection;
        $link = ($link_identifier != NULL) ? $link_identifier : $mysqlConnection;
        return mysqli_query($link, $query, $resultmode = MYSQLI_STORE_RESULT);
    }


    /**
     * @param $link_identifier
     * @return bool
     */
    function mysql_close($link_identifier = NULL)
    {
        global $mysqlConnection;
        $mysqlConnection = $link_identifier != NULL ? $mysqlConnection : NULL;
        return mysqli_close(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return int
     */
    function mysql_affected_rows($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_affected_rows(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return string
     */
    function mysql_client_encoding($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_character_set_name(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $database_name
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_create_db($database_name, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysql_query('CREATE DATABASE "' . $database_name . '"', ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $database_name
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_createdb($database_name, $link_identifier = NULL)
    {
        return mysql_create_db($database_name, $link_identifier);
    }

    /**
     * @param $result
     * @param $row_number
     * @return bool
     */
    function mysql_data_seek($result, $row_number)
    {
        return mysqli_data_seek($result, $row_number);
    }

    /**
     * @param $result
     * @param $row
     * @param null $field
     * @return mixed
     */
    function mysql_db_name($result, $row, $field = NULL)
    {
        return $result[$row];
    }

    /**
     * @param $result
     * @param $row
     * @param null $field
     * @return mixed
     */
    function mysql_dbname($result, $row, $field = NULL)
    {
        return mysql_db_name($result, $row, $field);
    }

    /**
     * @param null $link_identifier
     * @return array
     */
    function mysql_list_dbs($link_identifier = NULL)
    {
        global $mysqlConnection;
        $res = mysql_query("SHOW DATABASES", ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
        $array = array();
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row['Database'];
        }
        return $array;
    }

    /**
     * @param null $link_identifier
     * @return array
     */
    function mysql_listdbs($link_identifier = NULL)
    {
        return mysql_list_dbs($link_identifier);
    }

    /**
     * @param $database_name
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_drop_db($database_name, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysql_query('DROP DATABASE "' . $database_name . '"', ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return int
     */
    function mysql_errno($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_errno(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return string
     */
    function mysql_error($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_error(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $unescaped_string
     * @return string
     */
    function mysql_escape_string($unescaped_string)
    {
        return mysql_real_escape_string($unescaped_string);
    }

    /**
     * @param $unescaped_string
     * @param null $link_identifier
     * @return string
     */
    function mysql_real_escape_string($unescaped_string, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_real_escape_string(($link_identifier != NULL ? $link_identifier : $mysqlConnection), $unescaped_string);
    }

    /**
     * @param $result
     * @param int $result_type
     * @return array|null
     */
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        return mysqli_fetch_array($result, $result_type);
    }

    /**
     * @param $result
     * @return array|null
     */
    function mysql_fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $result
     * @param int $field_offset
     * @return bool|object
     */
    function mysql_fetch_field($result, $field_offset = 0)
    {
        return mysqli_fetch_field($result);
    }

    /**
     * @param $result
     * @return array|bool
     */
    function mysql_fetch_lengths($result)
    {
        return mysqli_fetch_lengths($result);
    }

    /**
     * @param $result
     * @param string $class_name
     * @param array $params
     * @return null|object
     */
    function mysql_fetch_object($result, $class_name = "stdClass", $params = array())
    {
        return mysqli_fetch_object($result, $class_name, $params);
    }

    /**
     * @param $result
     * @return array|null
     */
    function mysql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool|string
     */
    function mysql_field_flags($result, $field_offset)
    {
        // Based on http://php.net/manual/en/mysqli-result.fetch-fields.php#101828
        $object = mysqli_fetch_field_direct($result, $field_offset);
        if (!$object) {
            return false;
        }
        $array = array();
        if ($object->flags & 1) {
            $array[] = "not_null";
        }
        if ($object->flags & 2) {
            $array[] = "primary_key";
        }
        if ($object->flags & 4) {
            $array[] = "unique_key";
        }
        if ($object->flags & 8) {
            $array[] = "multiple_key";
        }
        if ($object->flags & 16) {
            $array[] = "blob";
        }
        if ($object->flags & 32) {
            $array[] = "unsigned";
        }
        if ($object->flags & 64) {
            $array[] = "zerofill";
        }
        if ($object->flags & 128) {
            $array[] = "binary";
        }
        if ($object->flags & 256) {
            $array[] = "enum";
        }
        if ($object->flags & 512) {
            $array[] = "auto_increment";
        }
        if ($object->flags & 1024) {
            $array[] = "timestamp";
        }

        return implode(" ", $array);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool|string
     */
    function mysql_fieldflags($result, $field_offset)
    {
        return mysql_field_flags($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_field_len($result, $field_offset)
    {
        $object = mysqli_fetch_field_direct($result, $field_offset);
        if (!$object) {
            return false;
        }

        return $object->length;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_fieldlen($result, $field_offset)
    {
        return mysql_field_len($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_field_seek($result, $field_offset)
    {
        return mysqli_field_seek($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_field_table($result, $field_offset)
    {
        $object = mysqli_fetch_field_direct($result, $field_offset);
        if (!$object) {
            return false;
        }
        return $object->table;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_fieldtable($result, $field_offset)
    {
        return mysql_field_table($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool|string
     */
    function mysql_field_type($result, $field_offset)
    {
        //http://php.net/manual/en/mysqli-result.fetch-field-direct.php#89117
        $object = mysqli_fetch_field_direct($result, $field_offset);
        if (!$object) {
            return false;
        }

        $mysql_data_type_hash = array(
            0 => 'decimal',
            1 => 'tinyint',
            2 => 'smallint',
            3 => 'int',
            4 => 'float',
            5 => 'double',
            6 => 'null',
            7 => 'timestamp',
            8 => 'bigint',
            9 => 'mediumint',
            10 => 'date',
            11 => 'time',
            12 => 'datetime',
            13 => 'year',
            13 => 'newdate',
            16 => 'bit',
            247 => 'enum',
            //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
            253 => 'varchar',
            254 => 'char',
            246 => 'decimal'
        );

        return (isset($mysql_data_type_hash[$object->type]) ? $mysql_data_type_hash[$object->type] : 'unknown');
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool|string
     */
    function mysql_fieldtype($result, $field_offset)
    {
        return mysql_field_type($result, $field_offset);
    }

    /**
     * @param $result
     * @return bool
     */
    function mysql_free_result($result)
    {
        mysqli_free_result($result);
        return true;
    }

    /**
     * @param $result
     * @return bool
     */
    function mysql_freeresult($result)
    {
        return mysql_free_result($result);
    }

    /**
     * @return string
     */
    function mysql_get_client_info()
    {
        global $mysqlConnection;
        return mysqli_get_client_info($mysqlConnection);
    }

    /**
     * @param null $link_identifier
     * @return string
     */
    function mysql_get_host_info($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_get_host_info(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return int
     */
    function mysql_get_proto_info($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_get_proto_info(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return string
     */
    function mysql_get_server_info($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_get_server_info(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return string
     */
    function mysql_info($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_info(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param null $link_identifier
     * @return int|string
     */
    function mysql_insert_id($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_insert_id(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $database_name
     * @param $table_name
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_list_fields($database_name, $table_name, $link_identifier = NULL)
    {
        // This function is not been used any more?
        global $mysqlConnection;

        return mysql_query("SELECT * FROM " . $table_name . " LIMIT 1", ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $database_name
     * @param $table_name
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_listfields($database_name, $table_name, $link_identifier = NULL)
    {
        return mysql_list_fields($database_name, $table_name, $link_identifier);
    }

    /**
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_list_processes($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysql_query('SHOW PROCESSLIST', ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $database
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_list_tables($database, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysql_query('SHOW TABLES FROM ' . $database, ($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_num_fields($result)
    {
        return mysqli_num_fields($result);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_numfields($result)
    {
        return mysql_num_fields($result);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_numrows($result)
    {
        return mysql_num_rows($result);
    }

    /**
     * @param null $server
     * @param null $username
     * @param null $password
     * @param int $client_flags
     * @return mysqli
     */
    function mysql_pconnect($server = NULL, $username = NULL, $password = NULL, $client_flags = 0)
    {
        global $mysqlConnection;
        $server = ($server !== NULL) ? $server : ini_get("mysqli.default_host");
        $username = ($username !== NULL) ? $username : ini_get("mysqli.default_user");
        $password = ($password !== NULL) ? $password : ini_get("mysqli.default_pw");
        return $mysqlConnection = mysqli_connect('p:' . $server, $username, $password, "", ini_get("mysqli.default_port"), ini_get("mysqli.default_socket"));
    }


    /**
     * @param null $link_identifier
     * @return bool
     */
    function mysql_ping($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_ping(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $result
     * @param $row
     * @param int $field
     * @return mixed
     */
    function mysql_result($result, $row, $field = 0)
    {
        mysqli_data_seek($result, $row);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }

    /**
     * @param $database_name
     * @param null $link_identifier
     * @return bool
     */
    function mysql_select_db($database_name, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_select_db(($link_identifier != NULL ? $link_identifier : $mysqlConnection), $database_name);
    }

    /**
     * @param $database_name
     * @param null $link_identifier
     * @return bool
     */
    function mysql_selectdb($database_name, $link_identifier = NULL)
    {
        return mysql_select_db($database_name, $link_identifier);
    }

    /**
     * @param $charset
     * @param null $link_identifier
     * @return bool
     */
    function mysql_set_charset($charset, $link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_set_charset(($link_identifier != NULL ? $link_identifier : $mysqlConnection), $charset);
    }

    function mysql_stat($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_stat(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $result
     * @param $i
     * @return bool
     */
    function mysql_tablename($result, $i)
    {
        return (isset ($result[$i]) ? isset ($result[$i]) : false);
    }

    /**
     * @param null $link_identifier
     * @return int
     */
    function mysql_thread_id($link_identifier = NULL)
    {
        global $mysqlConnection;
        return mysqli_thread_id(($link_identifier != NULL ? $link_identifier : $mysqlConnection));
    }

    /**
     * @param $query
     * @param null $link_identifier
     * @return bool|mysqli_result
     */
    function mysql_unbuffered_query($query, $link_identifier = NULL)
    {
        global $mysqlConnection;
        $result = mysqli_query(($link_identifier != NULL ? $link_identifier : $mysqlConnection), $query);
        return ($result);
    }
}