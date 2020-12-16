
function validate(form) 
{
	let fail = ""
	fail += validateUsername(form.username.value)
	fail += validatePassword(form.password.value)
	fail += validateEmail(form.email.value)
	if (fail == ""){
		return true
	} 
	else {
	 alert(fail);
	  return false 
	}
}


function validateUsername(field)
{
	if (field == "") return "No name was entered.\n"
	else if (field.length < 5)return "names must be at least 5 characters.\n"
	else if (/[^a-zA-Z0-9_-]/.test(field))return "Only a-z, A-Z, 0-9, - and _ allowed in names.\n"
	return ""
}

function validatePassword(field)
{
	if (field == "") return "No Password was entered.\n"
	else if (field.length < 6)return "Passwords must be at least 6 characters.\n"
	else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) ||!/[0-9]/.test(field))
	return "Passwords require one each of a-z, A-Z and 0-9.\n"
return ""
}

function validateEmail(field)
{
	if (field == "") return "No Email was entered.\n"
	else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
		return "The Email address is invalid.\n"
	return ""
}


function validate_upload(form){
	let fail = ""
	fail += isfileuploaded(form.filetoupload)
	if(fail == ""){
		fail += isValidExt(form.filetoupload)
		if(fail == ""){
			return true
		}
		else{
			alert(fail)
			return false
		}
	}
	else{
		alert(fail)
		return false
	}
}


function  isfileuploaded(field){
		if (field.files.length == 0){
			return "No File Upploaded.\n"
		}
		else{
			return ""
		}
}

function isValidExt(field){
	var _validFileExtensions = ["text/plain", "application/pdf", "application/zip"]
	var file = field.files[0]
	var bool = false
	for (var i = 0 ; i < _validFileExtensions.length; i++){
		if (file.type == _validFileExtensions[i]){
			bool = true
		}
	}

	if (bool == true){
		return ""
	}
	else{
		return " Not a valid file format"
	}
}


function validate_admin(form){
	let fail = ""
	fail += validateVirusName(form.virusName.value)
	if (fail == ""){
		return true
	} 
	else {
	 alert(fail);
	  return false 
	}

}

function validateVirusName(field){
	if(field.length == 0){
		return "Virus Name Cannot be empty.\n"
	}
	else if(/[^^a-zA-Z0-9]/.test(field)){
		return "hash value can only contain a-z, A-Z, 0-9.\n"
	}
	else{
		return ""
	}
}



