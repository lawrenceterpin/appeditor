var width  = window.innerWidth;
var height = window.innerHeight;
var set_left_player = 2.4;
var taille_score    = 15;

window.addEventListener("deviceorientation", this.handleOrientation, true);

if(width > 768) {
	
    var width  = 800;
    var height = 500;
    var set_left_player = 0.5;
    var taille_score    = 25;
}

var game = new Phaser.Game(width, height, Phaser.CANVAS, 'game-test', { preload: preload, create: create, update: update, render: render });

function preload() {

    game.load.image('space', 'assets/shoot-em-up/kosmos.jpg');
    game.load.image('fire', 'assets/shoot-em-up/fire.png');
    game.load.image('station', 'assets/shoot-em-up/spacestationfinal.png');
    game.load.image('btnPause', 'assets/shoot-em-up/btn-pause.png');
    game.load.image('bullet', 'assets/shoot-em-up/bullet.png');
    game.load.image('bullet2', 'assets/shoot-em-up/lazer2.png');
    game.load.image('enemyBullet', 'assets/shoot-em-up/bullet285.png');
    game.load.image('enemyBullet2', 'assets/shoot-em-up/laser2.png');
    game.load.image('bossBullet', 'assets/shoot-em-up/laser-boss.png');
    game.load.image('life', 'assets/shoot-em-up/life.png');
    game.load.image('lifeBoss', 'assets/shoot-em-up/life-boss.png');
    game.load.image('boss', 'assets/shoot-em-up/tribase-u2-d0.png');
    game.load.spritesheet('ship', 'assets/shoot-em-up/ship.png', 125, 90);
    game.load.spritesheet('invader', 'assets/shoot-em-up/enemy.png', 40, 40);
    game.load.spritesheet('invader2', 'assets/shoot-em-up/eSpritesheet_40x30_hue3.png', 40, 30);
    game.load.spritesheet('kaboom', 'assets/shoot-em-up/explode1.png', 155, 150);

    game.load.bitmapFont('carrier_command', 'assets/fonts/bitmapFonts/carrier_command.png', 'assets/fonts/bitmapFonts/carrier_command.xml');
}

var player;
var aliens;
var bullets;
var bullets2;
var bulletTime    = 0;
var cursors;
var fireButton;
var explosions;
var starfield;
var score = 0;
var scoreString   = '';
var scoreText;
var lives;
var enemyBullet;
var enemyBullet2;
var bossBullet;
var firingTimer   = 0;
var stateText;
var livingEnemies = [];
var livingBoss    = [];

