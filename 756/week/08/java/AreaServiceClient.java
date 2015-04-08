import org.apache.xmlrpc.*;
import java.util.Vector;
import java.io.IOException;
import java.net.MalformedURLException;

public class AreaServiceClient {
   public static void main(String[] args) {
      try {
         XmlRpcClient client = new XmlRpcClient("http://localhost:8100/");
         Vector<Double> params = new Vector<Double>();
         
         Object result = client.execute("area.getMethods", params);
         //Object result = client.execute("system.listMethods", params);
         System.out.println(result.toString());
         
         result = client.execute("area.helloWorld", params);
         System.out.println(result.toString());
         
         params.addElement(10.0);
         result = client.execute("area.calcCircle", params);
         System.out.println(result.toString());
         
         params.addElement(5.0);
         result = client.execute("area.calcRectangle", params);
         System.out.println(result.toString());
      }
      catch( XmlRpcException e ) {
         System.out.println("XMLRPC error: " + e.getMessage());
      }
      catch( MalformedURLException e ) {
         System.out.println("Bad URL error: " + e.getMessage());
      }
      catch( IOException e ) {
         System.out.println("IO error: " + e.getMessage());
      }
   }
}