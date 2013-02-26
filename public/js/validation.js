/* 
 * Client-side validation
 * 
 */

//"use strict";

/* Object Validation
 * 
 */
Validation = {
    email : function(email){
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var valid = filter.test(email);
        //alert(valid);
        if(!valid){
            return false;
        }
        return true;
    },
    pwd : function(password,minlength) {
       if(password.length < minlength){
            return false;
       }
       return true;
    },
    isString : function(string) {
        var alphaExp = /^[a-zA-Z]+$/;
	if(string.match(alphaExp)) {
            return false;
        }
    }
}

