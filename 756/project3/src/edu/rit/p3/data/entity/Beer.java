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
     * Compares beers by price. If <tt>this</tt> beer has a higher price than
     * the given beer, the prices are the same or <tt>this</tt> beer has a lower
     * price than the given beer, the returning integer will be positive, 0, or
     * negative respectively.
     *
     * @param beer
     *            the beer to compare
     *
     * @return If <tt>this</tt> beer has a higher price than the given beer, the
     *         prices are the same or <tt>this</tt> beer has a lower price than
     *         the given beer, the returning integer will be positive, 0, or
     *         negative respectively.
     *
     * @see java.lang.Comparable#compareTo(java.lang.Object)
     */
    @Override
    public int compareTo( final Beer beer )
    {
        return (int) ( price * 100 ) - (int) ( beer.price * 100 );
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

}
