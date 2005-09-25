import java.io.IOException;

import com.mirlitone.jixmind.JiXmind;

import junit.framework.TestCase;
/*
 * Created on 25 sept. 2005
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */

/**
 * @author herbaut for IDEP
 * 
 */
public class TestIOFile extends TestCase {
    
    /**
     * 
     * @author herbaut for IDEP
     *
     */
    
    public void testEmptyFileName(){
        
        JiXmind jix = null;
        try{
            jix = new JiXmind("");
        }
        catch(IOException ioe){
            assertTrue("Veuillez Spécifier un nom de fichier",true);
            
        }
        catch(Exception e){
            assertFalse("Unhandled Exception",true);
            
            
        }
    }
    
    
       public void testInvalidFileName(){
           JiXmind jix = null;
           try{
               jix = new JiXmind("foofile");
           }
           catch(IOException ioe){
               assertTrue("Invalid File Name",true);
               
           }
           catch(Exception e){
               assertFalse("Unhandled Exception",true);
               
               
           }
           
       }
        
        
 }


