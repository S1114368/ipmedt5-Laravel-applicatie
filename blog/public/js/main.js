window.onload = function() {
  //Hamburger animatie
  let firstBar = document.getElementById("js--firstBar");
  let secondBar = document.getElementById("js--secondBar");
  let thirdBar = document.getElementById("js--thirdBar");

  // let navbarBg = document.getElementById("js--navbar-background")
  let barContainer = document.getElementById("js--barContainer");
  let mobileNav = document.getElementById("js--mobileNav");

  // dropdown menu & animatie
  barContainer.onmousedown = function() {
    mobileNav.classList.toggle("hide-nav");
    // navBar.classlist.toggle("bg-white");
    firstBar.classList.toggle('change');
    secondBar.classList.toggle('change');
    thirdBar.classList.toggle('change');
  }

  function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
}
