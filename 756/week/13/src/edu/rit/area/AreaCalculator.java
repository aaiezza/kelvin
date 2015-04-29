package edu.rit.area;

import static java.lang.Math.PI;
import static java.lang.String.format;

import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.UriInfo;

/**
 * REST Web Service
 * 
 * @author Alex Aiezza
 *
 */
@Path ( "AreaCalculator" )
public class AreaCalculator
{
    @Context
    private UriInfo context;

    public AreaCalculator()
    {

    }

    @Path ( "Hello" )
    @GET
    @Produces ( "application/xml" )
    @Consumes ( "text/plain" )
    public String helloWorld()
    {
        return "<result>Hello World</result>";
    }

    // URI Template
    @Path ( "Hello/{name}" )
    @GET
    @Produces ( "application/xml" )
    @Consumes ( "text/plain" )
    public String helloName( @PathParam ( "name" ) final String name )
    {
        return format( "<result>Hello %s</result>", name );
    }

    @Path ( "Rectangle" )
    @GET
    @Produces ( "application/xml" )
    @Consumes ( "application/xml" )
    public String calcRectangleAreaXML(
            @QueryParam ( "width" ) final double width,
            @QueryParam ( "height" ) final double height )
    {
        return format( "<result>%.5f</result>", width * height );
    }

    @Path ( "Rectangle" )
    @GET
    @Produces ( "application/json" )
    @Consumes ( "application/xml" )
    public String calcRectangleAreaJSON(
            @QueryParam ( "width" ) final double width,
            @QueryParam ( "height" ) final double height )
    {
        return format( "{\"Area\":\"%.5f\"}", width * height );
    }

    @Path ( "Circle" )
    @GET
    @Produces ( "text/plain" )
    @Consumes ( "text/plain" )
    public String calcCircle( @QueryParam ( "radius" ) final double radius )
    {
        return format( "%.5f", radius * radius * PI );
    }
}
