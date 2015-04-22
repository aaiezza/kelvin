package edu.rit.p3.util;

import java.util.Random;

public class HashGenerator
{
    public final static String generateHex()
    {
        final Random rand = new Random();
        final int r = rand.nextInt( 0x1000_0000 ) + 0x1000_0000;

        return Integer.toHexString( r );
    }
}
