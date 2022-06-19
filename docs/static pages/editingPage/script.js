//image
let image = document.getElementById("chosen-image");

//filters
let blur = document.getElementById("blur");
let brightness = document.getElementById("brightness");
let contrast = document.getElementById("contrast");
let grayscale = document.getElementById("grayscale");
let huerotate = document.getElementById("hue-rotate");
let saturation = document.getElementById("saturation");
let sepia = document.getElementById("sepia");

//properties
let sliders = document.querySelectorAll(".filter input[type='range']");
let flipH = document.getElementById("flip-horizontal");
let flipV = document.getElementById("flip-vertical");

for(let i=0; i<sliders.length; i++)
  sliders[i].addEventListener("input", applyFilter);

flipH.addEventListener("input", flipImage);
flipV.addEventListener("input", flipImage);

//functions
function applyFilter()
{
  image.style.filter = `blur(${blur.value}px) brightness(${brightness.value}%) contrast(${contrast.value}%) grayscale(${grayscale.value}%) hue-rotate(${huerotate.value}deg) saturate(${saturation.value}%) sepia(${sepia.value}%)`;
}

function resetFilters()
{
  image.style.filter = '';
  image.style.transform = "translateY(-50%)";

  blur.value = "0";
  brightness.value = "100";
  contrast.value = "100";
  grayscale.value = "0";
  huerotate.value = "0";
  saturation.value = "100";
  sepia.value = "0";
  flipH.checked = false;
  flipV.checked = false;
}

function flipImage()
{
  if(flipH.checked && flipV.checked)
    image.style.transform = "translateY(-50%) scaleX(-1) scaleY(-1)";
  else if(flipH.checked && !flipV.checked)
    image.style.transform = "translateY(-50%) scaleX(-1)";
  else if(!flipH.checked && flipV.checked)
    image.style.transform = "translateY(-50%) scaleY(-1)";
  else image.style.transform = "translateY(-50%)";
}

//saving the image
function saveImage()
{
  const canvas = document.getElementById("canvas");
  canvas.width = image.naturalWidth;
  canvas.height = image.naturalHeight;

  const context = canvas.getContext("2d");
  context.filter = image.style.filter;

  if(flipH.checked && !flipV.checked)
  {
    context.scale(-1, 1);
    context.drawImage(image, 0, 0, image.naturalWidth * -1, image.naturalHeight);
  }
  else if(!flipH.checked && flipV.checked)
  {
    context.scale(1, -1);
    context.drawImage(image, 0, 0, image.naturalWidth, image.naturalHeight * -1);
  }
  else if(flipH.checked && flipV.checked)
  {
    context.scale(-1, -1);
    context.drawImage(image, 0, 0, image.naturalWidth * -1, image.naturalHeight * -1);
  }
  else
    context.drawImage(image, 0, 0, image.naturalWidth, image.naturalHeight);

  let downloadLink = document.createElement("a");
  downloadLink.download = "MPic_Image.png";
  downloadLink.href = document.getElementById("canvas").toDataURL("image/png");
  downloadLink.click();
}
