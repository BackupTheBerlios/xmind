/*
 * Created on 25 sept. 2005
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */
package com.mirlitone.jixmind;

import java.awt.Component;
import java.awt.Dimension;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JPanel;

/**
 * @author herbaut for IDEP
 * 
 */
public class MyFrame extends JFrame {

    private JPanel mypanel;
    public  MyFrame(String title){
        super(title);
        mypanel = new JPanel();
        
        this.setSize(new Dimension(300,300));
        mypanel.setSize(new Dimension(300,300));
        
        super.add(mypanel);
        this.setVisible(true);
        this.setDefaultCloseOperation(EXIT_ON_CLOSE);
        
    }
    public Component add(Component comp){
        mypanel.add(comp);
        return comp;
    }
    
    public void repaint(){
        super.repaint();
        mypanel.repaint(0,0,300,300);
        mypanel.validate();
    }
    

    
}
