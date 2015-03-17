<?php
require 'exceptions/UsernameNotFoundException.class.php';

class MemberServiceManager
{

    /**
     */
    const QUERY_NUMBER_OF_USERS_SQL = 'SELECT COUNT(username) FROM users WHERE username = ?';

    /**
     */
    const QUERY_USER_BY_USERNAME = 'SELECT users.username, first_name, last_name, user_phone.phone_number_id, area_code, number, type FROM users LEFT JOIN user_phone ON users.username=user_phone.username LEFT JOIN phone_numbers ON user_phone.phone_number_id=phone_numbers.phone_number_id WHERE users.username = ?';

    /**
     */
    const SELECT_ALL_USERS_SQL = 'SELECT users.username, first_name, last_name, user_phone.phone_number_id, area_code, number, type FROM users LEFT JOIN user_phone ON users.username=user_phone.username LEFT JOIN phone_numbers ON user_phone.phone_number_id=phone_numbers.phone_number_id';

    /**
     */
    const NEW_USER_SQL = 'INSERT INTO users (username, first_name, last_name) VALUES ( ?, ?, ? )';

    /*
     */
    const NEW_PHONE_NUMBER = 'INSERT INTO phone_numbers (area_code, number, type) VALUES ( ?, ?, ? )';

    /**
     */
    const NEW_USER_PHONE_SQL = 'INSERT INTO user_phone (username, phone_number_id) VALUES( ?, ? )';

    /**
     */
    const DELETE_USER_SQL = 'DELETE FROM users WHERE username = ?';

    /**
     */
    const DELETE_PHONE_NUMBER_SQL = 'DELETE FROM phone_numbers WHERE phone_number_id = ?';

    /**
     */
    const DELETE_USER_PHONE_SQL = 'DELETE FROM user_phone WHERE username = ? AND phone_number_id = ?';

    /**
     */
    const UPDATE_USER_SQL = 'UPDATE users SET first_name = ?, last_name = ? WHERE username = ?';

    /**
     */
    const UPDATE_PHONE_NUMBER_SQL = 'UPDATE phone_numbers SET area_code = ?, number = ?, type = ? WHERE phone_number_id = ?';

    private $mysql1;

    /**
     * This is a Singleton architecture I am trying to acheive.
     */
    public static function getInstance()
    {
        static $instance = null;
        if ( null === $instance )
        {
            $instance = new static();
        }
        
        return $instance;
    }

