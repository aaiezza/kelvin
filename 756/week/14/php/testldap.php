<!doctype html>
<html lang='en'>
<head>
  <meta charset='utf-8' />
  <title>LDAP</title>
  <style>
    body {
      font-family: courier;
    }
  </style>
</head>
<body>

<?php
function _doLdapAuth( $username, $password, $allowed_users=array() ) {

  echo "Starting LDAP authentication...<br/>" . PHP_EOL;

  // Ensure user is approved
  if ( count( $allowed_users) != 0 ) {
    if ( !in_array( $username, $allowed_users ) ) {
      return false;
    }
  }
  
  // Ensure both username and password are present
  if ( $username == '' or $password == '' ) {
    return false;
  }
  
  $link = ldap_connect( "ldaps://ldap.rit.edu/", 636 ); // SSL
  //$link = ldap_connect( "ldaps://ldap.rit.edu/", 389 ); // TLS

  echo "Connected to LDAP with: "; var_dump( $link ); echo "<br/>" . PHP_EOL;
  echo "LDAP-Errno: " . ldap_errno( $link ) . "<br/>" . PHP_EOL;
  echo "LDAP-Errmsg: " . ldap_err2str( ldap_errno( $link ) ) . "<br/><br/>" . PHP_EOL;
  
  if ( $link ) {
    if ( !ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3) ) {
      echo "<em>Could not set version.</em><br/>" . PHP_EOL;
    }
    
    // ou = "Organizational Unit
    // dc = "Domain Component"
    $rit_name = "uid=" . $username . ",ou=people,dc=rit,dc=edu";
    $rit_pass = $password;

    $lbind = @ldap_bind( $link, $rit_name, $rit_pass );

    if ( $lbind ) {
      echo "Binding successful.<br/>" . PHP_EOL;
      return true;
    }
    else {
      echo "Binding failed.<br/>" . PHP_EOL;
      echo "LDAP-Errno: " . ldap_errno( $link ) . "<br/>" . PHP_EOL;
      echo "LDAP-Errmsg: " . ldap_err2str( ldap_errno( $link ) ) . "<br/>" . PHP_EOL;
      return false;
    }
    
    ldap_close($link);
  }
}

echo "<h3>Authentication;</h3>" . PHP_EOL;
_doLdapAuth( $_GET['user'], $_GET['pass'], $allowed_users = array() );


echo "<br/><hr/><br/>";
//----------------------------------------------------------------

$link=ldap_connect( "ldaps://ldap.rit.edu", 389 );
 
if ( $link ) {
  
    echo "<h3>Search:</h3>" . PHP_EOL;
    // You may add in any filter part on here. "uid" is a profile data inside the LDAP. You may filter by other columns depends on your LDAP setup.
    // uid=dmg*
    // mail=dean*
    // givenname=dean
    // displayname=*ganskop
    // initials=DG
    // mobile=*4079
    // ou=Faculty
    $search = ldap_search( $link, "dc=rit,dc=edu", "uid=axa9070" );
 
    $info = ldap_get_entries($link, $search);
    
    for ( $i = 0; $i < $info["count"]; $i++ ) {
      echo $info[$i]["cn"][0] . " (" . $info[$i]["uid"][0] . ") <em>" . $info[$i]["ou"][0] . "</em><br/>" . PHP_EOL;
    }
 
    echo "<h3>Distinguished Names (with first entry / next entry):</h3>" . PHP_EOL;
    $entry = ldap_first_entry($link, $search);
    do {
      $dn = ldap_get_dn($link, $entry);
      echo "DN is $dn<br/>" . PHP_EOL;
    } while ( $entry = ldap_next_entry( $link, $entry ) );
    
    echo "<h3>Attributes:</h3>" . PHP_EOL;
    $entry = ldap_first_entry($link, $search);
    $attrs = ldap_get_attributes($link, $entry);
    echo $attrs["count"] . " attributes held for this entry:<br/>" . PHP_EOL;
    echo "<pre>";
    print_r( $attrs );
    echo "</pre>";


    ldap_close($link);
} 
else {
    echo "<h4>Unable to connect to LDAP server</h4>" . PHP_EOL;
}
 
?>
</body>
</html>