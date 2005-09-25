/*
 * Created on 25 sept. 2005
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */
package com.mirlitone.jixmind;

import java.awt.Component;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.JApplet;
import javax.swing.JButton;
import javax.swing.JFrame;

import org.xml.sax.Attributes;
import org.xml.sax.InputSource;
import org.xml.sax.SAXParseException;
import org.xml.sax.XMLReader;
import org.xml.sax.helpers.DefaultHandler;
import org.xml.sax.helpers.ParserAdapter;
import org.xml.sax.helpers.XMLReaderFactory;



/**
 * @author herbaut for IDEP
 * 
 */
public class JiXmind extends JApplet{

    
    public MyFrame jf;
    public Component mycomp;
    
    /**
     * Create all the stuff in a JFrame.
     * @param fileName Absolute name of the file
     * @throws Exception If there's a problem (file doesn't exist, file cannot be read...)
     */
    
    public JiXmind(String fileName) throws Exception{
        
        
        // Initialisation de la variable globale de la fenetre
        
        
        if(fileName==null || fileName.equals("")){
            throw new IOException("Please Enter a File Name");
        }
        File f = new File(fileName);
        if(f.isFile()==false || f.canRead()==false){
            throw new IOException("File not found or File not readable");
        }
        
        InputSource inputSource = new InputSource(new FileReader(f));
        XMLReader xr = XMLReaderFactory.createXMLReader();
        
        
        myDefaultHandler dh = new myDefaultHandler();
        xr.setContentHandler(dh);
        xr.setErrorHandler(dh);
        xr.parse(inputSource);
        
        
       
        
    }
    /**
     * 
     * @author herbaut for IDEP
     *
     */
    public class myDefaultHandler extends DefaultHandler{
        public void startDocument ()
        {
            jf=new MyFrame("Nouvelle Fenêtre JiXMind");
        }
        
  public void startElement (String uri, String name,
			      String qName, Attributes atts)
  {
	if(qName.equals("button")){
	  mycomp = new JButton();
	}
  }

  public void characters (char ch[], int start, int length)
  {
	String text="";
	for (int i = start; i < start + length; i++) {
	    switch (ch[i]) {
	    case '\\':
		System.out.print("\\\\");
		break;
	    case '"':
		System.out.print("\\\"");
		break;
	    case '\n':
		System.out.print("\\n");
		break;
	    case '\r':
		System.out.print("\\r");
		break;
	    case '\t':
		System.out.print("\\t");
		break;
	    default:
		text+=ch[i];
		break;
	    }
	   
	}
	 if(mycomp instanceof JButton){
		    mycomp=new JButton(text);
		    jf.add(mycomp);
		    mycomp=null;
		    jf.repaint();
		}
	
  }

}
  

  public void endElement (String uri, String name, String qName)
  {

  }
        
  
  void 	error(SAXParseException exception){
      System.out.println("A Error with XML parsing : " +exception);
  }
  
void 	fatalError(SAXParseException exception){
    System.out.println("A Fatal Error with XML parsing : " +exception);
}
 
void 	warning(SAXParseException exception){
    System.out.println("XML parsing Warning : " +exception);
}
  
  
    
    
    
    public static void main(String args[]) throws Exception {
     if(args.length>0){
         
             JiXmind jix = new JiXmind(args[0]);     
         
       
     }
     else{
        throw new IOException("No file Specified"); 
    	}
                
     }
    
    public void characters (char ch[], int start, int length)
    {
	System.out.print("Characters:    \"");
	for (int i = start; i < start + length; i++) {
	    switch (ch[i]) {
	    case '\\':
		System.out.print("\\\\");
		break;
	    case '"':
		System.out.print("\\\"");
		break;
	    case '\n':
		System.out.print("\\n");
		break;
	    case '\r':
		System.out.print("\\r");
		break;
	    case '\t':
		System.out.print("\\t");
		break;
	    default:
		System.out.print(ch[i]);
		break;
	    }
	}
	System.out.print("\"\n");
    }

  }
    

