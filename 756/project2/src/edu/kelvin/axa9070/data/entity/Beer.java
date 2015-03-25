package edu.kelvin.axa9070.data.entity;

import org.apache.xmlrpc.serializer.TypeSerializerImpl;
import org.xml.sax.ContentHandler;
import org.xml.sax.SAXException;

/**
 * This class represents the entity that is a beer.
 * 
 * @author Alex Aiezza
 *
 */
public class Beer extends TypeSerializerImpl implements Comparable<Beer>
{
    private final int    beerId;
    private final String name;
    private final double price;

    public Beer( final int beerId, final String name, final double price )
    {
        this.beerId = beerId;
        this.name = name;
        this.price = price;
    }

    /**
     * @return the beerId
     */
    public int getBeerId()
    {
        return beerId;
    }

    /**
     * @return the name
     */
    public String getName()
    {
        return name;
    }

    /**
     * @return the price
     */
    public double getPrice()
    {
        return price;
    }

    @Override
    public void write( ContentHandler handler, Object beerObj ) throws SAXException
    {
        if ( ! ( beerObj instanceof Beer ) )
            throw new SAXException( String.format( "Object: '%s' is not of type Beer", beerObj ) );

        final Beer beer = ( (Beer) beerObj );

        write( handler, "BeerId", String.valueOf( beer.getBeerId() ) );
        write( handler, "Name", beer.getName() );
        write( handler, "Price", String.format( "%.2f", beer.getPrice() ) );
    }

    @Override
    public int compareTo( Beer beer )
    {
        return (int) ( price * 100 ) - (int) ( beer.price * 100 );
    }

}
