package edu.rit.p3.data.entity;


/**
 * This class represents the entity that is a beer.
 * 
 * @author Alex Aiezza
 *
 */
public class Beer implements Comparable<Beer>
{
    private final String name;
    private final double price;

    public Beer( final String name, final double price )
    {
        this.name = name;
        this.price = price;
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
    public int compareTo( Beer beer )
    {
        return (int) ( price * 100 ) - (int) ( beer.price * 100 );
    }

}
