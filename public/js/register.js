const pw = document.getElementById('password');
const pw2 = document.getElementById('password2');
const pwRule = document.getElementById('password-rule'); 
const pwRule2 = document.getElementById('password-rule2'); 


//focues the input for the username when page loads: 
function focus() {
	document.getElementById('username').focus();
}

function test() {
	if (pw.value.length >= 6) {
		pw.style.border = "1px solid green";
		pwRule.innerHTML = "";
	} else if (pw.value.length < 6 && pw.value.length > 0) {
		pw.style.border = "1px solid red";
		pwRule.innerHTML = "<img class='icon' src='img/error.svg' alt=''> Must be be over 6 characters long";
	
	} else {
		pw.style.border = "1px solid #1d1b38";
		pwRule.innerHTML = "";
	}

}

function test2() {
	if (pw2.value == pw.value && pw2.value.length >= 1 && pw.value.length >= 1) {
		pw2.style.border = "1px solid green";
		pwRule2.innerHTML = "<img class='icon' src='img/check.svg' alt=''> Password matches!";
		pwRule2.style.color = "green";

	} else {
		pw2.style.border = "1px solid red";
		pwRule2.innerHTML = "<img class='icon' src='img/error.svg' alt=''> Passwords do not match";
		pwRule2.style.color = "#e43f5a";
	}
}

