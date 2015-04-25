package edu.rit.p3.data.entity.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.User;

/**
 * An instance of UserMapper is used by the {@link BeerJdbcManager} (Data Layer)
 * to more efficiently extract {@link User} entities from a given SQLite
 * {@link ResultSet}.
 *
 * @author Alex Aiezza
 *
 */
public class UserMapper implements ResultSetExtractor<List<User>>
{
    private final RowMapper<User> rowMapper;

    public UserMapper()
    {
        rowMapper = new RowMapper<User>()
                {
            @Override
            public User mapRow( final ResultSet rs, final int numRows ) throws SQLException
            {
                final User user = new User( rs.getString( "Username" ), rs.getString( "Password" ),
                    rs.getInt( "Age" ), rs.getBoolean( "AccessLevel" ) );

                return user;
            }
                };
    }

    @Override
    public List<User> extractData( final ResultSet rs ) throws SQLException, DataAccessException
    {
        final List<User> users = new ArrayList<User>();

        while ( rs.next() )
            users.add( rowMapper.mapRow( rs, -1 ) );

        rs.close();

        return users;
    }
}
