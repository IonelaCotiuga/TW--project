const image = document.getElementById("chosen-image");
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

//draw the image on the canvas
canvas.width = image.width;
canvas.height = image.height;
ctx.drawImage(image, 0, 0, image.width, image.height);

image.style.display = "none";

//copy contents for creating the pattern
const newCanvas = document.getElementById('canvas2');
const newCtx = newCanvas.getContext("2d");
newCanvas.width = canvas.width;
newCanvas.height = canvas.height;
newCtx.drawImage(canvas, 0, 0);

//get mouse coordinates
let coordinates = [];
let saveCoordinates = [];
canvas.onclick = function clickEvent(e)
{
  let rect = e.target.getBoundingClientRect();
  let x = e.clientX - rect.left;
  let y = e.clientY - rect.top;

  let point = {
    "x": x,
    "y": y
  };
  coordinates.push(point);

  ctx.fillStyle = "blue";
  ctx.fillRect(x, y, 5, 5);
}

//crop the image
function crop()
{
  ctx.beginPath();

  //create the clipping path
  ctx.moveTo(coordinates[0].x, coordinates[0].y);
  saveCoordinates.push(coordinates[0]);
  for(let i=1; i<coordinates.length; i++)
  {
    saveCoordinates.push(coordinates[i]);
    ctx.lineTo(coordinates[i].x, coordinates[i].y);
  }
  ctx.lineTo(coordinates[0].x, coordinates[0].y);
  ctx.stroke();

  //make the rest of the canvas transparent
  ctx.save();
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.restore();

  //crop selection
  ctx.clip();

  //redraw the image in the cropped area
  let pattern = ctx.createPattern(newCanvas, "repeat");
  ctx.fillStyle = pattern;
  ctx.fill();

  ctx.closePath();

  coordinates = [];
}

function save()
{
  //reset the auxiliary canvas
  newCtx.clearRect(0, 0, newCanvas.width, newCanvas.height);

  if(saveCoordinates.length > 0)
  {
    //get new dimensions
    let top = canvas.height;
    let left = canvas.width;
    let right = -canvas.width;
    let bottom = -canvas.height;
    for(let i=0; i<saveCoordinates.length; i++)
    {
      if(saveCoordinates[i].y < top)
        top = saveCoordinates[i].y;
      if(saveCoordinates[i].x < left)
        left = saveCoordinates[i].x;
      if(saveCoordinates[i].x > right)
        right = saveCoordinates[i].x;
      if(saveCoordinates[i].y > bottom)
        bottom = saveCoordinates[i].y;
    }

    newCanvas.width = right-left;
    newCanvas.height = bottom-top;

    //save the new image
    newCtx.drawImage(canvas, left, top, newCanvas.width, newCanvas.height, 0, 0, newCanvas.width, newCanvas.height);
  }
  else
  {
    newCanvas.width = canvas.width;
    newCanvas.height = canvas.height;
    newCtx.drawImage(canvas, 0, 0);
  }

  let downloadLink = document.createElement("a");
  downloadLink.download = "MPic_Sticker.png";
  downloadLink.href = newCanvas.toDataURL("image/png");

  //save image on the server
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "../includes/saveImage.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("image=" + encodeURIComponent(downloadLink.href) + "&type=crop");

  document.getElementById("text").style.display = "block";
}

//reset selection
function reset()
{
  image.style.display = "block";
  canvas.width = image.width;
  canvas.height = image.height;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(image, 0, 0, image.width, image.height);
  image.style.display = "none";

  coordinates = [];
  saveCoordinates = [];

  document.getElementById("text").style.display = "none";
}
