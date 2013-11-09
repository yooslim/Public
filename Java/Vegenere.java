package Algorithm;

/**
 *
 * @author YOo Slim
 */
public class Vegenere {
    private static String default_key = "default_value";
    
    private static boolean isCorrectKey(String key) {
        if(key.trim().isEmpty()) return false;
        else return true;
    }
    
    public static void setDefaultKey(String key) throws Exception {
        if(!isCorrectKey(key)) throw new Exception("La clé de végenere ne peut pas être vide.");
        else default_key = key.trim();
    }
    
    private static char getCSubstitution(char letter, char key) {
        int tmp = (int) letter + (int) key;
        return (char) (tmp % 255);
    }
    
    private static char getDSubstitution(char letter, char key) {
        int tmp = (int) letter - (int) key;
        tmp += (tmp < 0) ? 255 : 0;
        
        return (char) tmp;
    }
    
    public static String getCrypted(String original) throws Exception {
        String tmp = null;
        
        try {
            tmp = getCrypted(original, default_key); 
        }
        catch(Exception e) {
            throw e;
        }
        finally {
            return tmp;
        }
    }
    
    public static String getDecrypted(String crypted) throws Exception {
        String tmp = null;
        
        try {
            tmp = getDecrypted(crypted, default_key);
        }
        catch(Exception e) {
            throw e;
        }
        finally {
            return tmp;
        }
        
    }
    
    public static String getCrypted(String original, String key) throws Exception {
        char [] str = original.toCharArray();
        int keySize = key.length();
        String crypted = null;
        
        if(!isCorrectKey(key)) throw new Exception("La clé de végenere ne peut pas être vide.");
        else {
            crypted = "";
            
            for(int i = 0; i < str.length; i++)
                crypted += getCSubstitution(str[i], key.charAt(i%keySize));
        }
        
        return crypted;
    }
    
    public static String getDecrypted(String crypted, String key) throws Exception {
        char [] str = crypted.toCharArray();
        int keySize = key.length();
        String original = null;
        
        if(!isCorrectKey(key)) throw new Exception("La clé de végenere ne peut pas être vide.");
        else {
            original = "";
            
            for(int i = 0; i < str.length; i++)
                original += getDSubstitution(str[i], key.charAt(i%keySize));
        }
        
        return original;
    }
}