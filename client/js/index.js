let offset = 100;
let start;
let lastTimeStamp = 0;
let direction = -1;

const getPosters = async () => {
  try {
    const response = await fetch("/client/app/posters.php");
    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }
    const json = await response.json();
    return json;
  } catch (error) {
    console.log({ error: error });
  }
};

const posters = await getPosters();
const bgImage = document.getElementById("bgImage");
bgImage.style.backgroundImage = `url(${
  posters[Math.floor(Math.random() * posters.length)]
})`;

function animate(timestamp) {
  const deltaTime = (timestamp - lastTimeStamp) / 1000;
  lastTimeStamp = timestamp;

  // Reset offset to prevent overflow
  if (offset >= 100) {
    direction = -1;
    bgImage.style.backgroundImage = `url(${
      posters[Math.floor(Math.random() * posters.length)]
    })`;
  }
  if (offset <= -55) {
    direction = 1;
    bgImage.style.backgroundImage = `url(${
      posters[Math.floor(Math.random() * posters.length)]
    })`;
  }
  offset += 11 * deltaTime * direction;

  // Apply transforms to create movement
  bgImage.style.transform = `translateX(${offset}vw)`;

  requestAnimationFrame(animate);
}

// Start the animation
requestAnimationFrame(animate);
