import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Scanner;

import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.HttpStatus;
import org.apache.commons.httpclient.methods.GetMethod;

/**
 * @author Alex Aiezza
 *
 */
public class RestClient
{
    private static final String BASE_URL  = "http://simon.ist.rit.edu:8080/AreaDemo/resources/AreaCalculator/";

    private static final String TEXT_TYPE = "text/plain";
    private static final String XML_TYPE  = "application/xml";
    private static final String JSON_TYPE = "application/json";

    public static void main( String [] args ) throws IOException
    {
        final String helloResource = "Hello";
        final String circleResource = "Circle?radius=3";
        final String helloNameResource = "Hello/Alex!";
        final String rectResource = "Rectangle?width=4&length=13.72";

        printResponse( helloResource, XML_TYPE );
        printResponseApache( helloResource, XML_TYPE );
        printResponse( circleResource, TEXT_TYPE );
        printResponseApache( circleResource, TEXT_TYPE );
        printResponse( helloNameResource, XML_TYPE );
        printResponseApache( helloNameResource, XML_TYPE );
        printResponse( rectResource, XML_TYPE );
        printResponseApache( rectResource, XML_TYPE );
        printResponse( rectResource, JSON_TYPE );
        printResponseApache( rectResource, JSON_TYPE );
    }

    private static void printResponse( final String resource, final String acceptType )
            throws IOException
    {
        // connect using HttpUrlConnection
        final URL url = new URL( BASE_URL + resource );

        // Returns a URLConnection instance that represents a connection to the
        // remote resource referred to by the URL
        final HttpURLConnection con = (HttpURLConnection) url.openConnection();

        con.setRequestMethod( "GET" );
        // Needs to match WADL
        con.addRequestProperty( "Accept", acceptType );
        con.connect();

        // Read
        final Scanner sc = new Scanner( con.getInputStream() );
        System.out.println( sc.nextLine() );
        sc.close();

        con.disconnect();
    }

    private static void printResponseApache( final String resource, final String acceptType )
            throws IOException
    {
        // Use Apache's HttpClient
        final HttpClient client = new HttpClient();
        final GetMethod method = new GetMethod( BASE_URL + resource );

        final int statusCode = client.executeMethod( method );
        if ( statusCode != HttpStatus.SC_OK )
        {
            System.err.println( String.format( "Method failed: %s%n", method.getStatusLine() ) );
        } else
        {
            // Get the Response Body
            final Scanner sc1 = new Scanner( method.getResponseBodyAsStream() );
            while ( sc1.hasNextLine() )
            {
                System.out.println( sc1.nextLine() );
            }

            sc1.close();
        }
    }


}
