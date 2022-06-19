const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let stickers = [];
let selectedImage = -1;
let sizeSlider = document.getElementById("size");
sizeSlider.addEventListener("input", resizeImage);

let startX;
let startY;

ctx.fillStyle = "white";
ctx.fillRect(0, 0, canvas.width, canvas.height);

function addImage(img)
{
  ctx.drawImage(img, canvas.width/2 - img.width/2, canvas.height/2 - img.height/2, img.width, img.height);

  let obj = {
    "x": canvas.width/2 - img.width/2,
    "y": canvas.height/2 - img.height/2,
    "width": img.width,
    "height": img.height,
    "src": img,
    "selected": false
  };
  stickers.push(obj);
}

function redraw()
{
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  for(let i=0; i<stickers.length; i++)
  {
    ctx.drawImage(stickers[i].src, stickers[i].x, stickers[i].y, stickers[i].width, stickers[i].height);

    if(stickers[i].selected == true)
    {
      ctx.fillStyle = "#797A7B";
      drawCircle(stickers[i].x, stickers[i].y, 5, 0, 2 * Math.PI);
      drawCircle(stickers[i].x + stickers[i].width, stickers[i].y + stickers[i].height, 5, 0, 2 * Math.PI);
      drawCircle(stickers[i].x, stickers[i].y + stickers[i].height, 5, 0, 2 * Math.PI);
      drawCircle(stickers[i].x + stickers[i].width, stickers[i].y, 5, 0, 2 * Math.PI);

      ctx.fillStyle = "#F2F3F5";
      drawCircle(stickers[i].x, stickers[i].y, 4, 0, 2 * Math.PI);
      drawCircle(stickers[i].x + stickers[i].width, stickers[i].y + stickers[i].height, 4, 0, 2 * Math.PI);
      drawCircle(stickers[i].x, stickers[i].y + stickers[i].height, 4, 0, 2 * Math.PI);
      drawCircle(stickers[i].x + stickers[i].width, stickers[i].y, 4, 0, 2 * Math.PI);
    }
  }
}

canvas.onmousedown = (e) => {
  let rect = e.target.getBoundingClientRect();
  let xCoord = e.clientX - rect.left;
  let yCoord = e.clientY - rect.top;

  for(let i=0; i<stickers.length; i++)
  {
    stickers[i].selected = false;

    //select image by clicking anywhere on it
    if(xCoord >= stickers[i].x && xCoord <= (stickers[i].x + stickers[i].width) && yCoord >= stickers[i].y && yCoord <= (stickers[i].y + stickers[i].height))
      selectedImage = i;
  }

  if(selectedImage != -1)
  {
    stickers[selectedImage].selected = true;
    sizeSlider.value = stickers[selectedImage].height;
  }

  startX = xCoord;
  startY = yCoord;
}
canvas.onmouseup = (e) => {
  selectedImage = -1;
  redraw();
}
canvas.onmousemove = (e) => {
  if(selectedImage != -1)
  {
    let rect = e.target.getBoundingClientRect();
    let xCoord = e.clientX - rect.left;
    let yCoord = e.clientY - rect.top;

    let distX = xCoord - startX;
    let distY = yCoord - startY;

    stickers[selectedImage].x += distX;
    stickers[selectedImage].y += distY;

    redraw();

    startX = xCoord;
    startY = yCoord;
  }
}

window.onclick = () => {
  const wrapper = document.getElementsByClassName("wrapper")[0];
  const result = document.getElementsByClassName("result")[0];
  const editor = document.getElementsByClassName("editor")[0];

  if(event.target == wrapper || event.target == result || event.target == editor)
  {
    selectedImage = -1;
    for(let i=0; i<stickers.length; i++)
    {
      stickers[i].selected = false;
    }
    redraw();
  }
}

function drawCircle(x, y, size)
{
  ctx.beginPath();
  ctx.arc(x, y, size, 0, 2 * Math.PI);
  ctx.fill();
}

function resizeImage()
{
  for(let i=0; i<stickers.length; i++)
  {
    if(stickers[i].selected == true)
    {
      let newWidth = parseInt(sizeSlider.value);
      stickers[i].height = (stickers[i].height / stickers[i].width) * newWidth;
      stickers[i].width = newWidth;
    }
  }

  redraw();
}

function removeImage()
{
  for(let i=0; i<stickers.length; i++)
  {
    if(stickers[i].selected == true)
      stickers.splice(i, 1);
  }

  redraw();
}

function removeAll()
{
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  stickers = [];
}

function saveImage()
{
  for(let i=0; i<stickers.length; i++)
  {
    if(stickers[i].selected == true)
      stickers[i].selected = false;
  }
  redraw();

  let downloadLink = document.createElement("a");
  downloadLink.download = "MPic_Image.png";
  downloadLink.href = document.getElementById("canvas").toDataURL("image/png");
  downloadLink.click();

  saveToServer(downloadLink.href);
}

function postImage()
{
  for(let i=0; i<stickers.length; i++)
  {
    if(stickers[i].selected == true)
      stickers[i].selected = false;
  }
  redraw();

  let image = document.getElementById("canvas").toDataURL("image/png");

  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "../includes/postImage.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("image=" + encodeURIComponent(image));

  let text = document.getElementById("text");
  text.style.display = "block";
  text.style.color = "black";
  text.innerHTML = "Uploading image...";

  xmlhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200)
    {
      text.style.color = "green";
      text.innerHTML = "Successfully uploaded image.";
      saveToServer(image);
    }
    else if(this.readyState == 4 && this.status == 403)
    {
      text.style.color = "red";
      text.innerHTML = "You must first authenticate in order to post an image.";
    }
  };
}

function saveToServer(url)
{
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "../includes/saveImage.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("image=" + encodeURIComponent(url) + "&type=image");
}
