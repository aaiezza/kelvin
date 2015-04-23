<?php

class MyCurl
{
    
    // get remote file using curl
    static function getRemoteFile( $url, $accept = "" )
    {
        if ( function_exists( 'curl_init' ) )
        {
            // initialize a new curl resource
            $ch = curl_init();
            
            // set the url to fetch
            curl_setopt( $ch, CURLOPT_URL, $url );
            
            // don't give me the headers just the content
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            
            // return the value instead of printing the response to browser
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            
            // use a user agent to mimic a browser
            curl_setopt( $ch, CURLOPT_USERAGENT, 
                    'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0' );
            
            // change accept
            if ( $accept != "" )
            {
                $headers = array ( 'Accept: ' . $accept );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
            }
            
            $content = curl_exec( $ch );
            
            // remember to always close the session and free all resources
            curl_close( $ch );
            return $content;
        } else
        {
            // curl library is not installed so we better use something else
            return self::getRemoteFile2( $url );
        }
    } // getRemoteFile
      
    // get status code using curl
    static function getStatusCode( $url )
    {
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_NOBODY, true );
        curl_exec( $ch );
        $status_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        // $status_code contains the HTTP status: 200, 404, etc.
        return $status_code;
    } // getStatusCode //use curl to get status code 404 to make sure file exists
      
    // getRemoteFile using our own functions
    static function getRemoteFile2( $url )
    {
        // get the host name and url path
        $parsedUrl = parse_url( $url );
        $host = $parsedUrl['host'];
        if ( isset( $parsedUrl['path'] ) )
        {
            $path = $parsedUrl['path'];
        } else
        {
            // the url is pointing to the host like http://www.mysite.com
            $path = '/';
        }
        
        if ( isset( $parsedUrl['query'] ) )
        {
            $path .= '?' . $parsedUrl['query'];
        }
        
        if ( isset( $parsedUrl['port'] ) )
        {
            $port = $parsedUrl['port'];
        } else
        {
            // most sites use port 80
            $port = '80';
        }
        
        $timeout = 10;
        $response = '';
        
        // connect to the remote server
        $fp = @fsockopen( $host, '80', $errno, $errstr, $timeout );
        
        if ( !$fp )
        {
            return "Cannot retrieve $url";
        } else
        {
            // send the necessary headers to get the file
            fputs( $fp, 
                    "GET $path HTTP/1.0\r\n" . "Host: $host\r\n" .
                             "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
                             "Accept: */*\r\n" . "Accept-Language: en-us,en;q=0.5\r\n" .
                             "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
                             "Keep-Alive: 300\r\n" . "Connection: keep-alive\r\n" .
                             "Referer: http://$host\r\n\r\n" );
            
            // retrieve the response from the remote server
            while ( $line = fread( $fp, 4096 ) )
            {
                $response .= $line;
            }
            
            fclose( $fp );
            
            // strip the headers
            $pos = strpos( $response, "\r\n\r\n" );
            $response = substr( $response, $pos + 4 );
        }
        
        // return the file content
        return $response;
    }
    
    // url to call and local cookie file which must be writeable
    // Usually you do not want this file under the web root so it can't be accessed from HTTP
    // Clients
    static function sendCookies( $url, $cookieFile, $cookies = "" )
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        
        if ( $cookies != "" )
        {
            curl_setopt( $ch, CURLOPT_COOKIE, $cookies );
        }
        
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookieFile );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookieFile );
        
        $output = curl_exec( $ch );
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        
        return array ( "output" => $output, "info" => $info );
    }
    
    // $url with expecting post data, $data is array of "key"=>"value" s for post
    // or string of urlencoded name/value pairs or http_build_query
    static function sendPost( $url, $data )
    {
        // $data could also be json or xml string
        $ch = curl_init();
        if ( is_array( $data ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array ( 'Content-Type: multipart/form-data' ) );
        } else
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, 
                    array ( 'Content-Type: application/x-www-form-urlencoded' ) );
        }
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_USERAGENT, 
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
        $output = curl_exec( $ch );
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        return array ( "output" => $output, "info" => $info );
    }
    
    // $url with expecting post data, $data is array of "key"=>"value" s for post
    // $cookiefile is file for cookies like in sendCookies, $cookies are any additional cookies to
    // set
    static function sendPostWithCookies( $url, $data, $cookieFile, $cookies )
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        if ( $cookies != "" )
        {
            curl_setopt( $ch, CURLOPT_COOKIE, $cookies );
        }
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookieFile );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookieFile );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
        $output = curl_exec( $ch );
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        return array ( "output" => $output, "info" => $info );
    }

    static function sendPut( $url, $data )
    {
        // $data = array("a" => $a);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_USERAGENT, 
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
        
        $output = curl_exec( $ch );
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        return array ( "output" => $output, "info" => $info );
    }

    static function sendDelete( $url, $data )
    {
        // $data can be json/xml whatever the other side is looking for;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_USERAGENT, 
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        
        $output = curl_exec( $ch );
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        return array ( "output" => $output, "info" => $info );
    }
} // class
?>