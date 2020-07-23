//this adds a loader for the first page: 
window.addEventListener("load", function() {
    const loader = document.querySelector(".loader");
    const header = document.querySelector(".header-text"); 
    header.className += " animate__fadeInRight";  
    loader.className += " hidden"; 
})