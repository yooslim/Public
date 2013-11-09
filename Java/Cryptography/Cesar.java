package Algorithm;

/**
 *
 * @author YOo Slim
 */
public class Cesar {
    private static int default_key = 3;
    
    public static void setNumber(int num) {
        if(num % 255 > 0) default_key = num;
    }
    
    public static String getCrypted(String original) {
        return getCrypted(original, default_key);
    }
    
    public static String getDecrypted(String crypted) {
        return getDecrypted(crypted, default_key);
    }
    
    public static String getCrypted(String original, int cesarNum) {
        char [] or = original.toCharArray();
        String newS = "";
                
        for(char a : or) {
            newS += (char) ((int) a + cesarNum);
        }
        
        return newS;
    }
    
    public static String getDecrypted(String crypted, int cesarNum) {
        char [] or = crypted.toCharArray();
        String original = "";
                
        for(char a : or) {
            original += (char) ((int) a - cesarNum);
        }
        
        return original;
    }
}
