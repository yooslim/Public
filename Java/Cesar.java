package Algorithm;

/**
 *
 * @author YOo Slim
 */
public class Cesar {
    private static int default_key = 3;
    
    private static boolean isCorrectKey(int key) {
        if(key < 0 || key % 255 == 0) return false;
        else return true;
    }
    
    public static void setDefaultKey(int key) throws Exception {
        if(!isCorrectKey(key)) throw new Exception("Le nombre de César doit être positif, et son décalage efficace.");
        else default_key = key;
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
    
    public static String getCrypted(String original, int cesarKey) throws Exception {
        char [] or = original.toCharArray();
        String crypted = null;
        
        if(!isCorrectKey(cesarKey)) throw new Exception("Le nombre de César doit être positif, et son décalage efficace.");
        else {
            crypted = "";
            
            for(char a : or)
                crypted += (char) ((int) a + cesarKey);
        }
        
        return crypted;
    }
    
    public static String getDecrypted(String crypted, int cesarKey) throws Exception {
        char [] or = crypted.toCharArray();
        String original = null;
        
        if(!isCorrectKey(cesarKey)) throw new Exception("Ceci n'est pas une clé appropriée.");
        else {
            original = "";
            
            for(char a : or)
                original += (char) ((int) a - cesarKey);
        }
        
        return original;
    }
}
