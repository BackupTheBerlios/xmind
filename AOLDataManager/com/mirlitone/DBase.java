package com.mirlitone;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.LineNumberReader;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Vector;

import com.mysql.jdbc.Connection;
import com.mysql.jdbc.ResultSet;
import com.mysql.jdbc.Statement;


public class DBase
{
    public DBase()
    {
    }

    public Connection connect(String db_connect_str, 
  String db_userid, String db_password)
    {
        Connection conn;
        try 
        {
            Class.forName(  
    "com.mysql.jdbc.Driver").newInstance();

            conn = (Connection) DriverManager.getConnection(db_connect_str, 
    db_userid, db_password);
        
        }
        catch(Exception e)
        {
            e.printStackTrace();
            conn = null;
        }

        return conn;    
    }
    
    public void importDataInNewTable(Connection conn,String filename,String tableName)
    {
        Statement stmt;
        String query;

        try
        {
            stmt = (Statement) conn.createStatement(
    ResultSet.TYPE_SCROLL_SENSITIVE,
    ResultSet.CONCUR_UPDATABLE);

            query = "LOAD DATA  INFILE '"+filename+
    "' INTO TABLE "+tableName+" (AnonID,Query,QueryTime,ItemRank,ClickURL) IGNORE 1 LINES;";

            stmt.executeUpdate(query);
                
        }
        catch(Exception e)
        {
            e.printStackTrace();
            stmt = null;
        }
    }
    
	/**
	 * Facility to create a new user with rights on a new database.
	 * THis is done with the url jdbc:mysql://localhost:3306/mysql
	 * @param authUser User with the GRANT privilege
	 * @param authPwd Password of this user with the GRANT privilege
	 * @param newDbName Name of the newly created database	
	 * @param userName Name of the newly created user
	 */
	public static void createAndGrantPrivileges(String authUser, String authPwd, String newDbName, String userName){
		try {
		      Statement stmt;
		      
		      String url =
		            "jdbc:mysql://localhost:3306/mysql";
		      Connection con =
                (Connection) DriverManager.getConnection(
			              url,authUser, authPwd);
		      //System.out.println("URL: " + url);
		      //System.out.println("Connection: " + con);
		      stmt = (Statement) con.createStatement();
		      stmt.executeUpdate(
            "CREATE DATABASE "+newDbName);
		      
		      stmt.executeUpdate(
		              "GRANT SELECT,INSERT,UPDATE,DELETE," +
		              "CREATE,DROP " +
		              "ON JunkDB.* TO '"+userName+"'@'localhost' " +
		              "IDENTIFIED BY 'drowssap';");
		      
		      con.close();
	    }catch( Exception e ) {
	      e.printStackTrace();
	    }//end catch
	}

	
}




	


