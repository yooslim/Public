package Algorithm;

/**
 *
 * @author YOo Slim
 */
public class Vegenere {
    private static String default_key = "default_value";
    
    public static void setDefaultKey(String key) {
        String clean_key = key.trim();
        if(!clean_key.isEmpty()) default_key = clean_key;
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
    
    public static String getCrypted(String original) {
        return getCrypted(original, default_key);
    }
    
    public static String getDecrypted(String crypted) {
        return getDecrypted(crypted, default_key);
    }
    
    public static String getCrypted(String original, String ckey) {
        char [] str = original.toCharArray();
        int keySize = ckey.length();
        String result = "";
        
        for(int i = 0; i < str.length; i++) {
            result += getCSubstitution(str[i], ckey.charAt(i%keySize));
        }
        
        return result;
    }
    
    public static String getDecrypted(String crypted, String key) {
        char [] str = crypted.toCharArray();
        int keySize = key.length();
        String result = "";
        
        for(int i = 0; i < str.length; i++) {
            result += getDSubstitution(str[i], key.charAt(i%keySize));
        }
        
        return result;
    }
}