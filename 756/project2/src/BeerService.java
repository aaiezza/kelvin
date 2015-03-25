import java.io.IOException;
import java.sql.Timestamp;
import java.util.Date;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.common.TypeFactoryImpl;
import org.apache.xmlrpc.common.XmlRpcStreamConfig;
import org.apache.xmlrpc.serializer.TypeSerializer;
import org.apache.xmlrpc.server.PropertyHandlerMapping;
import org.apache.xmlrpc.server.XmlRpcServer;
import org.apache.xmlrpc.server.XmlRpcServerConfigImpl;
import org.apache.xmlrpc.webserver.WebServer;
import org.xml.sax.SAXException;

import edu.kelvin.axa9070.data.BeerJdbcManager;
import edu.kelvin.axa9070.data.entity.Beer;
import edu.kelvin.axa9070.util.PropertiesSetter;
import edu.kelvin.axa9070.web.BeerController;

public class BeerService
{
    static
    {
        try
        {
            // Set properties from properties file
            new PropertiesSetter();
        } catch ( IOException e )
        {
            System.err.println( e.getMessage() );
            System.exit( 1 );
        }
    }

    private static final int    PORT         = Integer.parseInt( System
                                                     .getProperty( "service.port" ) );

    private static final String SERVICE_NAME = System.getProperty( "service.name" );

    public static void main( String [] args ) throws IOException, XmlRpcException
    {
        int port;
        if ( args.length > 0 )
        {
            try
            {
                port = Integer.parseInt( args[0] );
            } catch ( NumberFormatException e )
            {
                System.err.printf( "Given Port: '%s' cannot be used.\nResorting to Default: %d",
                    args[0], PORT );
                port = PORT;
            }

        } else
        {
            port = PORT;
        }

        /*
         * Create the BeerJdbcManager
         * 
         * This is the Data Layer to communicate with the data sources
         */
        final BeerJdbcManager beerJdbcManager = new BeerJdbcManager();

        /*
         * Create the BeerController
         * 
         * This is the Business Layer responsible for Managing entities from
         * their representation in our data layer
         */
        final BeerController beerController = new BeerController( beerJdbcManager );

        /*
         * Create the WebServer
         * 
         * This is the Service Layer for providing a RESTful-like interface for
         * the accessibility of the beer service
         */
        final PropertyHandlerMapping mapping = new PropertyHandlerMapping();
        mapping.addHandler( SERVICE_NAME, beerController.getClass() );

        final WebServer webServer = new WebServer( port );
        System.out.println( "Service Created" );

        final XmlRpcServerConfigImpl config = new XmlRpcServerConfigImpl();
        final XmlRpcServer server = webServer.getXmlRpcServer();

        server.setConfig( config );
        server.setHandlerMapping( mapping );
        System.out.println( "Handler Registered" );

        server.setTypeFactory( new TypeFactoryImpl( server )
        {
            @Override
            public TypeSerializer getSerializer( XmlRpcStreamConfig pConfig, Object pObject )
                    throws SAXException
            {
                if ( pObject instanceof Beer )
                {
                    /*
                     * Yes, I made the Beer class "self-serializing". However,
                     * the client also needs the ability to parse the generated
                     * XML into a Beer entity!
                     * 
                     * (Another tremendous benefit of JSON over XML!)
                     */
                    return ( (Beer) pObject );
                } else
                {
                    return super.getSerializer( pConfig, pObject );
                }
            }

        } );

        webServer.start();
        System.out.printf( "Service Started at %s\n", new Timestamp( new Date().getTime() ) );
    }
}