function create() {

    game.physics.startSystem(Phaser.Physics.ARCADE);

    game.world.setBounds(0, 0, 800*6, height);

    starfield = game.add.tileSprite(0, 0, 658*8, height, 'space');

    station   = game.add.group();
    station.create(1500, 100, 'station');

    // stars = game.add.group();
    // planet    = game.add.group();
	
    /*for (var i = 0; i < 128; i++)
    {
        stars.create(game.world.randomX, game.world.randomY, 'star');
    }*/

    // Le héro !
    player = game.add.sprite(100, 300, 'ship');
    player.anchor.setTo(set_left_player, 0.5);
    game.physics.enable(player, Phaser.Physics.ARCADE);

    player.animations.add('left', [0, 1, 2, 3], 10, true);
    player.animations.add('right', [0, 1, 2, 3], 10, true);
    player.body.collideWorldBounds = true;

    /* player.inputEnabled = true;
    player.input.enableDrag();
    player.events.onDragStart.add(onDragStart, this); */

    game.camera.follow(player, Phaser.Camera.FOLLOW_LOCKON, 0.1);

    // Les tirs du héro
    bullets = game.add.group();
    bullets.enableBody      = true;
    bullets.physicsBodyType = Phaser.Physics.ARCADE;
    bullets.createMultiple(30, 'bullet');
    bullets.setAll('anchor.x', 0.5);
    bullets.setAll('anchor.y', 1);
    bullets.setAll('outOfBoundsKill', true);
    bullets.setAll('checkWorldBounds', true);

    bullets2 = game.add.group();
    bullets2.enableBody      = true;
    bullets2.physicsBodyType = Phaser.Physics.ARCADE;
    bullets2.createMultiple(30, 'bullet2');
    bullets2.setAll('anchor.x', 0.5);
    bullets2.setAll('anchor.y', 1);
    bullets2.setAll('outOfBoundsKill', true);
    bullets2.setAll('checkWorldBounds', true);

    // Les tirs enemis
    enemyBullets = game.add.group();
    enemyBullets.enableBody      = true;
    enemyBullets.physicsBodyType = Phaser.Physics.ARCADE;
    enemyBullets.createMultiple(30, 'enemyBullet');
    enemyBullets.setAll('anchor.x', 0.5);
    enemyBullets.setAll('anchor.y', 1);
    enemyBullets.setAll('outOfBoundsKill', true);
    enemyBullets.setAll('checkWorldBounds', true);

    enemyBullets2 = game.add.group();
    enemyBullets2.enableBody      = true;
    enemyBullets2.physicsBodyType = Phaser.Physics.ARCADE;
    enemyBullets2.createMultiple(30, 'enemyBullet2');
    enemyBullets2.setAll('anchor.x', 0.5);
    enemyBullets2.setAll('anchor.y', 1);
    enemyBullets2.setAll('outOfBoundsKill', true);
    enemyBullets2.setAll('checkWorldBounds', true);

    // Les tirs du boss
    bossBullets = game.add.group();
    bossBullets.enableBody      = true;
    bossBullets.physicsBodyType = Phaser.Physics.ARCADE;
    bossBullets.createMultiple(30, 'bossBullet');
    bossBullets.setAll('anchor.x', 0.5);
    bossBullets.setAll('anchor.y', 1);
    bossBullets.setAll('outOfBoundsKill', true);
    bossBullets.setAll('checkWorldBounds', true);

    // Les enemis
    aliens = game.add.group();
    aliens.enableBody       = true;
    aliens.physicsBodyType  = Phaser.Physics.ARCADE;
    
    aliens2 = game.add.group();
    aliens2.enableBody      = true;
    aliens2.physicsBodyType = Phaser.Physics.ARCADE;
	
	// Le boss
    bosss = game.add.group();
    bosss.enableBody        = true;
    bosss.physicsBodyType   = Phaser.Physics.ARCADE;

    createAliens();

    // Texte du score
    scoreString   = 'Score : ';
    scoreText     = game.add.bitmapText(30, 30, 'carrier_command', scoreString + score,taille_score);
    scoreText.fixedToCamera = true;
    // Texte des PV du héro
    lives         = game.add.group();
    livesText     = game.add.bitmapText(width - 335, 50, 'carrier_command','joueur',15);
    livesText.fixedToCamera = true;
	// Texte des PV du boss
    livesBoss     = game.add.group();
    livesBossText = game.add.bitmapText(width - 300, 120, 'carrier_command','Boss',15);
    livesBossText.fixedToCamera = true;

    // Texte du Game over
    stateText = game.add.bitmapText(0, 0, 'carrier_command','Vous êtes mort \n Cliquez pour rejouer',34);
    stateText.fixedToCamera = true;
    stateText.cameraOffset.setTo(0, 200);
    stateText.visible = false;

    for (var i = 0; i < 12; i++)
    {
        var ship = lives.create(width - 210 + (20 * i), 30, 'life');
        ship.fixedToCamera = true;
    }

    for (var i = 0; i < 10; i++)
    {
        var ship2 = livesBoss.create(width - 210 + (20 * i), 100, 'lifeBoss');
        /*ship.anchor.setTo(0.5, 0.5);
        ship.angle = 90;
        ship.alpha = 0.4;*/
        ship2.fixedToCamera = true;
    }

    //  Association de l'explosion
    explosions  = game.add.group();
    explosions.createMultiple(50, 'kaboom');
    explosions.forEach(setupInvader, this);

    //  And some controls to play the game with
    cursors     = game.input.keyboard.createCursorKeys();
    fireButton  = game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
    
    pauseButton = game.add.sprite(100, height - 60, 'btnPause');
    pauseButton.inputEnabled = true;
    pauseButton.events.onInputUp.add(function () {
        game.paused = true;
    },this);
    game.input.onDown.add(function () {
        if(game.paused)
           game.paused = false;
    },this);

    pauseButton.fixedToCamera = true;

    prevCamX = game.camera.x;

    game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT;

    // Keep original size
    // game.scale.fullScreenScaleMode = Phaser.ScaleManager.NO_SCALE;

    // Maintain aspect ratio
    // game.scale.fullScreenScaleMode = Phaser.ScaleManager.SHOW_ALL;

    if(width < 768) {

        button = game.add.button(30, height - 80, 'fire', actionFire, this, 2, 1, 0);

        /*button.onInputOver.add(over, this);
        button.onInputOut.add(out, this);
        button.onInputUp.add(up, this);*/
        
        button.fixedToCamera = true;

        game.input.onDown.add(gofull, this);
    }
}

