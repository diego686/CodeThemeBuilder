// Find difference between two arrays
Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};


function parseCode() {
	var func_definition_start = false;
	var is_in_func = false;

	var codeDiv = document.querySelector("code.language-gdscript");

	var code = codeDiv.getElementsByTagName("*");

	for (var i = 0; i < code.length; ++i) {
		if (code[i].classList.contains("keyword") && code[i].innerHTML == "func") {
			func_definition_start = true;
			is_in_func = false;
			// console.log(code[i]);
		}

		if (func_definition_start && code[i].classList.contains("punctuation") && code[i].innerHTML == ":") {
			is_in_func = true;
			func_definition_start = false;
			// console.log(code[i]);
		}

		if (is_in_func) {
			if (code[i].classList.contains("function")) {
				code[i].classList.add("inside");
			}
		}

		// if (!code[i].classList.contains("token")) {
		// 	console.log(code[i]);
		// }
	}
	// var strippedTest = codeDiv.innerHTML;
	var strippedTest = codeDiv.innerHTML.replace(/<span.*>.*<\/span>/ig,"");
	// var strippedTest = codeDiv.innerHTML.replace(/<.*>/ig,"");
	// console.log(strippedTest);
}

if(window.attachEvent) {
    window.attachEvent('onload', parseCode);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            parseCode(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = parseCode;
    }
}