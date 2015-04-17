import static java.lang.System.out;

import java.net.MalformedURLException;
import java.net.URL;

import javax.xml.namespace.QName;
import javax.xml.soap.MessageFactory;
import javax.xml.soap.SOAPBody;
import javax.xml.soap.SOAPConnection;
import javax.xml.soap.SOAPConnectionFactory;
import javax.xml.soap.SOAPElement;
import javax.xml.soap.SOAPEnvelope;
import javax.xml.soap.SOAPMessage;
import javax.xml.soap.SOAPPart;
import javax.xml.ws.Service;
import javax.xml.ws.WebServiceClient;

/**
 * @author Alex Aiezza
 *
 */
@WebServiceClient (
    name = ManualBeerService.DEFAULT_SERVICE_NAME,
    targetNamespace = ManualBeerService.DEFAULT_SERVICE_URI,
    wsdlLocation = ManualBeerService.DEFAULT_SERVICE_WSDL )
public class ManualBeerService extends Service
{
    static final String         DEFAULT_SERVICE_WSDL = "http://simon.ist.rit.edu:8080/beer/BeerService?WSDL";
    static final String         DEFAULT_SERVICE_URI  = "http://simon.ist.rit.edu:8080/beer/BeerService?WSDL";
    static final String         DEFAULT_SERVICE_NAME = "Beer";

    private static final String NAMESPACE            = "ser";
    private static final String NAMESPACE_URI        = "http://server/";

    public ManualBeerService() throws MalformedURLException
    {
        super( new URL( DEFAULT_SERVICE_URI ), new QName( DEFAULT_SERVICE_WSDL,
                DEFAULT_SERVICE_NAME ) );
    }

    public ManualBeerService( final URL wsdlLocation, final QName serviceName )
    {
        super( wsdlLocation, serviceName );
    }
    
    

    private SOAPMessage createSOAPRequest( final String method ) throws Exception
    {
        return createSOAPRequest( method, new String [0] );
    }

    private SOAPMessage createSOAPRequest( final String method, final String [] params )
            throws Exception
    {
        final MessageFactory messageFactory = MessageFactory.newInstance();
        final SOAPMessage soapMessage = messageFactory.createMessage();
        final SOAPPart soapPart = soapMessage.getSOAPPart();

        // SOAP Envelope
        final SOAPEnvelope envelope = soapPart.getEnvelope();
        envelope.addNamespaceDeclaration( NAMESPACE, NAMESPACE_URI );

        // SOAP Body
        final SOAPBody soapBody = envelope.getBody();
        final SOAPElement soapBodyElem = soapBody.addChildElement( method, NAMESPACE );

        // final SOAPElement soapBodyElem1 = soapBodyElem.addChildElement(
        // "email", "example" );
        // soapBodyElem1.addTextNode( "mutantninja@gmail.com" );

        // final SOAPElement soapBodyElem2 = soapBodyElem.addChildElement(
        // "LicenseKey", "example" );
        // soapBodyElem2.addTextNode( "123" );

        // final MimeHeaders headers = soapMessage.getMimeHeaders();
        // headers.addHeader( "SOAPAction", serverURI + "getMethods" );

        soapMessage.saveChanges();

        /* Print the request message */
        out.printf( "%nRequest SOAP Message:%n" );
        soapMessage.writeTo( out );
        out.println();

        return soapMessage;
    }

    public static void main( final String [] args ) throws Exception
    {
        final String serverURI = args.length < 1 ? DEFAULT_SERVICE_WSDL : args[0];

        // Create SOAP Connection
        final SOAPConnectionFactory soapConnectionFactory = SOAPConnectionFactory.newInstance();
        final SOAPConnection soapConnection = soapConnectionFactory.createConnection();

        // Send SOAP Message to SOAP Server
        final SOAPMessage soapResponse = soapConnection.call(
            new ManualBeerService().createSOAPRequest( "getBeers" ), serverURI );

        // print SOAP Response
        out.printf( "%nResponse SOAP Message:%n" );
        soapResponse.writeTo( out );
        out.println();

        soapConnection.close();
    }
}