/*function onDragStart(sprite, pointer) {
    player.x + 4;
    player.scale.x = 1;
    player.animations.play('right');
}*/

function actionFire () {
  
    fireBullet();
}

function createAliens () {

    nb_alien  = 30;
    nb_alien2 = 30;

    for(i = 0; i < nb_alien;i++) {

        var alien = aliens.create(400 + game.world.randomX, i * 7, 'invader');
        alien.anchor.setTo(0.5, 0.5);
        // alien.animations.add('fly', [ 0, 1, 2, 3 ], 20, true);
        // alien.play('fly');
        alien.body.moves = false;

        aliens.x  = i * Math.random() * 8;
        aliens.y  = 50;

        // Déplacement du groupe d'aliens
        var tween = game.add.tween(aliens).to( { y: i * Math.random() * 8 }, 2000, Phaser.Easing.Linear.None, true, 0, 1000, true);
    }; 

    for(i = 0; i < nb_alien2;i++) {

        var alien2 = aliens2.create(400 + game.world.randomX, i * 7, 'invader2');
        alien2.anchor.setTo(0.5, 0.5);
        alien2.animations.add('fly', [ 0, 1, 2, 3 ], 20, true);
        alien2.play('fly');
        alien2.body.moves = false;

        aliens2.x = i * Math.random() * 8;
        aliens2.y = 50;

        var tween = game.add.tween(aliens2).to( { y: i * Math.random() * 8 }, 2000, Phaser.Easing.Linear.None, true, 0, 1000, true);
    }; 

    var boss = bosss.create(4500, 300, 'boss');
    boss.anchor.setTo(0.5, 0.5);
    boss.body.moves = false;

    // When the tween loops it calls descend
    tween.onLoop.add(descend, this);
}

function setupInvader (invader) {

    invader.anchor.x = 0.5;
    invader.anchor.y = 0.5;
    invader.animations.add('kaboom');
}

function descend() {

    aliens.y += 10;
    aliens2.y += 10;
}

