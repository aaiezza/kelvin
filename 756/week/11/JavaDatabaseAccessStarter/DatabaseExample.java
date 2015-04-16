import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Set;

import data.DatabaseAccess;

// Make sure mysql-connector-java-5.1.27-bin.jar is in the classpath
// For glassfish, needs to be in the glassfish/lib folder
// Need to add user and grant access to beerprices

public class DatabaseExample
{
    public static void main( String args [] )
    {
        try
        {
            String dbName = "axa9070";
            String user = "axa9070";
            String pswd = "tomahawk";
            String host = "localhost";
            String port = "3306";

            // @formatter:off
         // Create an object of the utility class that you will use to do your queries
            
            final DatabaseAccess db = new DatabaseAccess( dbName, user, pswd, host, port );
         
         /*
           The db.getData(String) method returns ArrayListan ArrayList of ArrayLists<String> containing
             the result of a query (the String argument).  Each item in the ArrayList contains a row of results:
             an ArrayList<String> of Strings, with each String in this ArrayList being a column
             in the result. The method returns null if there is an "empty set" result.
             @formatter:on
         */
            // How many beers are in the database?
            String sql = "SELECT count(*) FROM beers;";
            ArrayList<ArrayList<String>> res = db.getData( sql );

            if ( res != null )
            {
                System.out.printf( "%nThere are %d beers in the database.%n%n",
                    Integer.parseInt( res.get( 0 ).get( 0 ) ) );
            } else
            {
                System.out.println( "There aren't any beers in the db! Mac drank them." );
            }

            // Most expensive beer in the database?
            sql = "SELECT beername, beerprice FROM beers ORDER BY beerprice DESC LIMIT 1;";
            res = db.getData( sql );

            if ( res != null )
            {
                System.out.printf( "%s%n%-20s %s%n%-20s %s%n", "Most expensive beer",
                    "Name", "Price", "====", "=====" );
                for ( final ArrayList<String> row : res )
                {
                    System.out.printf( "%-20s %s%n", row.get( 0 ), row.get( 1 ) );
                }
            } else
            {
                System.out.println( "There aren't any beers in the db! Mac drank them." );
            }

            // List the price of a given beer
            sql = "SELECT beerprice FROM beers WHERE beername = ?";
            ArrayList<String> params = new ArrayList<String>();
            String beerName = "Bud";
            params.add( beerName );

            res = db.getDataPS( sql, params );

            if ( res != null )
            {
                System.out.printf( "%n%s%n%-20s %s%n%-20s %s%n", "Any given beer",
                    "Name", "Price", "====", "=====" );
                for ( final ArrayList<String> row : res )
                {
                    System.out.printf( "%-20s %s%n", beerName, row.get( 0 ) );
                }
                
            } else
            {
                System.out.println( "There aren't any beers in the db! Mac drank them." );
            }

            // Update the price for a given beer
            sql = "UPDATE beers SET beerprice = ? WHERE beername = ?";
            params.clear();
            String beerPrice = "5.25";
            beerName = "Bud";
            params.add( beerPrice );
            params.add( "Bud" );

            int updated = db.nonSelect( sql, params );

            if ( updated > 0 )
            {
                System.out.printf( "%n%s%d%n", "Number of beers updated: ", updated );
                
            } else
            {
                System.out.println( "There aren't any beers in the db! Mac drank them." );
            }

            // @formatter:off
         /*
           The db.getDataWithColNames(String) method returns an ArrayList of HashMap<String,String>
             containing the result of a query (the String argument).  Each item in the ArrayList contains a row of results:
             a HashMap<String,String> with the key being the column name and the value being a String
             representation of the value for that column for the current row.
           The method returns null if there is an "empty set" result.
           @formatter:on
         */

            // Get all beers and list them
            sql = "SELECT beername, beerprice FROM beers ORDER BY beerprice ASC";

            res = db.getData( sql );

            if ( res != null )
            {
                System.out.printf( "%n%s%n%-20s %s%n%-20s %s%n", "All Beers",
                    "Name", "Price", "====", "=====" );
                for ( final ArrayList<String> row : res )
                {
                    System.out.printf( "%-20s %s%n",  row.get( 0 ), row.get( 1 ) );
                }
            } else
            {
                System.out.println( "There aren't any beers in the db! Mac drank them." );
            }

            // Put those beers in a hashmap
            ArrayList<HashMap<String, String>> rs = db.getDataWithColNames( sql );
            System.out.printf( "%n%s%n%n", rs );

            boolean first = true;

            for ( HashMap<String, String> row : rs )
            {
                // first time, print column headers
                if ( first )
                {
                    for ( Iterator<String> it = row.keySet().iterator(); it.hasNext(); )
                    {
                        String colName = it.next();
                        System.out.printf( "%-20s", colName );
                    }
                    first = false;
                }
                

            }


        } catch ( SQLException e )
        {
            e.printStackTrace();
        } catch ( ClassNotFoundException e )
        {
            e.printStackTrace();
        }
    }

    static String getUnderline( String str )
    {
        String underLine = "";
        for ( int i = 0; i < str.length(); i++ )
        {
            underLine += "=";
        }

        return underLine;
    }


} // class
