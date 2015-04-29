<?php
// Based on: http://coreymaynard.com/blog/creating-a-restful-api-with-php/
abstract class RestService
{
    /**
     * The HTTP method this request was made in: GET, POST, PUT or DELETE
     */
    protected $method = '';
    
    /**
     * The Resource requested in the URI. e.g.: /files
     */
    protected $endpoint = '';
    
    /**
     * An optional additional descriptor about the endpoint,  for things that can't
     * be handled by the basic methods. eg: /files/process
     */    
    protected $verb = '';
    
    /**
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    
    /**
     * Stores the input of the PUT request
     */
    protected $file = Null;

    public function __construct($request) {
        $this->args = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } 
            else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } 
            else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->_cleanInputs($_POST);
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_GET);
            // see: http://php.net/manual/en/wrappers.php.php
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }
    
    /** 
     * publicly exposed method in the service's API to determine if the concrete class
     * implements a method for the endpoint that the client requested. If yes, 
     * it calls that method, otherwise a 404 response is returned
     */
    public function processAPI() {
        //var_dump($this->endpoint,$this->args,$this->request);die();
        if ((int)method_exists($this, $this->endpoint) > 0) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint, 404");
    }

	  /** 
	   * handles returning the response to the client
	   */
    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

	  /** 
	   * does some sanitization 
	   */
    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

	  /** 
	   * creates an array of HTTP status codes
	   */
    private function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }
}