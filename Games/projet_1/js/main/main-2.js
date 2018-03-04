/**
 * Variables du jeu
 * 
 */

var game; 

var nWidth = 640;
var nHeight = 480;


// les variables du jeu
var obstaclesCanvas;// affiche les obstacles
var lightCanvas;// affiche la lumière
var numBoxes = 4;// nombre de forme sur le jeu
var aPolygons = [];// tableau qui contient toutes les formes



document.addEventListener("DOMContentLoaded", Main, false); // appel au chargement de la page


/**
 * Fonction principale
 * Appelée au chargement de la page
 * 
 */
function Main()
{
    console.log("Main");

    // creation de la zone de jeu - API canvas
    game = new Phaser.Game(nWidth, nHeight, Phaser.AUTO, "", {preload:onPreload, create:onCreate, update:onUpdate});

    // les variables globales du jeu
    game.global = {
        thumbRows : 5// nombre d'icone par ligne  game.global.thumbRows
    }

}


/**
 * Préchargement des éléments du jeu
 * 
 * @return {[type]} [description]
 */
function onPreload()
{ 
    // charge les animations / graphismes du jeu

    game.stage.backgroundColor = '#cccccc';// la couleur de fond du jeu
}


/**
 * Affiche le jeu en plein écran
 * 
 * @return {[type]} [description]
 */
function goFullScreen()
{
    game.scale.pageAlignHorizontally = true;
    game.scale.pageAlignVertically = true;
    game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
    game.scale.setScreenSize(true);
}


/**
 * Création de la scène du jeu,
 * mise en place des graphismes...
 * 
 * @return {[type]} [description]
 */
function onCreate() 
{
    // écouteur sur le déplacement de la souris  - appel move
    moveIndex = game.input.addMoveCallback(move, this);

    obstaclesCanvas = game.add.graphics(0,0);// les obstables
    obstaclesCanvas.lineStyle(4, 0xffffff, 1);// style de la ligne pour les obstacles
    lightCanvas = game.add.graphics(0,0);// affichage de la lumière
    
    // positionne les formes aléatoires
    for(var i = 0; i < numBoxes; i++)
        randomBox();    

    // définie le périmètre des formes
    aPolygons.push([
                        [-1,-1],
                        [game.width+1,-1],
                        [game.width+1,game.height+1],
                        [-1,game.height+1]
                    ]);      
}


/**
 * Appelée en continu pendant le jeu
 * 
 * @return {[type]} [description]
 */
function onUpdate() 
{
}


/**
 * Création des formes aléatoires
 * 
 * @return {[type]} [description]
 */
function randomBox()
{
    do{
        // dessine la forme avec des valeurs aléatoires : largeur, hauteur, position
        var width = game.rnd.between(50,150);
        var height = game.rnd.between(50,150);
        var startX = game.rnd.between(10,game.width-160);
        var startY = game.rnd.between(10,game.height-160);
    }
    while( boxesIntersect(startX,startY,width,height) )
    
    obstaclesCanvas.beginFill(0x00C5DF);// couleur de fond de la forme
    obstaclesCanvas.drawRect(startX, startY, width, height);// dessine les formes
    obstaclesCanvas.endFill();

    // sauvegarde la forme dans un tableau
    aPolygons.push([ [startX,startY], 
                    [startX+width,startY], 
                    [startX+width,startY+height], 
                    [startX,startY+height] 
                ] );     
}


/**
 * Vérifie si les formes ne se chevauchent pas
 * Sinon cela génère une erreur (si des formes sont l'unes sur l'autre)
 * 
 * @param  {[type]} x [description]
 * @param  {[type]} y [description]
 * @param  {[type]} w [description]
 * @param  {[type]} h [description]
 * @return {[type]}   [description]
 */
function boxesIntersect(x,y,w,h)
{  
    for(var i = 0; i < aPolygons.length; i++)
    {
        if(x<aPolygons[i][1][0] && x+w>aPolygons[i][0][0] && y<aPolygons[i][3][1] && y+h>aPolygons[i][0][1])
            return true;
    }

    return false;
}
      

/**
 * Appel lors du déplacement de la souris
 * Mets à jour l'affichage de la lumière
 * La souris correspond au soleil, la source de la lumière
 * 
 * @return {[type]} [description]
 */
function move()
{ 
    // lorsque la souris change de position, détermine la visibilité des formes   
    var visibility = createLightPolygon(game.input.worldX, game.input.worldY);
  
    // mets à jour l'affichage de la lumière
    lightCanvas.clear();
    lightCanvas.lineStyle(2, 0xff8800, 1);
    lightCanvas.beginFill(0xffff00); 
    lightCanvas.moveTo(visibility[0][0],visibility[0][1]);  
    
    for(var i=1;i<=visibility.length;i++)
    {
        lightCanvas.lineTo(visibility[i%visibility.length][0],visibility[i%visibility.length][1]);      
    }

    lightCanvas.endFill();
}


/**
 * Utilisation de la librairie de gestion des polygones
 * Mets à jour l'affichage en fonction d'une source de lumière
 * 
 * @param  {[type]} x [description]
 * @param  {[type]} y [description]
 * @return {[type]}   [description]
 */
function createLightPolygon(x,y)
{
    var segments = VisibilityPolygon.convertToSegments(aPolygons);
    segments = VisibilityPolygon.breakIntersections(segments);
    var position = [x, y];
    
    if (VisibilityPolygon.inPolygon(position, aPolygons[aPolygons.length-1]))
        return VisibilityPolygon.compute(position, segments);
      
    return 0;  
}



