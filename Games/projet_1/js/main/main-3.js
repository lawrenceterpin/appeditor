// MAIN JS
var game = new Phaser.Game('100%', 600, Phaser.CANVAS, '', { preload: preload, create: create, update: update, render: render });

// Create the state that will contain the whole game
var stateText;
lives = 100;
//Switch gauche/droite pour les jeux d'animation
var idledetect=0;
var jumpsensor;
var ticGlobal = 0;
function preload () {

	// Here we preload the assets
	game.load.image('bg', 'assets/BG.png');

	game.load.spritesheet('player', 'img/transferts/Playersheet5.png', 48, 41);

	game.load.image('ground', 'assets/2.png');
	game.load.image('wall', 'assets/wall.png');
	// game.load.image('wall2', 'assets/wall.png');
	game.load.image('coin', 'assets/coin.png');
	game.load.image('enemy', 'img/transferts/dinodanger.png');
}

function create () { 
	
	    //  We're going to be using physics, so enable the Arcade Physics system
    game.physics.startSystem(Phaser.Physics.ARCADE);
 
    //  A simple background for our game
    game.add.sprite(0, 0, 'bg');
 
    //  The platforms group contains the ground and the 2 ledges we can jump on
    platforms = game.add.group();
    coins     = game.add.group();
    enemies   = game.add.group();
 
    platforms.enableBody = true;
    coins.enableBody     = true;
    enemies.enableBody   = true;
 	
  var switchGlobal = 1;
  
  // var event = document.createEvent("UIEvents");
  // event.initUIEvent("keypress", true, true, window, 1);
  // event.keyCode = 115;
  
  // console.log(event.keyCode);
  
  function while_tic(pause, switchGlobal, ticGlobal) {
    
     while (switchGlobal == 1)
    {
      switchGlobal --;
      setInterval(function()
      { 
        ticGlobal ++; 
        switchGlobal ++;
        var timer = parseInt(ticGlobal)/10;
        // console.log('ticGlobal -> '+ticGlobal);
        // console.log('switchGlobal -> '+switchGlobal);
      }, 100);
      
     return timer;
    }
  }
  
  	// while_tic(switchGlobal, ticGlobal);
  
    //  Here we'll create 12 of them evenly spaced apart
    for (var i = 0; i < 12; i++)
    {
        //  Create a star inside of the 'stars' group
        var coin = coins.create(i * 70, 0, 'coin');
 
        //  Let gravity do its thing
        coin.body.gravity.y = 2000;
 
        //  This just gives each star a slightly random bounce value
        coin.body.bounce.y = 0.5 + Math.random() * 0.2;
    }
    
    //  Here we'll create 5 of them evenly spaced apart
    for (var i = 0; i < 5; i++)
    {
        //  Create a star inside of the 'stars' group
        var enemy = enemies.create(i * Math.random() * 600, 0, 'enemy');
 
        //  Let gravity do its thing
        enemy.body.gravity.y = 2000;
        
        enemy.body.velocity.x = 0;

    	enemy.body.collideWorldBounds = true;
 
        //  This just gives each star a slightly random bounce value
        enemy.body.bounce.y = 0.5 + Math.random() * 0.2;
        
        //  We need to enable physics on the player
    	game.physics.arcade.enable(enemy);
    }
    
    var level = [
	    '										',
	    '   					xxxxxxxxxxxxxxx				',
	    '					   x					',
	    '					  x					          xxx',
	    '					 x					      xx',
	    '					x					                       ',
	    'xxxxxx	xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx		',
	];
	
	// Create the level by going through the array
	for (var i = 0; i < level.length; i++) {
	    for (var j = 0; j < level[i].length; j++) {
	
	        // Create a wall and add it to the 'walls' group
	        if (level[i][j] == 'x') {
	            var wall = game.add.sprite(30+28*j, 400+28*i, 'ground');
	            platforms.add(wall);
	            wall.body.immovable = true; 
	        }
	    }
	}
 
    // Ici on cr? le sol
    var ground = platforms.create(0, game.world.height - 64, 'ground');
 
    // Scale it to fit the width of the game (the original sprite is 400x32 in size)
    // ground.scale.setTo(2, 2);
 
    //  This stops it from falling away when you jump on it
    ground.body.immovable = true;
    
     // The player and its settings
    player = game.add.sprite(48, 100, 'player');
 
    //  We need to enable physics on the player
    game.physics.arcade.enable(player);
 
    //  Player physics properties. Give the little guy a slight bounce.
    player.body.bounce.y = 0;
    player.body.gravity.y = 733;
    player.body.collideWorldBounds = true;
 
    //  Our two animations, walking left and right.
    player.animations.add('right', [10, 11, 12, 13], 8, true);
    player.animations.add('left', [0, 2 ,1 ,3], 8, true);
  	player.animations.add('jumpL', [4, 5, 9, 8, 7, 6, 5, 4], 12, true);
  	player.animations.add('jumpR', [19, 18, 14, 15, 16, 17, 18, 19], 12, true);
  
	game.camera.follow(player);

    cursors = game.input.keyboard.createCursorKeys();

	//  Text
    stateText = game.add.text(game.world.centerX, game.world.centerY, '- click to start -', { font: "40px Arial", fill: "#ffffff", align: "center" });
    // stateText.anchor.setTo(0.5, 0.5);
    stateText.visible = false;
    stateText.fixedToCamera = true;
    
    pvText = game.add.text(game.world.centerX, 40, '100', { font: "40px Arial", fill: "#ffffff", align: "center" });
    pvText.setShadow(3, 3, 'rgba(0,0,0,0.5)', 2);
    pvText.fixedToCamera = true;
  
    stateNbCoins = game.add.text(game.world.centerX+100,40,' ', { font: "40px Arial", fill: "#ffffff", align: "center" });
    stateNbCoins.setShadow(3, 3, 'rgba(0,0,0,0.5)', 2);
    stateNbCoins.visible = true;

    stateNbCoins.text = "Coins : 0 / "+coins.countLiving()+"";
    stateNbCoins.fixedToCamera = true;
  
    clock = game.add.text(game.world.centerX,80,' ', { font: "40px Arial", fill: "#ffffff", align: "center" });
    clock.setShadow(3, 3, 'rgba(0,0,0,0.5)', 2);
    // stateNbCoins.text = while_tic(switchGlobal, ticGlobal);
    clock.visible = true;

    game.world.setBounds(0, 0, 1920, 600);

    // Stretch to fill
    // game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT;

    // Keep original size
    // game.scale.fullScreenScaleMode = Phaser.ScaleManager.NO_SCALE;

    // Maintain aspect ratio
    // game.scale.fullScreenScaleMode = Phaser.ScaleManager.SHOW_ALL;

    // game.input.onDown.add(this.gofull, this);

    game.camera.deadzone = new Phaser.Rectangle(100, 100, 400, 400);
    
    lives_bar = new Phaser.Rectangle(100, 100, 400, 400);
    
    var count_lives = lives_bar;
    game.context.fillStyle = 'rgba(255,0,0,0.6)';
    game.context.fillRect(count_lives.x, count_lives.y, count_lives.width, count_lives.height);
}

