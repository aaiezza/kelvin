package edu.rit.p3.util;

import static java.lang.System.getProperty;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

import org.springframework.core.io.FileSystemResource;

/**
 * Set properties from a properties file.
 *
 * @author Alex Aiezza
 */
public class PropertiesSetter
{
    /**
     * <p>
     * <strong>Property File:</strong>
     * <tt>${com.sun.aas.instanceRoot}/applications/beer-service/resources/project3.properties</tt>
     * </p>
     */
    private static final String PROPERTIES_FILE = getProperty( "com.sun.aas.instanceRoot" ) +
            "/applications/beer-service/resources/project3.properties";

    public PropertiesSetter() throws IOException
    {
        final InputStream inputStream = new FileSystemResource( PROPERTIES_FILE ).getInputStream();

        final Properties p = new Properties();
        p.load( inputStream );

        for ( final String name : p.stringPropertyNames() )
        {
            final String value = p.getProperty( name );
            System.setProperty( name, value );
        }
    }
}
