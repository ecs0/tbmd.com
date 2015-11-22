
window.addEventListener("load", function() {
    
    var images = [];
    var canvas = document.getElementById("slide_show");
    var context = canvas.getContext("2d");
    var running = false;
    var totalTime = 0;
    var lastFrameTime = 0;
    var numImages;
    
    var img = new Image();
    img.onload = imageLoaded;
    img.src = "../images/film_overlay.png";

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            loadImages(JSON.parse(xmlHttp.responseText));
        }
    };
    xmlHttp.open("GET", "php/slide_show.php", true);
    xmlHttp.send();


    function imageLoaded() {
        numImages = Math.ceil(canvas.width / img.width) + 1;
        draw(0);
        running = true;
        run();
    }
    
    function draw(delta) {
        totalTime += delta;
        
        var vx = 50;

        
        var xpos = -(totalTime * vx % img.width);

        var frameWidth = img.width / 3;
        var frameHeight = img.height * .9;
        
        
        
        context.save();
        context.fillStyle = "white";
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.translate(xpos, 0);
        for (var i = 0; i < numImages; i++) {

            // draw the images in each film frame
            context.drawImage(getImage(10), (i * img.width), 0, frameWidth, frameHeight);
            context.drawImage(getImage(2), frameWidth + (i * img.width), 0, frameWidth, frameHeight);
            context.drawImage(getImage(3), (frameWidth * 2) + (i * img.width), 0, frameWidth, frameHeight);

            context.drawImage(img, i * img.width - 1, 0);
        }
        context.restore();
    }

    function randomIndex() {
        return Math.floor((Math.random() * images.length) + 1);
    }

    function getImage(frame) {
        return images[frame % images.length];
    }
    
    function loadImages(jsonResult) {
        for (var i = 0; i < jsonResult.length; i++) {
            images[i] = new Image();
            images[i].src = jsonResult[i];
        }
    }
    
    function run() {
        if (!running) {
            return;
        }
        
        requestAnimationFrame(run);
        
        var now = Date.now();
        var deltaSeconds = (now - lastFrameTime) / 1000;
        lastFrameTime = now;
        draw(deltaSeconds);
    }
    
}, false);
