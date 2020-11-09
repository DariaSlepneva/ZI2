import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

public class Zadanie_4 {
    public static void main(final String[] args) throws Exception {
        System.out.println("Hello World!");

        Class.forName("org.mariadb.jdbc.Driver");
        final Connection conn = DriverManager
                .getConnection("jdbc:mariadb://localhost:3306/sd44498", "root", "root");
        final Statement statement = conn.createStatement();
        final ResultSet rs = statement.executeQuery("select * from customers");

        while (rs.next()) {
            final int id = rs.getInt(1);
            final String name = rs.getString("customerName");
            final int number = rs.getInt("customerNumber");
            System.out.println(id + " - " + name + " - " + number);
        }
    }
}
