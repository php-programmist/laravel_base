function submit_button(task) {
	$("#task").val(task);
	$("#adminForm").submit();
}

// When the user scrolls the page, execute myFunction
window.onscroll = function () {
	myFunction()
};

// Get the toolbar
var toolbar = document.getElementById("toolbar");

// Get the offset position of the toolbar
var sticky = toolbar.offsetTop - 40;

// Add the sticky class to the toolbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
	if (window.pageYOffset >= sticky) {
		toolbar.classList.add("toolbar-fixed")
	} else {
		toolbar.classList.remove("toolbar-fixed");
	}
}
