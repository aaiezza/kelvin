package edu.rit.p3.data.entity.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.TimeZone;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.Token;
import edu.rit.p3.data.entity.User;

/**
 * An instance of UserMapper is used by the {@link BeerJdbcManager} (Data Layer)
 * to more efficiently extract {@link User} entities from a given SQLite
 * {@link ResultSet}.
 *
 * @author Alex Aiezza
 *
 */
public class TokenMapper implements ResultSetExtractor<List<Token>>
{
    private final Log              LOG        = LogFactory.getLog( getClass() );
    private final RowMapper<Token> rowMapper;
    private final SimpleDateFormat dateFormat = new SimpleDateFormat( "yyyy-MM-dd HH:mm:ss" );

    {
        dateFormat.setTimeZone( TimeZone.getTimeZone( "UTC" ) );
    }

    public TokenMapper()
    {
        rowMapper = new RowMapper<Token>()
                {
            @Override
            public Token mapRow( final ResultSet rs, final int numRows ) throws SQLException
            {
                Token token = null;
                try
                {
                    token = new Token( rs.getString( "TokenHash" ), rs.getString( "Username" ),
                        dateFormat.parse( rs.getString( "Expiration" ) ) );
                } catch ( final ParseException e )
                {
                    LOG.error( e.getMessage() );
                }

                return token;
            }
                };
    }

    @Override
    public List<Token> extractData( final ResultSet rs ) throws SQLException, DataAccessException
    {
        final List<Token> tokens = new ArrayList<Token>();

        while ( rs.next() )
            tokens.add( rowMapper.mapRow( rs, -1 ) );

        rs.close();

        return tokens;
    }
}