    protected function __construct()
    {
        global $hostname, $username, $password, $database;

         $this->mysql1 = new mysqli( $hostname, $username, $password, $database );

        // CHECK FOR VALID CONNECTION!
        if ($this->mysql1->connect_error)
        {
            printf( 'Connect failed: %s', $mysql1->connect_error );
            exit( 1 );
        }
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function &getDB()
    {
        return $this->mysql1;
    }

    public function createUser( MemberForm $user )
    {
        if ( $stmt = $this->getDB()->prepare( self::NEW_USER_SQL ) )
        {
            $stmt->bind_param( 'sss',
                $user->getUsername(),
                $user->getFirstName(),
                $user->getLastName() );

            $stmt->execute();

            $stmt->close();
        }

        $this->createPhoneNumber( $user->getUsername(), $user->getAreaCode(),
            $user->getNumber(), $user->getType() );
    }

    public function updateUser( MemberForm $user )
    {
        if ( $stmt = $this->getDB()->prepare( self::UPDATE_USER_SQL ) )
        {
            $stmt->bind_param( 'sss',
                $user->getFirstName(),
                $user->getLastName(),
                $user->getUsername()  );

            $stmt->execute();

            $stmt->close();
        }
    }

    public function createPhoneNumber( $username, $area_code, $number, $type )
    {
        $insert_id = 0;
        if ( $stmt = $this->getDB()->prepare( self::NEW_PHONE_NUMBER ) )
        {
            $stmt->bind_param( 'sss', $area_code, $number, $type );

            $stmt->execute();
            $stmt->store_result();

            $insert_id = $stmt->insert_id;

            $stmt->close();
        }

        if ( $stmt = $this->getDB()->prepare( self::NEW_USER_PHONE_SQL ) )
        {
            $stmt->bind_param( 'si', $username, $insert_id );

            $stmt->execute();
            $stmt->close();
        }
    }

    public function updatePhoneNumber( PhoneNumber $number )
    {
        if ( $stmt = $this->getDB()->prepare( self::UPDATE_PHONE_NUMBER_SQL ) )
        {
            $stmt->bind_param( 'sssi',
                $number->area_code,
                $number->number,
                $number->type,
                $number->id );

            $stmt->execute();

            $stmt->close();
        }
    }

    public function deleteUser( $username )
    {
        $user = $this->loadMemberByUsername( $username );

        foreach( $user->getNumbers() as $number )
        {
            $this->deletePhoneNumber( $user->getUsername(), $number );
        }

        if ( $stmt = $this->getDB()->prepare( self::DELETE_USER_SQL ) )
        {
            $stmt->bind_param( 's', $user->getUsername() );

            $stmt->execute();
            $stmt->close();
        }
    }

    public function deletePhoneNumber( $username, PhoneNumber $number )
    {
        if ( $stmt = $this->getDB()->prepare( self::DELETE_USER_PHONE_SQL ) )
        {
            $stmt->bind_param( 'si', $username, $number->id );

            $stmt->execute();
            $stmt->close();
        }

        if ( $stmt = $this->getDB()->prepare( self::DELETE_PHONE_NUMBER_SQL ) )
        {
            $stmt->bind_param( 'i', $number->id );

            $stmt->execute();
            $stmt->close();
        }
    }

    public function getUsers()
    {
        $stmt = $this->getDB()->prepare( self::SELECT_ALL_USERS_SQL );
        $stmt->execute();
        $stmt->store_result();

        return $this->extractData( $stmt );
    }

    public function loadMemberByUsername( $username )
    {
        $users = array ( $this->loadMembersByUsername( $username ) );
        
        if ( count( $users[0] ) == 0 )
        {
            throw new UsernameNotFoundException( $username );
        }
        
        return $users[0][$username];
    }

    /**
     * Executes the SQL <tt>usersByUsernameQuery</tt> and returns a list of
     * Member objects.
     * There should normally only be one matching user.
     */
    protected function loadMembersByUsername( $username )
    {
        if ( $stmt = $this->getDB()->prepare( self::QUERY_USER_BY_USERNAME ) )
        {
            $stmt->bind_param( 's', $username );

            $stmt->execute();
            $stmt->store_result();
        }

        return self::extractData( $stmt );
    }

    private static function mapRow( $rs )
    {
        $numbers = array ( new PhoneNumber( $rs['phone_number_id'], $rs['type'], $rs['area_code'], $rs['number'] ) );
        
        $user = new Member( $rs['username'], $rs['first_name'], $rs['last_name'], $numbers );
        
        return $user;
    }

    public static function extractData( $rs )
    {
        $results = array();
        
        $rs->bind_result( $username, $firstname, $lastname, $phoneID, $area_code, $number, $type );

        while ( $rs->fetch() )
        {
            if ( !isset( $username ) )
                continue;
            
            $numbers1 = array ();
            if (isset( $phoneID ) )
            {
               $numbers1[] = new PhoneNumber( $phoneID, $type, $area_code, $number );
            }
            
            $user = new Member( $username, $firstname, $lastname, $numbers1 );
            
            if ( array_key_exists( $user->getUsername(), $results ) )
            {
                $inUser = &$results[$user->getUsername()];
                
                $numbers = &$inUser->getNumbers();
                $numbers = array_merge( $numbers, $user->getNumbers() );
                
                
            } else
            {
                $results[$user->getUsername()] = $user;
            }
        }

        $rs->close();
        
        return $results;
    }
}
?>
