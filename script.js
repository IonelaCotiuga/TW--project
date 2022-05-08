function logout()
{
  window.location = "../includes/logout.inc.php";
}

function expand() {
    var nav = document.getElementById("myTopnav");
    if (nav.className === "topnav") {
    nav.className += " responsive";
    } else {
    nav.className = "topnav";
    }
}
