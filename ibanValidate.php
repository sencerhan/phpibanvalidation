function ibanCheck($value)
{
    // Delete spaces
    $value = str_replace(' ', '', $value);

    // IBAN regex pattern
    $ibanPattern = '/^([A-Z]{2})(\d{2})([A-Z0-9]{1,30})$/';

    // Check format with regex
    if (!preg_match($ibanPattern, $value)) {
        return false;
    }

    // Move the four initial characters to the end of the string
    $rearranged = substr($value, 4) . substr($value, 0, 4);

    // Replace each letter in the string with two digits
    $numericIban = '';
    foreach (str_split($rearranged) as $char) {
        if (ctype_alpha($char)) {
            $numericIban .= ord($char) - ord('A') + 10;
        } else {
            $numericIban .= $char;
        }
    }

    // Perform the mod-97 operation
    $checksum = intval(substr($numericIban, 0, 1));
    for ($i = 1; $i < strlen($numericIban); $i++) {
        $checksum = intval($checksum . substr($numericIban, $i, 1)) % 97;
    }

    return $checksum === 1;
}            
      
 $iban="TR31 0011 1000 0000 0088 6941 31";
      
 if (ibanCheck($iban)) {
      echo "IBAN is valid!.";
 }else{
      echo "IBAN is not valid!.";
 }
