package com.mirlitone;

import com.mysql.jdbc.Connection;

public class ADMTest {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		 DBase db = new DBase();
	        Connection conn = db.connect(
	    "jdbc:mysql://localhost:3306/aoldata","root","toor");
	        db.importDataInNewTable(conn,args[0],"mytable");	    

	    }
	
		


	}



