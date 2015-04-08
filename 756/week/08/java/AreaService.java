import org.apache.xmlrpc.*;

// To run:
// java -cp .;commons-codec-1.3.jar;xmlrpc-2.0.jar AreaService

public class AreaService {
   public static void main(String[] args) {
      WebServer server = new WebServer(8100);
      System.out.println("Service created");
      
      server.addHandler("area", new AreaHandler());
      System.out.println("Handler registered");
      
      server.start();
      System.out.println("Service started");
   }
}