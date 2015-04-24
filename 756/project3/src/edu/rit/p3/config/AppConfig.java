/**
 * 
 */
package edu.rit.p3.config;

import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.PropertySource;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.web.BeerController;

/**
 * @author Alex Aiezza
 *
 */
@Configuration
@PropertySource ( "classpath:/resources/project3.properties" )
@ComponentScan ( basePackageClasses = { BeerJdbcManager.class, BeerController.class } )
public class AppConfig
{}
