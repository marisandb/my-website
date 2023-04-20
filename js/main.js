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

	// var btn = document.getElementById('submitbtn')
	// var formMessage = document.getElementById('formMessage')
	
	// btn.addEventListener('click', function(){
	// 	formMessage.textContent = `You submitted this form! Unfortunately it doesn't work, but maybe one day!`
	// 	document.getElementById("contactForm").reset()
	// })

	var images = [
		{path: "images/holding-a-snake.jpg", description:"Marisa smiling in her wedding dress holding a snake."},
		{path: "images/family-picture.jpg", description:"Marisa with her husband who is holding their daughter on their wedding day."},
		{path: "images/hiking-perrot.jpg", description:"Marisa with her daughter at Perrot State Park."},
		{path: "images/the-dogs.jpg", description:"Pictured left is Marshmallow, Marisa's cream colored Shiba inu. Left is Odie the hound dog."}
	  ];
	
	
	  // STEP 1
	  // Get handles on the elements we need to work with
	  var mainImg = document.getElementById('mainImg')
	  var caption = document.getElementById('caption')
	  var btnPrev = document.getElementById('btnPrev')
	  var btnNext = document.getElementById('btnNext')
	
	  var currentImg = 0
	
	  // STEP 2
	  // Create a function to display an image object
	  function showImage(imgObj){
		mainImg.src = imgObj.path
		mainImg.alt = imgObj.description
		caption.innerHTML = imgObj.description
	  }
	
	  showImage(images[currentImg])
	
	  // STEP 3
	  // add an event handler function to the 'next' button
	  btnNext.addEventListener('click', function(){
		currentImg++
		if(currentImg > images.length - 1){
		  currentImg = 0
		}
		showImage(images[currentImg])
	  })
	
	  // STEP 4
	  // add an event handler function to the 'prev' button
	  btnPrev.addEventListener('click',function(){
		currentImg--
		if(currentImg < 0){
		  currentImg = images.length-1
		}
		showImage(images[currentImg])
	  })
});
