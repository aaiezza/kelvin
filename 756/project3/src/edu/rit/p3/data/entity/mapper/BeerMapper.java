package edu.rit.p3.data.entity.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.Beer;

/**
 * An instance of BeerMapper is used by the {@link BeerJdbcManager} (Data Layer)
 * to more efficiently extract {@link Beer} entities from a given MySQL
 * {@link ResultSet}.
 *
 * @author Alex Aiezza
 *
 */
public class BeerMapper implements ResultSetExtractor<List<Beer>>
{
    private final RowMapper<Beer> rowMapper;

    public BeerMapper()
    {
        rowMapper = new RowMapper<Beer>()
                {
            @Override
            public Beer mapRow( final ResultSet rs, final int numRows ) throws SQLException
            {
                final Beer beer = new Beer( rs.getString( "Name" ), rs.getDouble( "Price" ) );

                return beer;
            }
                };
    }

    @Override
    public List<Beer> extractData( final ResultSet rs ) throws SQLException, DataAccessException
    {
        final List<Beer> beers = new ArrayList<Beer>();

        while ( rs.next() )
            beers.add( rowMapper.mapRow( rs, -1 ) );

        rs.close();

        return beers;
    }
}
