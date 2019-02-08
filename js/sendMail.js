function getAjax() {
    try {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            try {
                return new ActiveXObject('Msxml2.XMLHTTP');
            } catch (try_again) {
                return new ActiveXObject('Microsoft.XMLHTTP');
            }
        }
    } catch (fail) {
        return null;
    }
}

function sendMail() {
    var rq = getAjax();
	var name = document.getElementById("form-contact-name");
	var email = document.getElementById("form-contact-email");
	var message = document.getElementById("form-contact-message");
	var subject = "Website's contact - " + name.value + " - email: " + email.value;
    
    if (rq) {
        // Success; attempt to use an Ajax request to a PHP script to send the e-mail
        try {
            rq.open('POST', '../sendMail.php?q=' + + Math.random(), true);

            rq.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status >= 400) {
                        // The request failed; fall back to e-mail client
						alert("Failed to open the request; fall back to e-mail client");
                        window.location.replace('mailto:greenamsroboticsteam@gmail.com?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(message.value));
                    } else if (this.status == 200) {
						alert(this.responseText);
						name.disabled = false;
						email.disabled = false;
						message.disabled = false;
						name.value = "";
						email.value = "";
						message.value = "";
					}
                } else if (this.readyState != 0) {
					name.disabled = true;
					email.disabled = true;
					message.disabled = true;
				}
            };

            rq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			rq.send("subject=" + encodeURIComponent(subject) + "&message=" + encodeURIComponent(message.value));
        } catch (fail) {
            // Failed to open the request; fall back to e-mail client
			alert("Failed to open the request; fall back to e-mail client");
            window.location.replace('mailto:greenamsroboticsteam@gmail.com?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(message.value));
        }
    } else {
        // Failed to create the request; fall back to e-mail client
		alert("Failed to open the request; fall back to e-mail client");
        window.location.replace('mailto:greenamsroboticsteam@gmail.com?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(message.value));
    }
	return false;
}