function update() {

    // Scroll the background
    // starfield.tilePosition.y += 2;

    if (player.alive)
    {
        // Reset the player, then check for movement keys
        player.body.velocity.setTo(0, 0);

        if (cursors.left.isDown)
        {
            player.x -= 5;
            player.scale.x = -1;
            player.animations.play('right');
        }
        else if (cursors.right.isDown)
        {
            player.x += 5;
            player.scale.x = 1;
            player.animations.play('left');
        }
        else {
            player.animations.stop();
        }

        if (cursors.up.isDown)
        {
            player.y -= 5;
        }
        else if (cursors.down.isDown)
        {
            player.y += 5;
        }

        // Touche de tir
        if (fireButton.isDown)
        {
            fireBullet();
        }

        if (game.time.now > firingTimer)
        {
            enemyFires();
            enemyFires2();

            if( player.x >= 3900) {
                bossFires();
            }
        }

        // game.physics.arcade.collide(player, aliens);

        // Les collisions
        game.physics.arcade.overlap(bullets, aliens, collisionHandler, null, this);
        game.physics.arcade.overlap(bullets, aliens2, collisionHandler, null, this);
        game.physics.arcade.overlap(bullets2, aliens, collisionHandler, null, this);
        game.physics.arcade.overlap(bullets2, aliens2, collisionHandler, null, this);
        game.physics.arcade.overlap(bullets, bosss, collisionHandler3, null, this);
        game.physics.arcade.overlap(bullets2, bosss, collisionHandler3, null, this);

        game.physics.arcade.overlap(enemyBullets, player, enemyHitsPlayer, null, this);
        game.physics.arcade.overlap(enemyBullets2, player, enemyHitsPlayer, null, this);
        game.physics.arcade.overlap(bossBullets, player, enemyHitsPlayer, null, this);

        // console.log( player.x)
    }

    prevCamX = game.camera.x;
}

function collisionHandler (bullet, alien) {

    // Quand une balle touche un alien
    bullet.kill();
    alien.kill();

    // console.log(this);

    // Mise à jour du score
    score += 20;
    scoreText.text = scoreString + score;

    // On créé l'explosion :)
    var explosion = explosions.getFirstExists(false);
    explosion.reset(alien.body.x, alien.body.y);
    explosion.play('kaboom', 50, false, true);

    if (aliens.countLiving() == 0)
    {
        score += 1000;
        scoreText.text = scoreString + score;

        enemyBullets.callAll('kill',this);
        enemyBullets2.callAll('kill',this);
    }
}

/*function collisionHandler2 (bullet, alien2) {

    // Quand une balle touche un alien
    bullet.kill();
    alien2.kill();

    // Mise à jour du score
    score += 100;
    scoreText.text = scoreString + score;

    // On créé l'explosion :)
    var explosion = explosions.getFirstExists(false);
    explosion.reset(alien2.body.x, alien2.body.y);
    explosion.play('kaboom', 50, false, true);

    if (aliens2.countLiving() == 0)
    {
        score += 1000;
        scoreText.text = scoreString + score;

        enemyBullets.callAll('kill',this);
        enemyBullets2.callAll('kill',this);
    }
}*/

function collisionHandler3 (bullet, boss) {

    bullet.kill();

    liveBoss = livesBoss.getFirstAlive();

    // on retire une vie
    if (liveBoss) {

        liveBoss.kill();
    }

    // On créé l'explosion :)
    var explosion = explosions.getFirstExists(false);
    explosion.reset(boss.body.x, boss.body.y);
    explosion.play('kaboom', 30, false, true);

    // Quand le boss meurt
    if (livesBoss.countLiving() < 1)
    {
        boss.kill();

        bossBullets.callAll('kill',this);
        stateText.text = " Vous avez gagné, \n Cliquez pour rejouer";
        stateText.visible = true;

        // Le clic du restart
        game.input.onTap.addOnce(restart,this);
    }
}

function enemyHitsPlayer (player,bullet) {
    
    bullet.kill();

    live = lives.getFirstAlive();

    // on retire une vie
    if (live) {
        live.kill();
    }

    // On créé l'explosion :)
    var explosion = explosions.getFirstExists(false);
    explosion.reset(player.body.x, player.body.y);
    explosion.play('kaboom', 30, false, true);

    // Quand le héro n'a plus de vies
    if (lives.countLiving() < 1)
    {
        player.kill();
        enemyBullets.callAll('kill');
        enemyBullets2.callAll('kill');

        stateText.text=" GAME OVER \n Click to restart";
        stateText.visible = true;

        // Le clic du restart
        game.input.onTap.addOnce(restart,this);
    }
}

