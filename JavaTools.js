
//*
//* Trim a String
//*
function trim(pString){
  var iStart, iEnd;
  var sTrimmed = "";
  var cChar;

  // Return empty sting if parameter is undefined
  if (pString==null)
        return sTrimmed;

  iEnd = pString.length - 1;
  iStart = 0;
  bLoop = true;
  cChar = pString.charAt(iStart);
  while ((iStart < iEnd) && ((cChar == "\n") || (cChar == "\r") ||
                            (cChar == "\t") || (cChar == " "))){
     iStart ++;
     cChar = pString.charAt(iStart);
  }
  cChar = pString.charAt(iEnd);
  while ((iEnd >= 0) && ((cChar == "\n") || (cChar == "\r") ||
                        (cChar == "\t") || (cChar == " "))){
     iEnd-=1;
     cChar = pString.charAt(iEnd);
  }
  if (iStart <= iEnd){
     sTrimmed = pString.substring(iStart, iEnd + 1);
  } else {
     sTrimmed = "";
  }
        return sTrimmed;
}
function ChkEmail(vEmail) {
		regx=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		return !regx.test(vEmail);
}
function ChkBlanco(Str)
{
	var s = trim(Str);
	if (s.length == 0) {
		return true 
		}
		else 
		{
		return false;
		}
}
function trimLeftZeroes( str ) {
        var rString ;

        // Checking if number is zero
        if ( str == "0" )
                rString = "0" ;
        else {
                // Removing zeroes
                var string = new String( str ) ;
                var rightDigit ;

                rightDigit = string.charAt(0) ;

                if ( rightDigit == "0" )
                        rString = trimLeftZeroes( string.substr( 1 ) ) ;
                else
                        rString = string.toString() ;
        }

        return rString ;
}
function ChkNumero(num)
{
	return isNaN(trim(num));
}
 function ChkFecha(psDate) {
        var arrayOfStrings, bReturn;
        var iYear, iMonth, iDay;
		bReturn = true;
		bEmpty = true ;
		if (trim(psDate).length!=0) {
			arrayOfStrings = psDate.split("/")
			iMonth = parseInt(trimLeftZeroes(trim(arrayOfStrings[1])));
			iDay   = parseInt(trimLeftZeroes(trim(arrayOfStrings[0])));
			iYear  = parseInt(trimLeftZeroes(trim(arrayOfStrings[2])));

			if (isNaN(iYear) || isNaN(iMonth) || isNaN(iDay)) {
					bReturn = false;
			}
			if (iDay > 31 || iDay < 1 || iMonth < 1 || iMonth > 12 || iYear < 1) {
					bReturn = false;
			}
			if (iDay == 31 && "_1_3_5_7_8_10_12_".indexOf("_"+iMonth+"_") == -1 ) {
					bReturn = false;
			}
			if (iDay == 30 && iMonth == 2) {
					bReturn = false;
			}
			if (iDay == 29 && iMonth == 2 && !isLeapYear(iYear)) {
					bReturn = false;
			}
			
		} else
			bReturn = false;
		return bReturn;
}
