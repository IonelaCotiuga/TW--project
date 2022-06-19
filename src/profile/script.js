if(window.location.hash)
{
  if(window.location.hash.substring(1) == "imgur")
    show(1);
  else if(window.location.hash.substring(1) == "instagram")
    show(2);
  else if(window.location.hash.substring(1) == "unsplash")
    show(3);
  else
    show(0);
}

function urlRedirect(url)
{
  window.location = url;
}

//search
function searchImages()
{
  const input = document.getElementById("search").value.toLowerCase();
  const boxes = document.getElementsByClassName("box");

  for(let i=0; i<boxes.length; i++)
  {
    let description = boxes[i].getElementsByTagName("p")[0].textContent.toLowerCase();
    let likes = boxes[i].getElementsByClassName("left-icons")[0].getElementsByTagName("i")[0].textContent;
    //remove space
    likes = likes.substring(1);

    if(description.indexOf(input) > -1 || likes.indexOf(input) > -1)
      boxes[i].style.display = "";
    else
      boxes[i].style.display = "none";
  }
}

function show(index)
{
  const facebook = document.getElementById("facebook-content");
  const imgur = document.getElementById("imgur-content");
  const instagram = document.getElementById("instagram-content");
  const unsplash = document.getElementById("unsplash-content");
  const platforms = [facebook, imgur, instagram, unsplash];

  const facebookButton = document.getElementById("facebook-button");
  const imgurButton = document.getElementById("imgur-button");
  const instagramButton = document.getElementById("instagram-button");
  const unsplashButton = document.getElementById("unsplash-button");
  const buttons = [facebookButton, imgurButton, instagramButton, unsplashButton];

  platforms.map(x => x.style.display = "none");
  buttons.map(x => x.style.textDecoration = "none");
  platforms[index].style.display = "block";
  buttons[index].style.textDecoration = "underline";

  if(platforms[index].getElementsByClassName("auth-button")[0])
    document.getElementById("search").style.display = "none";
  else
    document.getElementById("search").style.display = "inline";
}

//upload
const input = document.getElementById("image-input");
const image = document.getElementById("chosen-image");
const buttons = document.getElementsByClassName("modal-button");

const modal = document.getElementById("modal");
const button = document.getElementById("upload-button");
const close = document.getElementsByClassName("close")[0];

let filename = "";

input.addEventListener("change", function() {
  const reader = new FileReader();
  reader.readAsDataURL(this.files[0]);

  reader.addEventListener("load", function() {
    document.getElementById("loading-text").style.display = "block";

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../includes/uploadImage.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("image=" + encodeURIComponent(reader.result));

    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200)
      {
        document.getElementById("loading-text").style.display = "none";
        filename = xmlhttp.responseText;
        image.src = reader.result;
        image.style.display = "block";
        buttons[0].style.display = "inline"
        buttons[1].style.display = "inline";
      }
    };
  });
});

button.onclick = () => {
  modal.style.display = "block";
}

close.onclick = () => {
  modal.style.display = "none";
  image.style.display = "none";
  input.value = null;
  buttons[0].style.display = "none"
  buttons[1].style.display = "none";
}

window.onclick = (event) => {
  if(event.target == modal)
  {
    modal.style.display = "none";
    image.style.display = "none";
    input.value = null;
    buttons[0].style.display = "none"
    buttons[1].style.display = "none";
  }
}

function redirect(page)
{
    window.location = "../" + page + "?image=" + filename;
}
