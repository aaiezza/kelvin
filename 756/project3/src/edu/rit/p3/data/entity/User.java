package edu.rit.p3.data.entity;


/**
 * This class represents the entity that is a user.
 *
 * @author Alex Aiezza
 *
 */
public class User
{
    private final String  username;
    private final String  password;
    private final int     age;
    private final boolean accessLevel;

    public User(
            final String username,
            final String password,
            final int age,
            final boolean accessLevel )
    {
        this.username = username;
        this.password = password;
        this.age = age;
        this.accessLevel = accessLevel;
    }

    /**
     * @return the age
     */
    public int getAge()
    {
        return age;
    }

    /**
     * @return the password
     */
    public String getPassword()
    {
        return password;
    }

    /**
     * @return the username
     */
    public String getUsername()
    {
        return username;
    }

    /**
     * @return the accessLevel. <tt>true</tt> means this user has admin level
     *         access.
     */
    public boolean isAccessLevel()
    {
        return accessLevel;
    }
}
