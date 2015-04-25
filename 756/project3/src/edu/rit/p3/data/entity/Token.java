package edu.rit.p3.data.entity;

import java.util.Date;


/**
 * This class represents the entity that is a user.
 * 
 * @author Alex Aiezza
 *
 */
public class Token
{
    private final String tokenHash;
    private final String username;
    private final Date   expiration;

    public Token( final String tokenHash, final String username, final Date expiration )
    {
        this.tokenHash = tokenHash;
        this.username = username;
        this.expiration = expiration;
    }

    /**
     * @return the tokenHash
     */
    public String getTokenHash()
    {
        return tokenHash;
    }

    /**
     * @return the username
     */
    public String getUsername()
    {
        return username;
    }

    /**
     * @return the expiration
     */
    public Date getExpiration()
    {
        return expiration;
    }

    public boolean isExpired()
    {
        return new Date().after( expiration );
    }

}
