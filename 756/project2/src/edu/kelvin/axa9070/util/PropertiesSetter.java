package edu.kelvin.axa9070.util;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

import org.springframework.core.io.FileSystemResource;

/**
 * Set properties from a properties file
 * 
 * @author Alex Aiezza
 */
public class PropertiesSetter
{
    private static final String PROPERTIES_FILE = "resources/beer_service.properties";

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
