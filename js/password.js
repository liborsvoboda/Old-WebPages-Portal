/* Intelligent Web NameSpace */
var IW = IW || {};

/**
 * Password validator logic
 */
(function(IW) {

    var secondsInADay = 86400;

    function PasswordValidator() {
    }

    /**
     * How long a password can be expected to last
     */
    PasswordValidator.prototype.passwordLifeTimeInDays = 365;

    /**
     * An estimate of how many attempts could be made per second to guess a password
     */
    PasswordValidator.prototype.passwordAttemptsPerSecond = 500;

    /**
     * An array of regular expressions to match against the password. Each is associated
     * with the number of unique characters that each expression can match.
     * @param password
     */
    PasswordValidator.prototype.expressions = [
        {
            regex : /[A-Z]+/,
            uniqueChars : 26
        },
        {
            regex : /[a-z]+/,
            uniqueChars : 26
        },
        {
            regex : /[0-9]+/,
            uniqueChars : 10
        },
        {
            regex : /[!\?.;,\\@$L#*()%~<>{}\[\]]+/,
            uniqueChars : 17
        }
    ];

    /**
     * Checks the supplied password
     * @param {String} password
     * @return The predicted lifetime of the password, as a percentage of the defined password lifetime.
     */
    PasswordValidator.prototype.checkPassword = function(password) {

        var
                expressions = this.expressions,
                i,
                l = expressions.length,
                expression,
                possibilitiesPerLetterInPassword = 0;

        for (i = 0; i < l; i++) {

            expression = expressions[i];

            if (expression.regex.exec(password)) {
                possibilitiesPerLetterInPassword += expression.uniqueChars;
            }

        }

        var
                totalCombinations = Math.pow(possibilitiesPerLetterInPassword, password.length),
            // how long, on average, it would take to crack this (@ 200 attempts per second)
                crackTime = ((totalCombinations / this.passwordAttemptsPerSecond) / 2) / secondsInADay,
            // how close is the time to the projected time?
                percentage = crackTime / this.passwordLifeTimeInDays;

        return Math.min(Math.max(password.length * 5, percentage * 100), 100);

    };

    IW.PasswordValidator = new PasswordValidator();

})(IW);

/**
 * jQuery plugin which allows you to add password validation to any
 * form element.
 */
(function(IW, jQuery) {

    function updatePassword() {

        var
                percentage = IW.PasswordValidator.checkPassword(this.val()),
                progressBar = this.parent().find(".passwordStrengthBar div");

        progressBar
                .removeClass("strong medium weak useless")
                .stop()
                .animate({"width": percentage + "%"});

        if (percentage > 90) {
            progressBar.addClass("strong");
        } else if (percentage > 50) {
            progressBar.addClass("medium")
        } else if (percentage > 10) {
            progressBar.addClass("weak");
        } else {
            progressBar.addClass("useless");
        }
    }

    jQuery.fn.passwordValidate = function() {

        this
                .bind('keyup', jQuery.proxy(updatePassword, this))
                .after("<div class='passwordStrengthBar' title='Bezpečnost Hesla'>" +
                "<div></div>" +
                "</div>");

        updatePassword.apply(this);

        return this; // for chaining

    }

})(IW, jQuery);

/* Have all the password elements on the page validate */
jQuery("input[id='lpassword']").passwordValidate();


function checkEmail(strEmail){
  validRegExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  strEmail = document.forms[0].email.value;

    if (strEmail.search(validRegExp) == -1)
   {
      alert('Zadaná emailová adresa není správná. Zadejte ji znovu.');
      return false;
    }
    return true;
}


    function checkPass(){
      var lpassword = document.getElementById('lpassword');
      var lpassword1 = document.getElementById('lpassword1');
      var message = document.getElementById('confirmMessage');
      var goodColor = "#66cc66";
      var badColor = "#FFB0B0";
	  var message = document.getElementById('confirmMessageImg');
      if(lpassword.value == lpassword1.value){
        lpassword.style.backgroundColor = goodColor;
        lpassword1.style.backgroundColor = goodColor;
        message.innerHTML = '<img src="./picture/tick.png" alt="Hesla Souhlasí" title="Hesla Souhlasí">';
      }else{
        lpassword1.style.backgroundColor = badColor;
        message.innerHTML = '<img src="./picture/ntick.png" alt="Hesla Nesouhlasí" title="Hesla Nesouhlasí">';
      }
    }



function checkuser(usrname) {
document.getElementById('checkuser').innerHTML="Please wait...";

script = document.createElement('script');
script.src = './checkuser.php?username=' + usrname;
document.getElementsByTagName('head')[0].appendChild(script);
}