function enemyFires () {
    
    //  Grab the first bullet we can from the pool
    enemyBullet = enemyBullets.getFirstExists(false);
    livingEnemies.length=0;

    aliens.forEachAlive(function(alien){
        // put every living enemy in an array
        livingEnemies.push(alien);
    });

    if (enemyBullet && livingEnemies.length > 0)
    {
        var random=game.rnd.integerInRange(0,livingEnemies.length-1);

        // randomly select one of them
        var shooter=livingEnemies[random];
        // And fire the bullet from this enemy
        enemyBullet.reset(shooter.body.x, shooter.body.y);

        game.physics.arcade.moveToObject(enemyBullet,player,120);
        firingTimer = game.time.now + 500;
    }
}

function enemyFires2 () {
    
    // Grab the first bullet we can from the pool
    enemyBullet2 = enemyBullets2.getFirstExists(false);
    livingEnemies.length=0;

    aliens2.forEachAlive(function(alien2){
        // put every living enemy in an array
        livingEnemies.push(alien2);
        bullet = bullets2.getFirstExists(false);
    });

    if (enemyBullet2 && livingEnemies.length > 0)
    {
        var random=game.rnd.integerInRange(0,livingEnemies.length-1);

        // randomly select one of them
        var shooter=livingEnemies[random];
        // And fire the bullet from this enemy
        enemyBullet2.reset(shooter.body.x, shooter.body.y);

        game.physics.arcade.moveToObject(enemyBullet2,player,120);
        firingTimer = game.time.now + 500;
    }
}

function bossFires () {

    livingBoss.length=0;

    bosss.forEachAlive(function(boss) {
        //  Grab the first bullet we can from the pool
        bossBullet = bossBullets.getFirstExists(false);
        // put every living enemy in an array
        livingBoss.push(boss);
    });

    if (bossBullet && livingBoss.length > 0)
    {

        var random_boss=game.rnd.integerInRange(0,livingBoss.length-1);

        // randomly select one of them
        var shooter=livingBoss[random_boss];
        // And fire the bullet from this enemy
        bossBullet.reset(shooter.body.x, shooter.body.y);

        game.physics.arcade.moveToObject(bossBullet,player,120);

        firingTimer = game.time.now + 5000;
    }
}

function fireBullet () {
	
	// Pour éviter d'être autorisés à tirer trop vite, on fixe une limite de temps
    if (game.time.now > bulletTime)
    {
        // console.log(score);
        // Grab the first bullet we can from the pool
        bullet = bullets.getFirstExists(false);

        if( score > 2000 ) {

            bullet = bullets2.getFirstExists(false);
        }

        if (bullet) {

            var set_reset_fire = player.x - 170;

            if( width > 768) {
                var set_reset_fire = player.x + 80;
            }
            
            // Feu !
            bullet.reset(set_reset_fire, player.y + 8);
            bullet.body.velocity.x = 400;

            // On change de balles en fonction du score
            if( score > 2000 ) {
                
                bullet.reset(set_reset_fire, player.y - 30);
                bullet.body.velocity.x = 400;
            }

            bulletTime = game.time.now + 200;
        }
    }
}

function resetBullet (bullet) {
    // Quand la balle sort de l'écran
    bullet.kill();
}

function handleOrientation(e) {
    var x = e.beta - 20;
    var y = e.gamma - 20;
    player.body.velocity.x += x;
    player.body.velocity.y += y;
}

function gofull() {

    game.scale.startFullScreen(false);
}

function restart () {
    
    // reset du nombre de vies
    lives.callAll('revive');
    // Resurrection des aliens :)
    aliens.removeAll();
    aliens2.removeAll();
    createAliens();

    // Resurrection du héro
    player.revive();
    player.x = 0;
    // On cache le texte
    stateText.visible = false;
}

function render() {

    // for (var i = 0; i < aliens.length; i++)
    // {
    //     game.debug.body(aliens.children[i]);
    // }

    // game.debug.text(game.time.fps || '--', 30, 30, "#ececec");
}