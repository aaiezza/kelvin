/**
 * 
 */
package edu.rit.p3.config;

import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.ServletRegistration;

import org.springframework.web.WebApplicationInitializer;
import org.springframework.web.context.ContextLoaderListener;
import org.springframework.web.context.support.AnnotationConfigWebApplicationContext;
import org.springframework.web.servlet.DispatcherServlet;
import org.springframework.ws.transport.http.MessageDispatcherServlet;

/**
 * @author Alex Aiezza
 *
 */
public class WebInit implements WebApplicationInitializer
{
    @Override
    public void onStartup( ServletContext container ) throws ServletException
    {
        // Create the 'root' Spring application context
        AnnotationConfigWebApplicationContext rootContext = new AnnotationConfigWebApplicationContext();
        rootContext.register( AppConfig.class );

        // Manage the lifecycle of the root application context
        container.addListener( new ContextLoaderListener( rootContext ) );

        // Create the dispatcher servlet's Spring application context
        AnnotationConfigWebApplicationContext dispatcherContext = new AnnotationConfigWebApplicationContext();
        dispatcherContext.register( MessageDispatcherServlet.class );

        // Register and map the dispatcher servlet
        ServletRegistration.Dynamic dispatcher = container.addServlet( "beer-dispatcher",
            new DispatcherServlet( dispatcherContext ) );
        dispatcher.setLoadOnStartup( 1 );
        dispatcher.addMapping( "/" );
    }
}
