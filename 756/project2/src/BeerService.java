import java.io.IOException;
import java.sql.Timestamp;
import java.util.Date;

import static java.lang.String.format;

import javax.servlet.ServletException;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.common.TypeFactoryImpl;
import org.apache.xmlrpc.common.XmlRpcStreamConfig;
import org.apache.xmlrpc.serializer.TypeSerializer;
import org.apache.xmlrpc.server.PropertyHandlerMapping;
import org.apache.xmlrpc.server.XmlRpcServerConfigImpl;
import org.apache.xmlrpc.server.XmlRpcStreamServer;
import org.apache.xmlrpc.webserver.WebServer;
import org.xml.sax.SAXException;

import edu.kelvin.axa9070.data.BeerJdbcManager;
import edu.kelvin.axa9070.data.entity.Beer;
import edu.kelvin.axa9070.util.PropertiesSetter;
import edu.kelvin.axa9070.web.BeerController;

/**
 * <p>
 * The BeerService class holds the main method. This class acts as the
 * <strong>SERVICE LAYER</strong>. An instance of Apache's {@link WebServer}
 * runs in this class's main method and awaits requests.
 * </p>
 * <p>
 * The main method initializes the {@link BeerJdbcManager} instance (Data Layer)
 * and initializes the {@link BeerController} instance (Business Layer) with it.
 * </p>
 * 
 * @author Alex Aiezza
 *
 */
public class BeerService
{
    private static final Log    LOG          = LogFactory.getLog( BeerService.class );

    static
    {
        try
        {
            // Set properties from properties file
            new PropertiesSetter();
        } catch ( IOException e )
        {
            LOG.fatal( e.getMessage() );
            System.exit( 1 );
        }
    }

    private static final int    PORT         = Integer.parseInt( System
                                                     .getProperty( "service.port" ) );

    private static final String SERVICE_NAME = System.getProperty( "service.name" );

    public static void main( String [] args ) throws IOException, XmlRpcException, ServletException
    {
        int port;
        if ( args.length > 0 )
        {
            try
            {
                port = Integer.parseInt( args[0] );
            } catch ( NumberFormatException e )
            {
                LOG.error( format(
                    "Given Port: '%s' cannot be used.\n  Resorting to Default: %d", args[0], PORT ) );
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
        LOG.info( "Service Created" );

        final XmlRpcServerConfigImpl config = new XmlRpcServerConfigImpl();
        final XmlRpcStreamServer server = webServer.getXmlRpcServer();

        server.setConfig( config );
        server.setHandlerMapping( mapping );
        LOG.info( "Handler Registered" );

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
        LOG.info( format( "Service Started at %s\n", new Timestamp( new Date().getTime() ) ) );
    }
}
