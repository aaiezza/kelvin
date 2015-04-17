import static java.lang.String.format;

import java.awt.BorderLayout;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.EventQueue;
import java.awt.Font;
import java.awt.GridBagConstraints;
import java.awt.GridBagLayout;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.net.MalformedURLException;
import java.net.URL;

import javax.swing.Box;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;
import javax.swing.SwingConstants;
import javax.swing.border.EmptyBorder;
import javax.xml.ws.WebServiceRef;

import beerservice.Beer;
import beerservice.BeerService;

/**
 * <p>
 * BeerClient uses the generated BeerService class to interact with the Beer
 * WSDL WebService.
 * </p>
 *
 * The jar file was generated using:<br>
 * <code>
 *  wsimport -clientjar beer-service.jar -p beerservice  http://simon.ist.rit.edu:8080/beer/BeerService?WSDL
 * </code>
 *
 * @author Alex Aiezza
 *
 */
public class BeerClient extends JFrame
{

    private static final long serialVersionUID = 1L;

    /**
     * Launch the application.
     */
    public static void main( final String [] args )
    {
        EventQueue.invokeLater( new Runnable()
        {
            @Override
            public void run()
            {
                try
                {
                    final BeerClient frame = new BeerClient();
                    frame.setVisible( true );
                } catch ( final Exception e )
                {
                    e.printStackTrace();
                }
            }
        } );
    }

    private final JPanel            contentPane;
    private final JTextField        serverLocation;
    private final JButton           updateServerButton;
    private final JPanel            northPanel;
    private final Box               horizontalBox;
    private final Component         horizontalStrut;
    private final JPanel            horizontalBox_1;
    private final JLabel            serverLocationLabel;
    private final Component         horizontalStrut_1;
    private final JButton           getMethodsButton;
    private final Component         horizontalStrut_2;
    private final JComboBox<String> getMethodsList;
    private final JPanel            horizontalBox_2;
    private final JButton           getBeersButton;
    private final Component         horizontalStrut_3;
    private final Component         horizontalStrut_4;
    private final JButton           getPriceButton;
    private final JTextField        getBeersPrice;
    private final Component         horizontalStrut_5;
    private final JPanel            horizontalBox_3;
    private final JButton           getCheapestButton;
    private final Component         horizontalStrut_6;
    private final JLabel            getCheapestPriceLabel;
    private final JTextField        getCheapestName;
    private final JTextField        getCheapestPrice;
    private final Component         horizontalStrut_7;
    private final JLabel            getCheapestNameLabel;
    private final JPanel            horizontalBox_4;
    private final JButton           getCostliestButton;
    private final Component         horizontalStrut_8;
    private final JLabel            getCostliestNameLabel;
    private final JTextField        getCostliestName;
    private final Component         horizontalStrut_9;
    private final JLabel            getCostliestPriceLabel;
    private final JTextField        getCostliestPrice;

    private final JComboBox<String> getBeersList;

    @WebServiceRef
    private BeerService             beerService;

    {
        beerService = new BeerService();
    }

    /**
     * Create the frame.
     */
    public BeerClient()
    {
        setTitle( "Beer Client" );
        setDefaultCloseOperation( JFrame.EXIT_ON_CLOSE );
        setBounds( 300, 300, 650, 350 );
        contentPane = new JPanel();
        contentPane.setBorder( null );
        setContentPane( contentPane );
        contentPane.setLayout( new BorderLayout( 0, 0 ) );

        northPanel = new JPanel();
        northPanel.setBorder( new EmptyBorder( 20, 20, 5, 20 ) );
        contentPane.add( northPanel, BorderLayout.NORTH );
        northPanel.setLayout( new GridLayout( 1, 1, 0, 0 ) );

        horizontalBox = Box.createHorizontalBox();
        northPanel.add( horizontalBox );

        serverLocationLabel = new JLabel( "Server:" );
        serverLocationLabel.setFont( new Font( "Verdana", Font.PLAIN, 18 ) );
        horizontalBox.add( serverLocationLabel );

        horizontalStrut = Box.createHorizontalStrut( 10 );
        horizontalBox.add( horizontalStrut );

        serverLocation = new JTextField();
        horizontalBox.add( serverLocation );
        serverLocation.setHorizontalAlignment( SwingConstants.LEFT );
        serverLocation.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        serverLocation.setColumns( 25 );

        horizontalStrut_1 = Box.createHorizontalStrut( 10 );
        horizontalBox.add( horizontalStrut_1 );

        updateServerButton = new JButton( "Update Server" );
        horizontalBox.add( updateServerButton );
        updateServerButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );

