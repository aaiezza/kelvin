public class AreaHandler
{
    public String helloWorld()
    {
        return "Hello Math Fans!";
    }

    public double calcCircle( double r )
    {
        return Math.PI * r * r;
    }

    public double calcRectangle( double w, double h )
    {
        return w * h;
    }

    public String [] getMethods()
    {
        String [] temp = { "double calcCircle(double r)",
                "double calcRectangle(double w, double h)" };
        return temp;
    }
}
