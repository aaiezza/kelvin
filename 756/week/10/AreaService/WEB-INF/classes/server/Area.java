/**
 * 
 */
package server;

import javax.jws.WebMethod;
import javax.jws.WebService;

import useless.Helper;

/**
 * @author Alex Aiezza
 *
 */
@WebService ( serviceName = "SweetAreaService" )
public class Area
{

    // defaults to method name if not specified
    @WebMethod ( operationName = "SpanishHello" )
    public String hellowWorld()
    {
        final Helper h = new Helper();
        return h.spanishHelloWorld();
    }

    @WebMethod ( operationName = "FrenchHello" )
    public String helloWorld2()
    {
        final Helper h = new Helper();
        return h.frenchHelloWorld();
    }

    // This will be exposed in the WSDL!
    public double calcRectanlge( final double x, final double y )
    {
        return x * y;
    }

    // This will also be exposed in the WSDL
    public double calcCircle( final double r )
    {
        return Math.PI * r * r;
    }

    @WebMethod ( exclude = true )
    public String whisper()
    {
        return "whisppp";
    }

}