        final JPanel centerPanel = new JPanel();
        centerPanel.setBorder( new EmptyBorder( 5, 20, 20, 20 ) );
        contentPane.add( centerPanel, BorderLayout.CENTER );
        centerPanel.setLayout( new GridLayout( 4, 1, 0, 0 ) );


        // First Row
        horizontalBox_1 = new JPanel();
        centerPanel.add( horizontalBox_1 );
        final GridBagLayout gbl_horizontalBox_1 = new GridBagLayout();
        gbl_horizontalBox_1.columnWidths = new int [] { 150 };
        gbl_horizontalBox_1.columnWeights = new double [] { 0.0, 0.0, 1.0 };
        horizontalBox_1.setLayout( gbl_horizontalBox_1 );

        getMethodsButton = new JButton( "Get Methods" );
        getMethodsButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getMethodsButton = new GridBagConstraints();
        gbc_getMethodsButton.fill = GridBagConstraints.BOTH;
        gbc_getMethodsButton.gridx = 0;
        gbc_getMethodsButton.gridy = 0;
        horizontalBox_1.add( getMethodsButton, gbc_getMethodsButton );

        horizontalStrut_2 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_2 = new GridBagConstraints();
        gbc_horizontalStrut_2.fill = GridBagConstraints.BOTH;
        gbc_horizontalStrut_2.gridx = 1;
        gbc_horizontalStrut_2.gridy = 0;
        horizontalBox_1.add( horizontalStrut_2, gbc_horizontalStrut_2 );

        getMethodsList = new JComboBox<String>();
        getMethodsList.setMaximumSize( new Dimension( getMethodsList.getMaximumSize().width,
            getMethodsList.getPreferredSize().height ) );
        getMethodsList.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getMethodsList = new GridBagConstraints();
        gbc_getMethodsList.fill = GridBagConstraints.BOTH;
        gbc_getMethodsList.gridx = 2;
        gbc_getMethodsList.gridy = 0;
        horizontalBox_1.add( getMethodsList, gbc_getMethodsList );


        // Second Row
        horizontalBox_2 = new JPanel();
        centerPanel.add( horizontalBox_2 );
        final GridBagLayout gbl_horizontalBox_2 = new GridBagLayout();
        gbl_horizontalBox_2.columnWidths = new int [] { 150, 0, 0, 0, 150, 0 };
        gbl_horizontalBox_2.columnWeights = new double [] { 0.0, 0.0, 1.0, 0.0, 0.0, 0.0, 1.0 };
        horizontalBox_2.setLayout( gbl_horizontalBox_2 );

        getBeersButton = new JButton( "Get Beers" );
        getBeersButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getBeersButton = new GridBagConstraints();
        gbc_getBeersButton.gridx = 0;
        gbc_getBeersButton.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( getBeersButton, gbc_getBeersButton );

        horizontalStrut_3 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_3 = new GridBagConstraints();
        gbc_horizontalStrut_3.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( horizontalStrut_3, gbc_horizontalStrut_3 );

        getBeersList = new JComboBox<String>();
        getBeersList.setMaximumSize( new Dimension( getBeersList.getMaximumSize().width,
            getBeersList.getPreferredSize().height ) );
        getBeersList.setMinimumSize( new Dimension( 30, getBeersList.getMinimumSize().height ) );
        getBeersList.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getBeersList = new GridBagConstraints();
        gbc_getBeersList.gridy = 0;
        gbc_getBeersList.gridx = 2;
        gbc_getBeersList.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( getBeersList, gbc_getBeersList );