function update () {

	// Make the player and the walls collide
	game.physics.arcade.collide(player, platforms);
	game.physics.arcade.collide(coins, platforms);
	game.physics.arcade.collide(enemies, platforms);
	game.physics.arcade.collide(enemies, enemies);

	// game.physics.arcade.collide(player, wall2);
	
	// Call the 'takeCoin' function when the player takes a coin
	game.physics.arcade.overlap(player, coins, takeCoin, null, this);
	
	// Call the 'restart' function when the player touches the enemy
	game.physics.arcade.overlap(player, enemies, touchEnemy, null, this);

	inputs();

	if( coins.length == 0 ) {

    	stateText.text = " Tu as réussi, \n Clique pour\n rejouer";
    	stateText.visible = true;

    	game.input.onTap.addOnce(restart,this);
    }
}
	
function inputs (idledetect) {
	Console.log(player.frame);
  
	//  Reset the players velocity (movement)
    player.body.velocity.x = 0;
 
    if (cursors.left.isDown && player.body.touching.down)
    {
        //  Move to the left
        player.body.velocity.x = -200;
 		idledetect=0;
        if (!cursors.up.isDown)
        {
        	player.animations.play('left');
        }
    }
    else if (cursors.right.isDown && player.body.touching.down)
    {
        //  Move to the right
        player.body.velocity.x = 200;
 		idledetect=1;
      
      	if (!cursors.up.isDown)
        {
        	player.animations.play('right');
        }
    }
    else
    {
        //  Stand still
        player.animations.stop();
 		
      	if (idledetect == 0 && player.body.touching.down)
        {
        	player.frame = 4;
        }
      
      	else if (idledetect == 1 && player.body.touching.down)
        {
          	player.frame = 19;
		}
		else if (hasJumped && !player.body.touching.down)
        {
          if (idledetect == 0)
          {
          	player.animations.stop();
          	player.frame = 8;
          }
          else if (idledetect == 1)
       	 {
          	player.animations.stop();
          	player.frame = 15;
         }	
        }
      
    }
    
    //  Allow the player to jump if they are touching the ground.
    if (cursors.up.isDown )
    {
		for (var i = 0;i < 10;i++) 
      	{
         player.body.gravity.y - i * 5;
    	}
        jumpPlayer();
	
		

    }
  	
	
}


function jumpPlayer (idledetect) {
	if (player.body.touching.down) {
		// game.sound.mute = false;
		this.hasJumped = true;
		player.body.velocity.y = -350;
      	// Jeu d'animation en fonction de la direction
		if (cursors.left.isDown)
        {
      		player.animations.play('jumpL');	
		}	
      	else if (cursors.right.isDown)
        {
      		player.animations.play('jumpR');	
		}	
      	else if ( idledetect == 0)
        {
        	player.animations.play('jumpL');	
        }
        else if (idledetect == 1)
        {
        	player.animations.play('jumpR');
        }
    }  //Freeze l'animation sur une position "en l'air" après un saut
	      
}

// Fonction pour prendre une pi?e
function takeCoin (player, coin) {
    coin.kill();

    var count_coins = coins.length - coins.countLiving();

    stateNbCoins.text = "Coins : "+count_coins+" / "+coins.length+"";
    	
    // console.log(coins.countLiving());
}

// Fonction contact entre le player et l'enemi
function touchEnemy () {
	
    var new_pv = lives--;
    
    pvText.text = ""+new_pv+"";
    
    if( new_pv == 0 ) {
    	
    	restart();
    }
    
    console.log(new_pv);
}

// Function pour red?arrer le jeu
function restart () {

    stateText.visible = false;

    location.reload();
}

function gofull() {

    if (game.scale.isFullScreen)
    {
        game.scale.stopFullScreen();
    }
    else
    {
        game.scale.startFullScreen(false);
    }

}

function render() {

    var zone = game.camera.deadzone;

    // game.context.fillStyle = 'rgba(255,0,0,0.6)';
    // game.context.fillRect(zone.x, zone.y, zone.width, zone.height);

    game.debug.cameraInfo(game.camera, 32, 32);
    game.debug.spriteCoords(player, 32, 500);
}