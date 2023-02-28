window.addEventListener('load', function(){
	// JavaScript code goes here

	var btnNav = document.getElementById("mobile-nav-button");
	var mainNav = document.getElementById("main-nav");

	window.addEventListener('click', function(evt){
		
		if(evt.target == btnNav){

			if(mainNav.classList.contains("show")){
				mainNav.classList.remove("show");
			}else{
				mainNav.classList.add("show");
			}
		}else{
			mainNav.classList.remove("show");
		}
	});

});