        getBeersList.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                getBeersPrice.setText( "" );
            }
        } );

        horizontalStrut_4 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_4 = new GridBagConstraints();
        gbc_horizontalStrut_4.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( horizontalStrut_4, gbc_horizontalStrut_4 );

        getPriceButton = new JButton( "Get Price" );
        getPriceButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getPriceButton = new GridBagConstraints();
        gbc_getPriceButton.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( getPriceButton, gbc_getPriceButton );

        horizontalStrut_5 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_5 = new GridBagConstraints();
        gbc_horizontalStrut_5.fill = GridBagConstraints.BOTH;
        horizontalBox_2.add( horizontalStrut_5, gbc_horizontalStrut_5 );

        getBeersPrice = new JTextField();
        getBeersPrice.setAlignmentY( 0.45f );
        getBeersPrice.setEditable( false );
        getBeersPrice.setMaximumSize( new Dimension( getBeersPrice.getMaximumSize().width,
            getBeersPrice.getPreferredSize().height ) );
        getBeersPrice.setColumns( 5 );
        getBeersPrice.setHorizontalAlignment( SwingConstants.LEFT );
        getBeersPrice.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getBeersPrice = new GridBagConstraints();
        gbc_getBeersPrice.fill = GridBagConstraints.BOTH;
        gbc_getBeersPrice.gridy = 0;
        horizontalBox_2.add( getBeersPrice, gbc_getBeersPrice );


        // Third Row
        horizontalBox_3 = new JPanel();
        centerPanel.add( horizontalBox_3 );
        final GridBagLayout gbl_horizontalBox_3 = new GridBagLayout();
        gbl_horizontalBox_3.columnWidths = new int [] { 150 };
        gbl_horizontalBox_3.columnWeights = new double [] { 0.0, 0.0, 0.0, 1.0, 0.0, 0.0, 1.0 };
        horizontalBox_3.setLayout( gbl_horizontalBox_3 );

        getCheapestButton = new JButton( "Get Cheapest" );
        getCheapestButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getCheapestButton = new GridBagConstraints();
        gbc_getCheapestButton.gridx = 0;
        gbc_getCheapestButton.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( getCheapestButton, gbc_getCheapestButton );

        horizontalStrut_6 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_6 = new GridBagConstraints();
        gbc_horizontalStrut_6.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( horizontalStrut_6, gbc_horizontalStrut_6 );

        getCheapestNameLabel = new JLabel( "Name: " );
        getCheapestNameLabel.setFont( new Font( "Verdana", Font.PLAIN, 18 ) );
        final GridBagConstraints gbc_getCheapestNameLabel = new GridBagConstraints();
        gbc_getCheapestNameLabel.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( getCheapestNameLabel, gbc_getCheapestNameLabel );

        getCheapestName = new JTextField();
        getCheapestName.setEditable( false );
        getCheapestName.setMaximumSize( getCheapestName.getPreferredSize() );
        getCheapestName.setHorizontalAlignment( SwingConstants.LEFT );
        getCheapestName.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        getCheapestName.setColumns( 25 );
        getCheapestName.setAlignmentY( 0.45f );
        final GridBagConstraints gbc_getCheapestName = new GridBagConstraints();
        gbc_getCheapestName.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( getCheapestName, gbc_getCheapestName );

        horizontalStrut_7 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_7 = new GridBagConstraints();
        gbc_horizontalStrut_7.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( horizontalStrut_7, gbc_horizontalStrut_7 );

        getCheapestPriceLabel = new JLabel( "Price: " );
        getCheapestPriceLabel.setFont( new Font( "Verdana", Font.PLAIN, 18 ) );
        final GridBagConstraints gbc_getCheapestPriceLabel = new GridBagConstraints();
        gbc_getCheapestPriceLabel.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( getCheapestPriceLabel, gbc_getCheapestPriceLabel );

        getCheapestPrice = new JTextField();
        getCheapestPrice.setMaximumSize( getCheapestPrice.getPreferredSize() );
        getCheapestPrice.setHorizontalAlignment( SwingConstants.LEFT );
        getCheapestPrice.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        getCheapestPrice.setEditable( false );
        getCheapestPrice.setColumns( 25 );
        getCheapestPrice.setAlignmentY( 0.45f );
        final GridBagConstraints gbc_getCheapestPrice = new GridBagConstraints();
        gbc_getCheapestPrice.fill = GridBagConstraints.BOTH;
        horizontalBox_3.add( getCheapestPrice, gbc_getCheapestPrice );


        // Fourth Row
        horizontalBox_4 = new JPanel();
        centerPanel.add( horizontalBox_4 );
        final GridBagLayout gbl_horizontalBox_4 = new GridBagLayout();
        gbl_horizontalBox_4.columnWidths = new int [] { 150 };
        gbl_horizontalBox_4.columnWeights = new double [] { 0.0, 0.0, 0.0, 1.0, 0.0, 0.0, 1.0 };
        horizontalBox_4.setLayout( gbl_horizontalBox_4 );

        getCostliestButton = new JButton( "Get Costliest" );
        getCostliestButton.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        final GridBagConstraints gbc_getCostliestButton = new GridBagConstraints();
        gbc_getCostliestButton.gridx = 0;
        gbc_getCostliestButton.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( getCostliestButton, gbc_getCostliestButton );

        horizontalStrut_8 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_8 = new GridBagConstraints();
        gbc_horizontalStrut_8.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( horizontalStrut_8, gbc_horizontalStrut_8 );

        getCostliestNameLabel = new JLabel( "Name: " );
        getCostliestNameLabel.setFont( new Font( "Verdana", Font.PLAIN, 18 ) );
        final GridBagConstraints gbc_getCostliestNameLabel = new GridBagConstraints();
        gbc_getCostliestNameLabel.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( getCostliestNameLabel, gbc_getCostliestNameLabel );

        getCostliestName = new JTextField();
        getCostliestName.setEditable( false );
        getCostliestName.setMaximumSize( new Dimension( 6, 22 ) );
        getCostliestName.setHorizontalAlignment( SwingConstants.LEFT );
        getCostliestName.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        getCostliestName.setColumns( 25 );
        getCostliestName.setAlignmentY( 0.45f );
        final GridBagConstraints gbc_getCostliestName = new GridBagConstraints();
        gbc_getCostliestName.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( getCostliestName, gbc_getCostliestName );

        horizontalStrut_9 = Box.createHorizontalStrut( 10 );
        final GridBagConstraints gbc_horizontalStrut_9 = new GridBagConstraints();
        gbc_horizontalStrut_9.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( horizontalStrut_9, gbc_horizontalStrut_9 );

        getCostliestPriceLabel = new JLabel( "Price: " );
        getCostliestPriceLabel.setFont( new Font( "Verdana", Font.PLAIN, 18 ) );
        final GridBagConstraints gbc_getCostliestPriceLabel = new GridBagConstraints();
        gbc_getCostliestPriceLabel.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( getCostliestPriceLabel, gbc_getCostliestPriceLabel );

        getCostliestPrice = new JTextField();
        getCostliestPrice.setMaximumSize( new Dimension( 6, 22 ) );
        getCostliestPrice.setHorizontalAlignment( SwingConstants.LEFT );
        getCostliestPrice.setFont( new Font( "Verdana", Font.PLAIN, 16 ) );
        getCostliestPrice.setEditable( false );
        getCostliestPrice.setColumns( 25 );
        getCostliestPrice.setAlignmentY( 0.45f );
        final GridBagConstraints gbc_getCostliestPrice = new GridBagConstraints();
        gbc_getCostliestPrice.fill = GridBagConstraints.BOTH;
        horizontalBox_4.add( getCostliestPrice, gbc_getCostliestPrice );

        // Action Events
        updateServerButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                try
                {
                    beerService = new BeerService( new URL( serverLocation.getText() ), beerService
                        .getServiceName() );
                } catch ( final MalformedURLException e1 )
                {
                    JOptionPane.showMessageDialog( null, e1.getMessage() );
                }
            }
        } );

        getMethodsButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                getMethodsList.removeAllItems();
                for ( final String method : getBeerPort().getMethods() )
                    getMethodsList.addItem( method );
            }
        } );

        getBeersButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                getBeersList.removeAllItems();
                for ( final String beer : getBeerPort().getBeers() )
                    getBeersList.addItem( beer );
            }
        } );

        getBeersPrice.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                if ( getBeersList.getItemCount() <= 0 )
                    JOptionPane.showMessageDialog( null, "There is no beer to get the Price of!" );
                else getBeersPrice.setText( format( "$%.2f",
                    getBeerPort().getPrice( (String) getBeersList.getSelectedItem() ) ) );
            }
        } );

        getPriceButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                if ( getBeersList.getItemCount() <= 0 )
                    JOptionPane.showMessageDialog( horizontalBox_1,
                            "There is no beer to get the price of!" );
                else getBeersPrice.setText( format( "$%.2f",
                    getBeerPort().getPrice( (String) getBeersList.getSelectedItem() ) ) );
            }
        } );

        getCheapestButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                final String beer = getBeerPort().getCheapest();
                getCheapestName.setText( beer );
                getCheapestPrice.setText( format( "$%.2f", getBeerPort().getPrice( beer ) ) );
            }
        } );

        getCostliestButton.addActionListener( new ActionListener()
        {
            @Override
            public void actionPerformed( final ActionEvent e )
            {
                final String beer = getBeerPort().getCostliest();
                getCostliestName.setText( beer );
                getCostliestPrice.setText( format( "$%.2f", getBeerPort().getPrice( beer ) ) );
            }
        } );

        serverLocation.setText( beerService.getWSDLDocumentLocation().toString() );
    }

    public Beer getBeerPort()
    {
        return beerService.getBeerPort();
    }

}
