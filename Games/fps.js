/* setTimeout vs setInterval vs requestAnimationFrame 
So each has it's folleys;
  setTimeout has to be called each time, so there is the opportunity that something will happen and that call won't happen again.
  setInterval drifts by a few ms each call, tries to 'catch up' on missed milliseconds, and will
  requestAnimationFrame has the habit of skipping frame, or just not executing as immediately as call the function again regardless of the app state you want.
  Refs - http://stackoverflow.com/questions/13233672/properly-handling-timing-for-html5-canvas-engine
*/

/* modify these to affect performance and functionality */
var fpsOutput = document.getElementById('fpsOutput'); // where to send the FPS numbers
var fpsFilter = 1; // the low pass filter to apply to the FPS average, 1 = none
var fpsDesired = 100; // your desired FPS, also works as a max

/* don't touch these ;) */
var fpsAverage = fpsDesired;
var timeCurrent, timeLast = Date.now();
var drawing = false;

/* these are for demo code, not needed for FPS */
var sun = new Image();
var moon = new Image();
var earth = new Image();
var stars = new Image();

function fpsUpdate() {
    fpsOutput.innerHTML = fpsAverage.toFixed(2);
}

/* the main draw function */
function frameDraw() {
    /* Block in case of long draw */
    if(drawing) { return; } else { drawing = true; }
    
    /* Record the start time for draw time measurements */
    var timeStart = Date.now();

    /* execute drawing code. sample code inserted */
    draw();

    timeCurrent = Date.now();
    var fpsThisFrame = 1000 / (timeCurrent - timeLast);
    if (timeCurrent > timeLast) {
        fpsAverage += (fpsThisFrame - fpsAverage) / fpsFilter;
        timeLast = timeCurrent;
    }

    drawing = false;
    
    /* To test how long drawing takes for the demo */
    document.getElementById('msOutput').innerHTML = Date.now() - timeStart;
}

/* set the fps update interval */
setInterval(fpsUpdate, 1000);

/* call the first update so we don't start on 0.00 */
fpsUpdate();

/* call drawFrame() for testing, this will probably
   go inside your main() loop */
setInterval(frameDraw, 1000 / fpsDesired);

/* The first run, before the interval triggers */
frameDraw();

/* Demo draw code further down */










/*
Canvas demo code - taken from https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Canvas_tutorial/Basic_animations

-------------
Ignore this, it's more about the FPS code than the animation ;P
-------------
*/

sun.src = 'http://www.astrolosophy.net/sun_transparent.png';
moon.src = 'http://25.media.tumblr.com/46aa94546a12d2844128d252f8677171/tumblr_mg5kc2oWg81qhy9dqo1_500.png';
earth.src = 'http://upload.wikimedia.org/wikipedia/commons/thumb/2/22/Earth_Western_Hemisphere_transparent_background.png/480px-Earth_Western_Hemisphere_transparent_background.png';

function draw() {
    var ctx = document.getElementById('canvasArea').getContext('2d');
    var ctxMax = Math.min(document.getElementById('canvasArea').height, document.getElementById('canvasArea').width);
    
    // Set line, fill and composition styles
    ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.strokeStyle = 'rgba(0, 153, 255, 0.4)';
    ctx.globalCompositeOperation = 'destination-over';

    // Clear it and draw stars
    ctx.clearRect(0, 0, ctxMax, ctxMax);
    ctx.save();
    ctx.translate(ctxMax / 2, ctxMax / 2);

    // Earth
    var time = new Date();
    ctx.rotate(((2 * Math.PI) / 60) * time.getSeconds() + ((2 * Math.PI) / 60000) * time.getMilliseconds());
    ctx.translate(ctxMax / 3, 0);
    ctx.drawImage(earth, 0 - ctxMax / 12, 0 - ctxMax / 12, ctxMax / 6, ctxMax / 6);

    // Moon
    ctx.save();
    ctx.rotate(((2 * Math.PI) / 6) * time.getSeconds() + ((2 * Math.PI) / 6000) * time.getMilliseconds());
    ctx.translate(0, ctxMax / 10);
    ctx.drawImage(moon, 0 - ctxMax / 100, 0 - ctxMax / 100, ctxMax / 50, ctxMax / 50);
    ctx.restore();
    
    // Moon orbit
    ctx.beginPath();
    ctx.arc(0, 0, ctxMax / 10, 0, Math.PI * 2, false);
    ctx.closePath();
    ctx.stroke();
    
    // Earth shadow
    ctx.fillRect(0, 0 - ctxMax / 12, ctxMax / 3, ctxMax / 6); 
    ctx.restore();

    // Earth orbit
    ctx.beginPath();
    ctx.arc(ctxMax / 2, ctxMax / 2, ctxMax / 3, 0, Math.PI * 2, false);
    ctx.closePath();
    ctx.stroke();

    ctx.drawImage(sun, ctxMax / 3, ctxMax / 3, ctxMax / 3, ctxMax / 3);
}

/* original fiddle I was testing in http://jsfiddle.net/KymaG/16/ */
/* based on http://jsfiddle.net/ksgSg/ from http://stackoverflow.com/questions/5078913/html5-canvas-performance-calculating-loops-frames-per-second */