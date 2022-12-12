<?php
/*-----------------------------------------------------------------------------------*/
/* File Security Check */
/*-----------------------------------------------------------------------------------*/
if (!defined('ABSPATH'))
    exit;


/*-----------------------------------------------------------------------------------*/
/* Framework Variables */
/*-----------------------------------------------------------------------------------*/

global $responsi_options, 
    $responsi_layout_boxed, 
    $responsi_layout_width, 
    $responsi_header_is_inside, 
    $responsi_header_is_outside, 
    $responsi_footer_is_outside,
    $layout,  
    $layout_column, 
    $layout_column_top,  
    $layout_top, 
    $content_column, 
    $content_column_grid, 
    $main_box, 
    $sidebar_box, 
    $sidebar_alt_box,
    $wrapper_content, 
    $wrapper_content_top,
    $blog_animation,
    $gFonts,
    $responsi_animate,
    $responsi_icons;

/*-----------------------------------------------------------------------------------*/
/* Google Webfonts */
/*-----------------------------------------------------------------------------------*/

$google_fonts = array(
    array( 'name' => "ABeeZee", "variant"       => ':regular,italic' ),
    array( 'name' => "Abel", "variant"          => ':regular' ),
    array( 'name' => "Abril Fatface", "variant" => ':regular' ),
    array( 'name' => "Aclonica", "variant"      => ':regular' ),
    array( 'name' => "Acme", "variant"          => ':regular' ),
    array( 'name' => "Actor", "variant"         => ':regular' ),
    array( 'name' => "Adamina", "variant"       => ':regular' ),
    array( 'name' => "Advent Pro", "variant"    => ':100,200,300,regular,500,600,700' ),
    array( 'name' => "Aguafina Script", "variant" => ':regular' ),
    array( 'name' => "Akronim", "variant" => ':regular' ),
    array( 'name' => "Aladin", "variant" => ':regular' ),
    array( 'name' => "Aldrich", "variant" => ':regular' ),
    array( 'name' => "Alef", "variant" => ':regular,700' ),
    array( 'name' => "Alegreya", "variant" => ':regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Alegreya SC", "variant" => ':regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Alegreya Sans", "variant" => ':100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,800,800italic,900,900italic' ),
    array( 'name' => "Alegreya Sans SC", "variant" => ':100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,800,800italic,900,900italic' ),
    array( 'name' => "Alex Brush", "variant" => ':regular' ),
    array( 'name' => "Alfa Slab One", "variant" => ':regular' ),
    array( 'name' => "Alice", "variant" => ':regular' ),
    array( 'name' => "Alike", "variant" => ':regular' ),
    array( 'name' => "Alike Angular", "variant" => ':regular' ),
    array( 'name' => "Allan", "variant" => ':regular,700' ),
    array( 'name' => "Allerta", "variant" => ':regular' ),
    array( 'name' => "Allerta Stencil", "variant" => ':regular' ),
    array( 'name' => "Allura", "variant" => ':regular' ),
    array( 'name' => "Almendra", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Almendra Display", "variant" => ':regular' ),
    array( 'name' => "Almendra SC", "variant" => ':regular' ),
    array( 'name' => "Amarante", "variant" => ':regular' ),
    array( 'name' => "Amaranth", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Amatic SC", "variant" => ':regular,700' ),
    array( 'name' => "Amethysta", "variant" => ':regular' ),
    array( 'name' => "Amiri", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Amita", "variant" => ':regular,700' ),
    array( 'name' => "Anaheim", "variant" => ':regular' ),
    array( 'name' => "Andada", "variant" => ':regular' ),
    array( 'name' => "Andika", "variant" => ':regular' ),
    array( 'name' => "Angkor", "variant" => ':regular' ),
    array( 'name' => "Annie Use Your Telescope", "variant" => ':regular' ),
    array( 'name' => "Anonymous Pro", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Antic", "variant" => ':regular' ),
    array( 'name' => "Antic Didone", "variant" => ':regular' ),
    array( 'name' => "Antic Slab", "variant" => ':regular' ),
    array( 'name' => "Anton", "variant" => ':regular' ),
    array( 'name' => "Arapey", "variant" => ':regular,italic' ),
    array( 'name' => "Arbutus", "variant" => ':regular' ),
    array( 'name' => "Arbutus Slab", "variant" => ':regular' ),
    array( 'name' => "Architects Daughter", "variant" => ':regular' ),
    array( 'name' => "Archivo Black", "variant" => ':regular' ),
    array( 'name' => "Archivo Narrow", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Arimo", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Arizonia", "variant" => ':regular' ),
    array( 'name' => "Armata", "variant" => ':regular' ),
    array( 'name' => "Artifika", "variant" => ':regular' ),
    array( 'name' => "Arvo", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Arya", "variant" => ':regular,700' ),
    array( 'name' => "Asap", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Asset", "variant" => ':regular' ),
    array( 'name' => "Astloch", "variant" => ':regular,700' ),
    array( 'name' => "Asul", "variant" => ':regular,700' ),
    array( 'name' => "Atomic Age", "variant" => ':regular' ),
    array( 'name' => "Aubrey", "variant" => ':regular' ),
    array( 'name' => "Audiowide", "variant" => ':regular' ),
    array( 'name' => "Autour One", "variant" => ':regular' ),
    array( 'name' => "Average", "variant" => ':regular' ),
    array( 'name' => "Average Sans", "variant" => ':regular' ),
    array( 'name' => "Averia Gruesa Libre", "variant" => ':regular' ),
    array( 'name' => "Averia Libre", "variant" => ':300,300italic,regular,italic,700,700italic' ),
    array( 'name' => "Averia Sans Libre", "variant" => ':300,300italic,regular,italic,700,700italic' ),
    array( 'name' => "Averia Serif Libre", "variant" => ':300,300italic,regular,italic,700,700italic' ),
    array( 'name' => "Bad Script", "variant" => ':regular' ),
    array( 'name' => "Balthazar", "variant" => ':regular' ),
    array( 'name' => "Bangers", "variant" => ':regular' ),
    array( 'name' => "Basic", "variant" => ':regular' ),
    array( 'name' => "Battambang", "variant" => ':regular,700' ),
    array( 'name' => "Baumans", "variant" => ':regular' ),
    array( 'name' => "Bayon", "variant" => ':regular' ),
    array( 'name' => "Belgrano", "variant" => ':regular' ),
    array( 'name' => "Belleza", "variant" => ':regular' ),
    array( 'name' => "BenchNine", "variant" => ':300,regular,700' ),
    array( 'name' => "Bentham", "variant" => ':regular' ),
    array( 'name' => "Berkshire Swash", "variant" => ':regular' ),
    array( 'name' => "Bevan", "variant" => ':regular' ),
    array( 'name' => "Bigelow Rules", "variant" => ':regular' ),
    array( 'name' => "Bigshot One", "variant" => ':regular' ),
    array( 'name' => "Bilbo", "variant" => ':regular' ),
    array( 'name' => "Bilbo Swash Caps", "variant" => ':regular' ),
    array( 'name' => "Biryani", "variant" => ':200,300,regular,600,700,800,900' ),
    array( 'name' => "Bitter", "variant" => ':regular,italic,700' ),
    array( 'name' => "Black Ops One", "variant" => ':regular' ),
    array( 'name' => "Bokor", "variant" => ':regular' ),
    array( 'name' => "Bonbon", "variant" => ':regular' ),
    array( 'name' => "Boogaloo", "variant" => ':regular' ),
    array( 'name' => "Bowlby One", "variant" => ':regular' ),
    array( 'name' => "Bowlby One SC", "variant" => ':regular' ),
    array( 'name' => "Brawler", "variant" => ':regular' ),
    array( 'name' => "Bree Serif", "variant" => ':regular' ),
    array( 'name' => "Bubblegum Sans", "variant" => ':regular' ),
    array( 'name' => "Bubbler One", "variant" => ':regular' ),
    array( 'name' => "Buda", "variant" => ':300' ),
    array( 'name' => "Buenard", "variant" => ':regular,700' ),
    array( 'name' => "Butcherman", "variant" => ':regular' ),
    array( 'name' => "Butterfly Kids", "variant" => ':regular' ),
    array( 'name' => "Cabin", "variant" => ':regular,italic,500,500italic,600,600italic,700,700italic' ),
    array( 'name' => "Cabin Condensed", "variant" => ':regular,500,600,700' ),
    array( 'name' => "Cabin Sketch", "variant" => ':regular,700' ),
    array( 'name' => "Caesar Dressing", "variant" => ':regular' ),
    array( 'name' => "Cagliostro", "variant" => ':regular' ),
    array( 'name' => "Calligraffitti", "variant" => ':regular' ),
    array( 'name' => "Cambay", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Cambo", "variant" => ':regular' ),
    array( 'name' => "Candal", "variant" => ':regular' ),
    array( 'name' => "Cantarell", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Cantata One", "variant" => ':regular' ),
    array( 'name' => "Cantora One", "variant" => ':regular' ),
    array( 'name' => "Capriola", "variant" => ':regular' ),
    array( 'name' => "Cardo", "variant" => ':regular,italic,700' ),
    array( 'name' => "Carme", "variant" => ':regular' ),
    array( 'name' => "Carrois Gothic", "variant" => ':regular' ),
    array( 'name' => "Carrois Gothic SC", "variant" => ':regular' ),
    array( 'name' => "Carter One", "variant" => ':regular' ),
    array( 'name' => "Caudex", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Cedarville Cursive", "variant" => ':regular' ),
    array( 'name' => "Ceviche One", "variant" => ':regular' ),
    array( 'name' => "Changa One", "variant" => ':regular,italic' ),
    array( 'name' => "Chango", "variant" => ':regular' ),
    array( 'name' => "Chau Philomene One", "variant" => ':regular,italic' ),
    array( 'name' => "Chela One", "variant" => ':regular' ),
    array( 'name' => "Chelsea Market", "variant" => ':regular' ),
    array( 'name' => "Chenla", "variant" => ':regular' ),
    array( 'name' => "Cherry Cream Soda", "variant" => ':regular' ),
    array( 'name' => "Cherry Swash", "variant" => ':regular,700' ),
    array( 'name' => "Chewy", "variant" => ':regular' ),
    array( 'name' => "Chicle", "variant" => ':regular' ),
    array( 'name' => "Chivo", "variant" => ':regular,italic,900,900italic' ),
    array( 'name' => "Cinzel", "variant" => ':regular,700,900' ),
    array( 'name' => "Cinzel Decorative", "variant" => ':regular,700,900' ),
    array( 'name' => "Clicker Script", "variant" => ':regular' ),
    array( 'name' => "Coda", "variant" => ':regular,800' ),
    array( 'name' => "Coda Caption", "variant" => ':800' ),
    array( 'name' => "Codystar", "variant" => ':300,regular' ),
    array( 'name' => "Combo", "variant" => ':regular' ),
    array( 'name' => "Comfortaa", "variant" => ':300,regular,700' ),
    array( 'name' => "Coming Soon", "variant" => ':regular' ),
    array( 'name' => "Concert One", "variant" => ':regular' ),
    array( 'name' => "Condiment", "variant" => ':regular' ),
    array( 'name' => "Content", "variant" => ':regular,700' ),
    array( 'name' => "Contrail One", "variant" => ':regular' ),
    array( 'name' => "Convergence", "variant" => ':regular' ),
    array( 'name' => "Cookie", "variant" => ':regular' ),
    array( 'name' => "Copse", "variant" => ':regular' ),
    array( 'name' => "Corben", "variant" => ':regular,700' ),
    array( 'name' => "Courgette", "variant" => ':regular' ),
    array( 'name' => "Cousine", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Coustard", "variant" => ':regular,900' ),
    array( 'name' => "Covered By Your Grace", "variant" => ':regular' ),
    array( 'name' => "Crafty Girls", "variant" => ':regular' ),
    array( 'name' => "Creepster", "variant" => ':regular' ),
    array( 'name' => "Crete Round", "variant" => ':regular,italic' ),
    array( 'name' => "Crimson Text", "variant" => ':regular,italic,600,600italic,700,700italic' ),
    array( 'name' => "Croissant One", "variant" => ':regular' ),
    array( 'name' => "Crushed", "variant" => ':regular' ),
    array( 'name' => "Cuprum", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Cutive", "variant" => ':regular' ),
    array( 'name' => "Cutive Mono", "variant" => ':regular' ),
    array( 'name' => "Damion", "variant" => ':regular' ),
    array( 'name' => "Dancing Script", "variant" => ':regular,700' ),
    array( 'name' => "Dangrek", "variant" => ':regular' ),
    array( 'name' => "Dawning of a New Day", "variant" => ':regular' ),
    array( 'name' => "Days One", "variant" => ':regular' ),
    array( 'name' => "Dekko", "variant" => ':regular' ),
    array( 'name' => "Delius", "variant" => ':regular' ),
    array( 'name' => "Delius Swash Caps", "variant" => ':regular' ),
    array( 'name' => "Delius Unicase", "variant" => ':regular,700' ),
    array( 'name' => "Della Respira", "variant" => ':regular' ),
    array( 'name' => "Denk One", "variant" => ':regular' ),
    array( 'name' => "Devonshire", "variant" => ':regular' ),
    array( 'name' => "Dhurjati", "variant" => ':regular' ),
    array( 'name' => "Didact Gothic", "variant" => ':regular' ),
    array( 'name' => "Diplomata", "variant" => ':regular' ),
    array( 'name' => "Diplomata SC", "variant" => ':regular' ),
    array( 'name' => "Domine", "variant" => ':regular,700' ),
    array( 'name' => "Donegal One", "variant" => ':regular' ),
    array( 'name' => "Doppio One", "variant" => ':regular' ),
    array( 'name' => "Dorsa", "variant" => ':regular' ),
    array( 'name' => "Dosis", "variant" => ':200,300,regular,500,600,700,800' ),
    array( 'name' => "Dr Sugiyama", "variant" => ':regular' ),
    array( 'name' => "Droid Sans", "variant" => ':regular,700' ),
    array( 'name' => "Droid Sans Mono", "variant" => ':regular' ),
    array( 'name' => "Droid Serif", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Duru Sans", "variant" => ':regular' ),
    array( 'name' => "Dynalight", "variant" => ':regular' ),
    array( 'name' => "EB Garamond", "variant" => ':regular' ),
    array( 'name' => "Eagle Lake", "variant" => ':regular' ),
    array( 'name' => "Eater", "variant" => ':regular' ),
    array( 'name' => "Economica", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Eczar", "variant" => ':regular,500,600,700,800' ),
    array( 'name' => "Ek Mukta", "variant" => ':200,300,regular,500,600,700,800' ),
    array( 'name' => "Electrolize", "variant" => ':regular' ),
    array( 'name' => "Elsie", "variant" => ':regular,900' ),
    array( 'name' => "Elsie Swash Caps", "variant" => ':regular,900' ),
    array( 'name' => "Emblema One", "variant" => ':regular' ),
    array( 'name' => "Emilys Candy", "variant" => ':regular' ),
    array( 'name' => "Engagement", "variant" => ':regular' ),
    array( 'name' => "Englebert", "variant" => ':regular' ),
    array( 'name' => "Enriqueta", "variant" => ':regular,700' ),
    array( 'name' => "Erica One", "variant" => ':regular' ),
    array( 'name' => "Esteban", "variant" => ':regular' ),
    array( 'name' => "Euphoria Script", "variant" => ':regular' ),
    array( 'name' => "Ewert", "variant" => ':regular' ),
    array( 'name' => "Exo", "variant" => ':100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' ),
    array( 'name' => "Exo 2", "variant" => ':100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' ),
    array( 'name' => "Expletus Sans", "variant" => ':regular,italic,500,500italic,600,600italic,700,700italic' ),
    array( 'name' => "Fanwood Text", "variant" => ':regular,italic' ),
    array( 'name' => "Fascinate", "variant" => ':regular' ),
    array( 'name' => "Fascinate Inline", "variant" => ':regular' ),
    array( 'name' => "Faster One", "variant" => ':regular' ),
    array( 'name' => "Fasthand", "variant" => ':regular' ),
    array( 'name' => "Fauna One", "variant" => ':regular' ),
    array( 'name' => "Federant", "variant" => ':regular' ),
    array( 'name' => "Federo", "variant" => ':regular' ),
    array( 'name' => "Felipa", "variant" => ':regular' ),
    array( 'name' => "Fenix", "variant" => ':regular' ),
    array( 'name' => "Finger Paint", "variant" => ':regular' ),
    array( 'name' => "Fira Mono", "variant" => ':regular,700' ),
    array( 'name' => "Fira Sans", "variant" => ':300,300italic,regular,italic,500,500italic,700,700italic' ),
    array( 'name' => "Fjalla One", "variant" => ':regular' ),
    array( 'name' => "Fjord One", "variant" => ':regular' ),
    array( 'name' => "Flamenco", "variant" => ':300,regular' ),
    array( 'name' => "Flavors", "variant" => ':regular' ),
    array( 'name' => "Fondamento", "variant" => ':regular,italic' ),
    array( 'name' => "Fontdiner Swanky", "variant" => ':regular' ),
    array( 'name' => "Forum", "variant" => ':regular' ),
    array( 'name' => "Francois One", "variant" => ':regular' ),
    array( 'name' => "Freckle Face", "variant" => ':regular' ),
    array( 'name' => "Fredericka the Great", "variant" => ':regular' ),
    array( 'name' => "Fredoka One", "variant" => ':regular' ),
    array( 'name' => "Freehand", "variant" => ':regular' ),
    array( 'name' => "Fresca", "variant" => ':regular' ),
    array( 'name' => "Frijole", "variant" => ':regular' ),
    array( 'name' => "Fruktur", "variant" => ':regular' ),
    array( 'name' => "Fugaz One", "variant" => ':regular' ),
    array( 'name' => "GFS Didot", "variant" => ':regular' ),
    array( 'name' => "GFS Neohellenic", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Gabriela", "variant" => ':regular' ),
    array( 'name' => "Gafata", "variant" => ':regular' ),
    array( 'name' => "Galdeano", "variant" => ':regular' ),
    array( 'name' => "Galindo", "variant" => ':regular' ),
    array( 'name' => "Gentium Basic", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Gentium Book Basic", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Geo", "variant" => ':regular,italic' ),
    array( 'name' => "Geostar", "variant" => ':regular' ),
    array( 'name' => "Geostar Fill", "variant" => ':regular' ),
    array( 'name' => "Germania One", "variant" => ':regular' ),
    array( 'name' => "Gidugu", "variant" => ':regular' ),
    array( 'name' => "Gilda Display", "variant" => ':regular' ),
    array( 'name' => "Give You Glory", "variant" => ':regular' ),
    array( 'name' => "Glass Antiqua", "variant" => ':regular' ),
    array( 'name' => "Glegoo", "variant" => ':regular,700' ),
    array( 'name' => "Gloria Hallelujah", "variant" => ':regular' ),
    array( 'name' => "Goblin One", "variant" => ':regular' ),
    array( 'name' => "Gochi Hand", "variant" => ':regular' ),
    array( 'name' => "Gorditas", "variant" => ':regular,700' ),
    array( 'name' => "Goudy Bookletter 1911", "variant" => ':regular' ),
    array( 'name' => "Graduate", "variant" => ':regular' ),
    array( 'name' => "Grand Hotel", "variant" => ':regular' ),
    array( 'name' => "Gravitas One", "variant" => ':regular' ),
    array( 'name' => "Great Vibes", "variant" => ':regular' ),
    array( 'name' => "Griffy", "variant" => ':regular' ),
    array( 'name' => "Gruppo", "variant" => ':regular' ),
    array( 'name' => "Gudea", "variant" => ':regular,italic,700' ),
    array( 'name' => "Gurajada", "variant" => ':regular' ),
    array( 'name' => "Habibi", "variant" => ':regular' ),
    array( 'name' => "Halant", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Hammersmith One", "variant" => ':regular' ),
    array( 'name' => "Hanalei", "variant" => ':regular' ),
    array( 'name' => "Hanalei Fill", "variant" => ':regular' ),
    array( 'name' => "Handlee", "variant" => ':regular' ),
    array( 'name' => "Hanuman", "variant" => ':regular,700' ),
    array( 'name' => "Happy Monkey", "variant" => ':regular' ),
    array( 'name' => "Headland One", "variant" => ':regular' ),
    array( 'name' => "Henny Penny", "variant" => ':regular' ),
    array( 'name' => "Herr Von Muellerhoff", "variant" => ':regular' ),
    array( 'name' => "Hind", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Holtwood One SC", "variant" => ':regular' ),
    array( 'name' => "Homemade Apple", "variant" => ':regular' ),
    array( 'name' => "Homenaje", "variant" => ':regular' ),
    array( 'name' => "IM Fell DW Pica", "variant" => ':regular,italic' ),
    array( 'name' => "IM Fell DW Pica SC", "variant" => ':regular' ),
    array( 'name' => "IM Fell Double Pica", "variant" => ':regular,italic' ),
    array( 'name' => "IM Fell Double Pica SC", "variant" => ':regular' ),
    array( 'name' => "IM Fell English", "variant" => ':regular,italic' ),
    array( 'name' => "IM Fell English SC", "variant" => ':regular' ),
    array( 'name' => "IM Fell French Canon", "variant" => ':regular,italic' ),
    array( 'name' => "IM Fell French Canon SC", "variant" => ':regular' ),
    array( 'name' => "IM Fell Great Primer", "variant" => ':regular,italic' ),
    array( 'name' => "IM Fell Great Primer SC", "variant" => ':regular' ),
    array( 'name' => "Iceberg", "variant" => ':regular' ),
    array( 'name' => "Iceland", "variant" => ':regular' ),
    array( 'name' => "Imprima", "variant" => ':regular' ),
    array( 'name' => "Inconsolata", "variant" => ':regular,700' ),
    array( 'name' => "Inder", "variant" => ':regular' ),
    array( 'name' => "Indie Flower", "variant" => ':regular' ),
    array( 'name' => "Inika", "variant" => ':regular,700' ),
    array( 'name' => "Inknut Antiqua", "variant" => ':300,regular,500,600,700,800,900' ),
    array( 'name' => "Irish Grover", "variant" => ':regular' ),
    array( 'name' => "Istok Web", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Italiana", "variant" => ':regular' ),
    array( 'name' => "Italianno", "variant" => ':regular' ),
    array( 'name' => "Jacques Francois", "variant" => ':regular' ),
    array( 'name' => "Jacques Francois Shadow", "variant" => ':regular' ),
    array( 'name' => "Jaldi", "variant" => ':regular,700' ),
    array( 'name' => "Jim Nightshade", "variant" => ':regular' ),
    array( 'name' => "Jockey One", "variant" => ':regular' ),
    array( 'name' => "Jolly Lodger", "variant" => ':regular' ),
    array( 'name' => "Josefin Sans", "variant" => ':100,100italic,300,300italic,regular,italic,600,600italic,700,700italic' ),
    array( 'name' => "Josefin Slab", "variant" => ':100,100italic,300,300italic,regular,italic,600,600italic,700,700italic' ),
    array( 'name' => "Joti One", "variant" => ':regular' ),
    array( 'name' => "Judson", "variant" => ':regular,italic,700' ),
    array( 'name' => "Julee", "variant" => ':regular' ),
    array( 'name' => "Julius Sans One", "variant" => ':regular' ),
    array( 'name' => "Junge", "variant" => ':regular' ),
    array( 'name' => "Jura", "variant" => ':300,regular,500,600' ),
    array( 'name' => "Just Another Hand", "variant" => ':regular' ),
    array( 'name' => "Just Me Again Down Here", "variant" => ':regular' ),
    array( 'name' => "Kalam", "variant" => ':300,regular,700' ),
    array( 'name' => "Kameron", "variant" => ':regular,700' ),
    array( 'name' => "Kantumruy", "variant" => ':300,regular,700' ),
    array( 'name' => "Karla", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Karma", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Kaushan Script", "variant" => ':regular' ),
    array( 'name' => "Kavoon", "variant" => ':regular' ),
    array( 'name' => "Kdam Thmor", "variant" => ':regular' ),
    array( 'name' => "Keania One", "variant" => ':regular' ),
    array( 'name' => "Kelly Slab", "variant" => ':regular' ),
    array( 'name' => "Kenia", "variant" => ':regular' ),
    array( 'name' => "Khand", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Khmer", "variant" => ':regular' ),
    array( 'name' => "Khula", "variant" => ':300,regular,600,700,800' ),
    array( 'name' => "Kite One", "variant" => ':regular' ),
    array( 'name' => "Knewave", "variant" => ':regular' ),
    array( 'name' => "Kotta One", "variant" => ':regular' ),
    array( 'name' => "Koulen", "variant" => ':regular' ),
    array( 'name' => "Kranky", "variant" => ':regular' ),
    array( 'name' => "Kreon", "variant" => ':300,regular,700' ),
    array( 'name' => "Kristi", "variant" => ':regular' ),
    array( 'name' => "Krona One", "variant" => ':regular' ),
    array( 'name' => "Kurale", "variant" => ':regular' ),
    array( 'name' => "La Belle Aurore", "variant" => ':regular' ),
    array( 'name' => "Laila", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Lakki Reddy", "variant" => ':regular' ),
    array( 'name' => "Lancelot", "variant" => ':regular' ),
    array( 'name' => "Lateef", "variant" => ':regular' ),
    array( 'name' => "Lato", "variant" => ':100,100italic,300,300italic,regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "League Script", "variant" => ':regular' ),
    array( 'name' => "Leckerli One", "variant" => ':regular' ),
    array( 'name' => "Ledger", "variant" => ':regular' ),
    array( 'name' => "Lekton", "variant" => ':regular,italic,700' ),
    array( 'name' => "Lemon", "variant" => ':regular' ),
    array( 'name' => "Libre Baskerville", "variant" => ':regular,italic,700' ),
    array( 'name' => "Life Savers", "variant" => ':regular,700' ),
    array( 'name' => "Lilita One", "variant" => ':regular' ),
    array( 'name' => "Lily Script One", "variant" => ':regular' ),
    array( 'name' => "Limelight", "variant" => ':regular' ),
    array( 'name' => "Linden Hill", "variant" => ':regular,italic' ),
    array( 'name' => "Lobster", "variant" => ':regular' ),
    array( 'name' => "Lobster Two", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Londrina Outline", "variant" => ':regular' ),
    array( 'name' => "Londrina Shadow", "variant" => ':regular' ),
    array( 'name' => "Londrina Sketch", "variant" => ':regular' ),
    array( 'name' => "Londrina Solid", "variant" => ':regular' ),
    array( 'name' => "Lora", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Love Ya Like A Sister", "variant" => ':regular' ),
    array( 'name' => "Loved by the King", "variant" => ':regular' ),
    array( 'name' => "Lovers Quarrel", "variant" => ':regular' ),
    array( 'name' => "Luckiest Guy", "variant" => ':regular' ),
    array( 'name' => "Lusitana", "variant" => ':regular,700' ),
    array( 'name' => "Lustria", "variant" => ':regular' ),
    array( 'name' => "Macondo", "variant" => ':regular' ),
    array( 'name' => "Macondo Swash Caps", "variant" => ':regular' ),
    array( 'name' => "Magra", "variant" => ':regular,700' ),
    array( 'name' => "Maiden Orange", "variant" => ':regular' ),
    array( 'name' => "Mako", "variant" => ':regular' ),
    array( 'name' => "Mallanna", "variant" => ':regular' ),
    array( 'name' => "Mandali", "variant" => ':regular' ),
    array( 'name' => "Marcellus", "variant" => ':regular' ),
    array( 'name' => "Marcellus SC", "variant" => ':regular' ),
    array( 'name' => "Marck Script", "variant" => ':regular' ),
    array( 'name' => "Margarine", "variant" => ':regular' ),
    array( 'name' => "Marko One", "variant" => ':regular' ),
    array( 'name' => "Marmelad", "variant" => ':regular' ),
    array( 'name' => "Martel", "variant" => ':200,300,regular,600,700,800,900' ),
    array( 'name' => "Martel Sans", "variant" => ':200,300,regular,600,700,800,900' ),
    array( 'name' => "Marvel", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Mate", "variant" => ':regular,italic' ),
    array( 'name' => "Mate SC", "variant" => ':regular' ),
    array( 'name' => "Maven Pro", "variant" => ':regular,500,700,900' ),
    array( 'name' => "McLaren", "variant" => ':regular' ),
    array( 'name' => "Meddon", "variant" => ':regular' ),
    array( 'name' => "MedievalSharp", "variant" => ':regular' ),
    array( 'name' => "Medula One", "variant" => ':regular' ),
    array( 'name' => "Megrim", "variant" => ':regular' ),
    array( 'name' => "Meie Script", "variant" => ':regular' ),
    array( 'name' => "Merienda", "variant" => ':regular,700' ),
    array( 'name' => "Merienda One", "variant" => ':regular' ),
    array( 'name' => "Merriweather", "variant" => ':300,300italic,regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Merriweather Sans", "variant" => ':300,300italic,regular,italic,700,700italic,800,800italic' ),
    array( 'name' => "Metal", "variant" => ':regular' ),
    array( 'name' => "Metal Mania", "variant" => ':regular' ),
    array( 'name' => "Metamorphous", "variant" => ':regular' ),
    array( 'name' => "Metrophobic", "variant" => ':regular' ),
    array( 'name' => "Michroma", "variant" => ':regular' ),
    array( 'name' => "Milonga", "variant" => ':regular' ),
    array( 'name' => "Miltonian", "variant" => ':regular' ),
    array( 'name' => "Miltonian Tattoo", "variant" => ':regular' ),
    array( 'name' => "Miniver", "variant" => ':regular' ),
    array( 'name' => "Miss Fajardose", "variant" => ':regular' ),
    array( 'name' => "Modak", "variant" => ':regular' ),
    array( 'name' => "Modern Antiqua", "variant" => ':regular' ),
    array( 'name' => "Molengo", "variant" => ':regular' ),
    array( 'name' => "Molle", "variant" => ':italic' ),
    array( 'name' => "Monda", "variant" => ':regular,700' ),
    array( 'name' => "Monofett", "variant" => ':regular' ),
    array( 'name' => "Monoton", "variant" => ':regular' ),
    array( 'name' => "Monsieur La Doulaise", "variant" => ':regular' ),
    array( 'name' => "Montaga", "variant" => ':regular' ),
    array( 'name' => "Montez", "variant" => ':regular' ),
    array( 'name' => "Montserrat", "variant" => ':regular,700' ),
    array( 'name' => "Montserrat Alternates", "variant" => ':regular,700' ),
    array( 'name' => "Montserrat Subrayada", "variant" => ':regular,700' ),
    array( 'name' => "Moul", "variant" => ':regular' ),
    array( 'name' => "Moulpali", "variant" => ':regular' ),
    array( 'name' => "Mountains of Christmas", "variant" => ':regular,700' ),
    array( 'name' => "Mouse Memoirs", "variant" => ':regular' ),
    array( 'name' => "Mr Bedfort", "variant" => ':regular' ),
    array( 'name' => "Mr Dafoe", "variant" => ':regular' ),
    array( 'name' => "Mr De Haviland", "variant" => ':regular' ),
    array( 'name' => "Mrs Saint Delafield", "variant" => ':regular' ),
    array( 'name' => "Mrs Sheppards", "variant" => ':regular' ),
    array( 'name' => "Muli", "variant" => ':300,300italic,regular,italic' ),
    array( 'name' => "Mystery Quest", "variant" => ':regular' ),
    array( 'name' => "NTR", "variant" => ':regular' ),
    array( 'name' => "Neucha", "variant" => ':regular' ),
    array( 'name' => "Neuton", "variant" => ':200,300,regular,italic,700,800' ),
    array( 'name' => "New Rocker", "variant" => ':regular' ),
    array( 'name' => "News Cycle", "variant" => ':regular,700' ),
    array( 'name' => "Niconne", "variant" => ':regular' ),
    array( 'name' => "Nixie One", "variant" => ':regular' ),
    array( 'name' => "Nobile", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Nokora", "variant" => ':regular,700' ),
    array( 'name' => "Norican", "variant" => ':regular' ),
    array( 'name' => "Nosifer", "variant" => ':regular' ),
    array( 'name' => "Nothing You Could Do", "variant" => ':regular' ),
    array( 'name' => "Noticia Text", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Noto Sans", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Noto Serif", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Nova Cut", "variant" => ':regular' ),
    array( 'name' => "Nova Flat", "variant" => ':regular' ),
    array( 'name' => "Nova Mono", "variant" => ':regular' ),
    array( 'name' => "Nova Oval", "variant" => ':regular' ),
    array( 'name' => "Nova Round", "variant" => ':regular' ),
    array( 'name' => "Nova Script", "variant" => ':regular' ),
    array( 'name' => "Nova Slim", "variant" => ':regular' ),
    array( 'name' => "Nova Square", "variant" => ':regular' ),
    array( 'name' => "Numans", "variant" => ':regular' ),
    array( 'name' => "Nunito", "variant" => ':300,regular,700' ),
    array( 'name' => "Odor Mean Chey", "variant" => ':regular' ),
    array( 'name' => "Offside", "variant" => ':regular' ),
    array( 'name' => "Old Standard TT", "variant" => ':regular,italic,700' ),
    array( 'name' => "Oldenburg", "variant" => ':regular' ),
    array( 'name' => "Oleo Script", "variant" => ':regular,700' ),
    array( 'name' => "Oleo Script Swash Caps", "variant" => ':regular,700' ),
    array( 'name' => "Open Sans", "variant" => ':300,300italic,regular,italic,600,600italic,700,700italic,800,800italic' ),
    array( 'name' => "Open Sans Condensed", "variant" => ':300,300italic,700' ),
    array( 'name' => "Oranienbaum", "variant" => ':regular' ),
    array( 'name' => "Orbitron", "variant" => ':regular,500,700,900' ),
    array( 'name' => "Oregano", "variant" => ':regular,italic' ),
    array( 'name' => "Orienta", "variant" => ':regular' ),
    array( 'name' => "Original Surfer", "variant" => ':regular' ),
    array( 'name' => "Oswald", "variant" => ':300,regular,700' ),
    array( 'name' => "Over the Rainbow", "variant" => ':regular' ),
    array( 'name' => "Overlock", "variant" => ':regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Overlock SC", "variant" => ':regular' ),
    array( 'name' => "Ovo", "variant" => ':regular' ),
    array( 'name' => "Oxygen", "variant" => ':300,regular,700' ),
    array( 'name' => "Oxygen Mono", "variant" => ':regular' ),
    array( 'name' => "PT Mono", "variant" => ':regular' ),
    array( 'name' => "PT Sans", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "PT Sans Caption", "variant" => ':regular,700' ),
    array( 'name' => "PT Sans Narrow", "variant" => ':regular,700' ),
    array( 'name' => "PT Serif", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "PT Serif Caption", "variant" => ':regular,italic' ),
    array( 'name' => "Pacifico", "variant" => ':regular' ),
    array( 'name' => "Palanquin", "variant" => ':100,200,300,regular,500,600,700' ),
    array( 'name' => "Palanquin Dark", "variant" => ':regular,500,600,700' ),
    array( 'name' => "Paprika", "variant" => ':regular' ),
    array( 'name' => "Parisienne", "variant" => ':regular' ),
    array( 'name' => "Passero One", "variant" => ':regular' ),
    array( 'name' => "Passion One", "variant" => ':regular,700,900' ),
    array( 'name' => "Pathway Gothic One", "variant" => ':regular' ),
    array( 'name' => "Patrick Hand", "variant" => ':regular' ),
    array( 'name' => "Patrick Hand SC", "variant" => ':regular' ),
    array( 'name' => "Patua One", "variant" => ':regular' ),
    array( 'name' => "Paytone One", "variant" => ':regular' ),
    array( 'name' => "Peddana", "variant" => ':regular' ),
    array( 'name' => "Peralta", "variant" => ':regular' ),
    array( 'name' => "Permanent Marker", "variant" => ':regular' ),
    array( 'name' => "Petit Formal Script", "variant" => ':regular' ),
    array( 'name' => "Petrona", "variant" => ':regular' ),
    array( 'name' => "Philosopher", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Piedra", "variant" => ':regular' ),
    array( 'name' => "Pinyon Script", "variant" => ':regular' ),
    array( 'name' => "Pirata One", "variant" => ':regular' ),
    array( 'name' => "Plaster", "variant" => ':regular' ),
    array( 'name' => "Play", "variant" => ':regular,700' ),
    array( 'name' => "Playball", "variant" => ':regular' ),
    array( 'name' => "Playfair Display", "variant" => ':regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Playfair Display SC", "variant" => ':regular,italic,700,700italic,900,900italic' ),
    array( 'name' => "Podkova", "variant" => ':regular,700' ),
    array( 'name' => "Poiret One", "variant" => ':regular' ),
    array( 'name' => "Poller One", "variant" => ':regular' ),
    array( 'name' => "Poly", "variant" => ':regular,italic' ),
    array( 'name' => "Pompiere", "variant" => ':regular' ),
    array( 'name' => "Pontano Sans", "variant" => ':regular' ),
    array( 'name' => "Poppins", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Port Lligat Sans", "variant" => ':regular' ),
    array( 'name' => "Port Lligat Slab", "variant" => ':regular' ),
    array( 'name' => "Pragati Narrow", "variant" => ':regular,700' ),
    array( 'name' => "Prata", "variant" => ':regular' ),
    array( 'name' => "Preahvihear", "variant" => ':regular' ),
    array( 'name' => "Press Start 2P", "variant" => ':regular' ),
    array( 'name' => "Princess Sofia", "variant" => ':regular' ),
    array( 'name' => "Prociono", "variant" => ':regular' ),
    array( 'name' => "Prosto One", "variant" => ':regular' ),
    array( 'name' => "Puritan", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Purple Purse", "variant" => ':regular' ),
    array( 'name' => "Quando", "variant" => ':regular' ),
    array( 'name' => "Quantico", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Quattrocento", "variant" => ':regular,700' ),
    array( 'name' => "Quattrocento Sans", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Questrial", "variant" => ':regular' ),
    array( 'name' => "Quicksand", "variant" => ':300,regular,700' ),
    array( 'name' => "Quintessential", "variant" => ':regular' ),
    array( 'name' => "Qwigley", "variant" => ':regular' ),
    array( 'name' => "Racing Sans One", "variant" => ':regular' ),
    array( 'name' => "Radley", "variant" => ':regular,italic' ),
    array( 'name' => "Rajdhani", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Raleway", "variant" => ':100,200,300,regular,500,600,700,800,900' ),
    array( 'name' => "Raleway Dots", "variant" => ':regular' ),
    array( 'name' => "Ramabhadra", "variant" => ':regular' ),
    array( 'name' => "Ramaraja", "variant" => ':regular' ),
    array( 'name' => "Rambla", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Rammetto One", "variant" => ':regular' ),
    array( 'name' => "Ranchers", "variant" => ':regular' ),
    array( 'name' => "Rancho", "variant" => ':regular' ),
    array( 'name' => "Ranga", "variant" => ':regular,700' ),
    array( 'name' => "Rationale", "variant" => ':regular' ),
    array( 'name' => "Ravi Prakash", "variant" => ':regular' ),
    array( 'name' => "Redressed", "variant" => ':regular' ),
    array( 'name' => "Reenie Beanie", "variant" => ':regular' ),
    array( 'name' => "Revalia", "variant" => ':regular' ),
    array( 'name' => "Rhodium Libre", "variant" => ':regular' ),
    array( 'name' => "Ribeye", "variant" => ':regular' ),
    array( 'name' => "Ribeye Marrow", "variant" => ':regular' ),
    array( 'name' => "Righteous", "variant" => ':regular' ),
    array( 'name' => "Risque", "variant" => ':regular' ),
    array( 'name' => "Roboto", "variant" => ':100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic' ),
    array( 'name' => "Roboto Condensed", "variant" => ':300,300italic,regular,italic,700,700italic' ),
    array( 'name' => "Roboto Mono", "variant" => ':100,100italic,300,300italic,regular,italic,500,500italic,700,700italic' ),
    array( 'name' => "Roboto Slab", "variant" => ':100,300,regular,700' ),
    array( 'name' => "Rochester", "variant" => ':regular' ),
    array( 'name' => "Rock Salt", "variant" => ':regular' ),
    array( 'name' => "Rokkitt", "variant" => ':regular,700' ),
    array( 'name' => "Romanesco", "variant" => ':regular' ),
    array( 'name' => "Ropa Sans", "variant" => ':regular,italic' ),
    array( 'name' => "Rosario", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Rosarivo", "variant" => ':regular,italic' ),
    array( 'name' => "Rouge Script", "variant" => ':regular' ),
    array( 'name' => "Rozha One", "variant" => ':regular' ),
    array( 'name' => "Rubik Mono One", "variant" => ':regular' ),
    array( 'name' => "Rubik One", "variant" => ':regular' ),
    array( 'name' => "Ruda", "variant" => ':regular,700,900' ),
    array( 'name' => "Rufina", "variant" => ':regular,700' ),
    array( 'name' => "Ruge Boogie", "variant" => ':regular' ),
    array( 'name' => "Ruluko", "variant" => ':regular' ),
    array( 'name' => "Rum Raisin", "variant" => ':regular' ),
    array( 'name' => "Ruslan Display", "variant" => ':regular' ),
    array( 'name' => "Russo One", "variant" => ':regular' ),
    array( 'name' => "Ruthie", "variant" => ':regular' ),
    array( 'name' => "Rye", "variant" => ':regular' ),
    array( 'name' => "Sacramento", "variant" => ':regular' ),
    array( 'name' => "Sail", "variant" => ':regular' ),
    array( 'name' => "Salsa", "variant" => ':regular' ),
    array( 'name' => "Sanchez", "variant" => ':regular,italic' ),
    array( 'name' => "Sancreek", "variant" => ':regular' ),
    array( 'name' => "Sansita One", "variant" => ':regular' ),
    array( 'name' => "Sarina", "variant" => ':regular' ),
    array( 'name' => "Sarpanch", "variant" => ':regular,500,600,700,800,900' ),
    array( 'name' => "Satisfy", "variant" => ':regular' ),
    array( 'name' => "Scada", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Scheherazade", "variant" => ':regular' ),
    array( 'name' => "Schoolbell", "variant" => ':regular' ),
    array( 'name' => "Seaweed Script", "variant" => ':regular' ),
    array( 'name' => "Sevillana", "variant" => ':regular' ),
    array( 'name' => "Seymour One", "variant" => ':regular' ),
    array( 'name' => "Shadows Into Light", "variant" => ':regular' ),
    array( 'name' => "Shadows Into Light Two", "variant" => ':regular' ),
    array( 'name' => "Shanti", "variant" => ':regular' ),
    array( 'name' => "Share", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Share Tech", "variant" => ':regular' ),
    array( 'name' => "Share Tech Mono", "variant" => ':regular' ),
    array( 'name' => "Shojumaru", "variant" => ':regular' ),
    array( 'name' => "Short Stack", "variant" => ':regular' ),
    array( 'name' => "Siemreap", "variant" => ':regular' ),
    array( 'name' => "Sigmar One", "variant" => ':regular' ),
    array( 'name' => "Signika", "variant" => ':300,regular,600,700' ),
    array( 'name' => "Signika Negative", "variant" => ':300,regular,600,700' ),
    array( 'name' => "Simonetta", "variant" => ':regular,italic,900,900italic' ),
    array( 'name' => "Sintony", "variant" => ':regular,700' ),
    array( 'name' => "Sirin Stencil", "variant" => ':regular' ),
    array( 'name' => "Six Caps", "variant" => ':regular' ),
    array( 'name' => "Skranji", "variant" => ':regular,700' ),
    array( 'name' => "Slabo 13px", "variant" => ':regular' ),
    array( 'name' => "Slabo 27px", "variant" => ':regular' ),
    array( 'name' => "Slackey", "variant" => ':regular' ),
    array( 'name' => "Smokum", "variant" => ':regular' ),
    array( 'name' => "Smythe", "variant" => ':regular' ),
    array( 'name' => "Sniglet", "variant" => ':regular,800' ),
    array( 'name' => "Snippet", "variant" => ':regular' ),
    array( 'name' => "Snowburst One", "variant" => ':regular' ),
    array( 'name' => "Sofadi One", "variant" => ':regular' ),
    array( 'name' => "Sofia", "variant" => ':regular' ),
    array( 'name' => "Sonsie One", "variant" => ':regular' ),
    array( 'name' => "Sorts Mill Goudy", "variant" => ':regular,italic' ),
    array( 'name' => "Source Code Pro", "variant" => ':200,300,regular,500,600,700,900' ),
    array( 'name' => "Source Sans Pro", "variant" => ':200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900,900italic' ),
    array( 'name' => "Source Serif Pro", "variant" => ':regular,600,700' ),
    array( 'name' => "Special Elite", "variant" => ':regular' ),
    array( 'name' => "Spicy Rice", "variant" => ':regular' ),
    array( 'name' => "Spinnaker", "variant" => ':regular' ),
    array( 'name' => "Spirax", "variant" => ':regular' ),
    array( 'name' => "Squada One", "variant" => ':regular' ),
    array( 'name' => "Sree Krushnadevaraya", "variant" => ':regular' ),
    array( 'name' => "Stalemate", "variant" => ':regular' ),
    array( 'name' => "Stalinist One", "variant" => ':regular' ),
    array( 'name' => "Stardos Stencil", "variant" => ':regular,700' ),
    array( 'name' => "Stint Ultra Condensed", "variant" => ':regular' ),
    array( 'name' => "Stint Ultra Expanded", "variant" => ':regular' ),
    array( 'name' => "Stoke", "variant" => ':300,regular' ),
    array( 'name' => "Strait", "variant" => ':regular' ),
    array( 'name' => "Sue Ellen Francisco", "variant" => ':regular' ),
    array( 'name' => "Sumana", "variant" => ':regular,700' ),
    array( 'name' => "Sunshiney", "variant" => ':regular' ),
    array( 'name' => "Supermercado One", "variant" => ':regular' ),
    array( 'name' => "Suranna", "variant" => ':regular' ),
    array( 'name' => "Suravaram", "variant" => ':regular' ),
    array( 'name' => "Suwannaphum", "variant" => ':regular' ),
    array( 'name' => "Swanky and Moo Moo", "variant" => ':regular' ),
    array( 'name' => "Syncopate", "variant" => ':regular,700' ),
    array( 'name' => "Tangerine", "variant" => ':regular,700' ),
    array( 'name' => "Taprom", "variant" => ':regular' ),
    array( 'name' => "Tauri", "variant" => ':regular' ),
    array( 'name' => "Teko", "variant" => ':300,regular,500,600,700' ),
    array( 'name' => "Telex", "variant" => ':regular' ),
    array( 'name' => "Tenali Ramakrishna", "variant" => ':regular' ),
    array( 'name' => "Tenor Sans", "variant" => ':regular' ),
    array( 'name' => "Text Me One", "variant" => ':regular' ),
    array( 'name' => "The Girl Next Door", "variant" => ':regular' ),
    array( 'name' => "Tienne", "variant" => ':regular,700,900' ),
    array( 'name' => "Tillana", "variant" => ':regular,500,600,700,800' ),
    array( 'name' => "Timmana", "variant" => ':regular' ),
    array( 'name' => "Tinos", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Titan One", "variant" => ':regular' ),
    array( 'name' => "Titillium Web", "variant" => ':200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900' ),
    array( 'name' => "Trade Winds", "variant" => ':regular' ),
    array( 'name' => "Trocchi", "variant" => ':regular' ),
    array( 'name' => "Trochut", "variant" => ':regular,italic,700' ),
    array( 'name' => "Trykker", "variant" => ':regular' ),
    array( 'name' => "Tulpen One", "variant" => ':regular' ),
    array( 'name' => "Ubuntu", "variant" => ':300,300italic,regular,italic,500,500italic,700,700italic' ),
    array( 'name' => "Ubuntu Condensed", "variant" => ':regular' ),
    array( 'name' => "Ubuntu Mono", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Ultra", "variant" => ':regular' ),
    array( 'name' => "Uncial Antiqua", "variant" => ':regular' ),
    array( 'name' => "Underdog", "variant" => ':regular' ),
    array( 'name' => "Unica One", "variant" => ':regular' ),
    array( 'name' => "UnifrakturCook", "variant" => ':700' ),
    array( 'name' => "UnifrakturMaguntia", "variant" => ':regular' ),
    array( 'name' => "Unkempt", "variant" => ':regular,700' ),
    array( 'name' => "Unlock", "variant" => ':regular' ),
    array( 'name' => "Unna", "variant" => ':regular' ),
    array( 'name' => "VT323", "variant" => ':regular' ),
    array( 'name' => "Vampiro One", "variant" => ':regular' ),
    array( 'name' => "Varela", "variant" => ':regular' ),
    array( 'name' => "Varela Round", "variant" => ':regular' ),
    array( 'name' => "Vast Shadow", "variant" => ':regular' ),
    array( 'name' => "Vesper Libre", "variant" => ':regular,500,700,900' ),
    array( 'name' => "Vibur", "variant" => ':regular' ),
    array( 'name' => "Vidaloka", "variant" => ':regular' ),
    array( 'name' => "Viga", "variant" => ':regular' ),
    array( 'name' => "Voces", "variant" => ':regular' ),
    array( 'name' => "Volkhov", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Vollkorn", "variant" => ':regular,italic,700,700italic' ),
    array( 'name' => "Voltaire", "variant" => ':regular' ),
    array( 'name' => "Waiting for the Sunrise", "variant" => ':regular' ),
    array( 'name' => "Wallpoet", "variant" => ':regular' ),
    array( 'name' => "Walter Turncoat", "variant" => ':regular' ),
    array( 'name' => "Warnes", "variant" => ':regular' ),
    array( 'name' => "Wellfleet", "variant" => ':regular' ),
    array( 'name' => "Wendy One", "variant" => ':regular' ),
    array( 'name' => "Wire One", "variant" => ':regular' ),
    array( 'name' => "Yanone Kaffeesatz", "variant" => ':200,300,regular,700' ),
    array( 'name' => "Yantramanav", "variant" => ':100,300,regular,500,700,900' ),
    array( 'name' => "Yellowtail", "variant" => ':regular' ),
    array( 'name' => "Yeseva One", "variant" => ':regular' ),
    array( 'name' => "Yesteryear", "variant" => ':regular' ),
    array( 'name' => "Zeyada", "variant" => ':regular' )
);

$google_fonts = apply_filters( 'responsi_google_fonts', $google_fonts );

sort( $google_fonts );

$new_google_fonts = array();
foreach ( $google_fonts as $font ) {
    $new_google_fonts[$font['name']] = $font;
}

$google_fonts = $new_google_fonts;

$responsi_icons = apply_filters( 'responsi_icons', array(
    'hamburger'             => '<svg width="14" height="14" class="svg-hamburger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 3C1.22386 3 1 3.22386 1 3.5C1 3.77614 1.22386 4 1.5 4H13.5C13.7761 4 14 3.77614 14 3.5C14 3.22386 13.7761 3 13.5 3H1.5ZM1 7.5C1 7.22386 1.22386 7 1.5 7H13.5C13.7761 7 14 7.22386 14 7.5C14 7.77614 13.7761 8 13.5 8H1.5C1.22386 8 1 7.77614 1 7.5ZM1 11.5C1 11.2239 1.22386 11 1.5 11H13.5C13.7761 11 14 11.2239 14 11.5C14 11.7761 13.7761 12 13.5 12H1.5C1.22386 12 1 11.7761 1 11.5Z" fill="currentColor" /></svg>',
    'author'                => '<svg width="14" height="14" class="svg-author" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 110.44"><path d="M46.07,68.62a19.25,19.25,0,0,1-1.63-2c-1.2-1.65-2.33-3.37-3.42-5.1L35.6,52.89c-2.06-3-3.14-5.74-3.14-7.91s1.23-5,3.68-5.63a149.33,149.33,0,0,1-.21-15.61,19.7,19.7,0,0,1,.65-3.58,20.63,20.63,0,0,1,9.21-11.7,23.65,23.65,0,0,1,5-2.39c3.15-1.19,1.63-6,5.1-6.07C64-.21,77.33,6.73,82.53,12.36a20.56,20.56,0,0,1,5.31,13.33l-.33,14.2a4,4,0,0,1,2.93,2.92c.43,1.74,0,4.12-1.52,7.48h0c0,.11-.11.11-.11.22L82.63,60.7c-1.4,2.3-2.85,4.65-4.48,6.81-1.93,2.58-3.52,2.12-1.87,4.59,11.83,16.26,46.6,6,46.6,38.34H0C0,78.08,34.78,88.36,46.6,72.1c1.36-2,1-1.85-.53-3.48Z"></path></svg>',
    'category'              => '<svg width="14" height="14" class="svg-category" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 102.55 122.88" style="enable-background:new 0 0 102.55 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M102.55,122.88H0V0h77.66l24.89,26.43V122.88L102.55,122.88z M88.95,100.77H15.63v-5.58h73.33V100.77 L88.95,100.77z M64.44,31.63H15.63v-5.55h48.82V31.63L64.44,31.63z M87.33,47.35h-71.7v-5.58h71.7V47.35L87.33,47.35z M47.3,65.41 H15.63v-5.55H47.3V65.41L47.3,65.41z M88.95,82.68H15.63v-5.55h73.33V82.68L88.95,82.68z"></path></g></svg>',
    'comment'               => '<svg width="14" height="14" class="svg-comment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 121.83 122.88"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><path class="cls-1" d="M55.05,97.68l-24.9,23.88a3.95,3.95,0,0,1-6.89-2.62V97.68H10.1A10.16,10.16,0,0,1,0,87.58V10.1A10.18,10.18,0,0,1,10.1,0H111.73a10.16,10.16,0,0,1,10.1,10.1V87.58a10.16,10.16,0,0,1-10.1,10.1ZM27.53,36.61a3.94,3.94,0,0,1,0-7.87H94.3a3.94,3.94,0,1,1,0,7.87Zm0,25.55a3.94,3.94,0,0,1,0-7.87H82a3.94,3.94,0,0,1,0,7.87Z"></path></svg>',
    'tag'                   => '<svg width="14" height="14" class="svg-tag" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 121.014 122.878" enable-background="new 0 0 121.014 122.878" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M63.769,3.827l54.715,59.579c3.695,4.021,3.272,10.385-0.802,14.019 l-48.172,42.95c-4.069,3.63-10.388,3.27-14.018-0.805L4.112,61.934l0.098-1.699L0,0l61.944,3.922 C62.54,3.881,63.147,3.849,63.769,3.827L63.769,3.827z M24.269,11.894c6.141,0.136,11.013,5.227,10.877,11.368 c-0.136,6.142-5.227,11.013-11.368,10.877c-6.141-0.136-11.013-5.227-10.877-11.368C13.036,16.629,18.127,11.758,24.269,11.894 L24.269,11.894z M33.948,53.765l35.36,38.527l-7.048,6.472L26.9,60.233L33.948,53.765L33.948,53.765z M63.797,26.51L99.16,65.04 l-7.052,6.468l-35.36-38.527L63.797,26.51L63.797,26.51z M49.586,39.811l35.363,38.527l-7.052,6.469L42.538,46.279L49.586,39.811 L49.586,39.811z"></path></g></svg>',
    'calendar'              => '<svg width="14" height="14" class="svg-calendar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110.02 122.88"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><path class="cls-1" d="M1.87,14.69H24.53l0-.39V4.13C24.5,1.86,26.86,0,29.76,0S35,1.87,35,4.13V14.3l0,.39h38.6l0-.39V4.13C73.56,1.86,75.92,0,78.81,0s5.26,1.87,5.26,4.13V14.3l0,.39h24.11A1.87,1.87,0,0,1,110,16.56V36a1.87,1.87,0,0,1-1.87,1.87H1.87A1.89,1.89,0,0,1,0,36V16.55a1.87,1.87,0,0,1,1.87-1.86ZM14.16,96.82h13.7c.83,0,1.51.51,1.51,1.13v7.21c0,.62-.68,1.13-1.51,1.13H14.62c-.83,0-1.5-.51-1.5-1.13V98c0-.62.68-1.13,1.5-1.13Zm32.92,0H60.79c.83,0,1.5.51,1.5,1.13v7.21c0,.62-.68,1.13-1.5,1.13H47.08c-.83,0-1.51-.51-1.51-1.13V98c0-.62.68-1.13,1.51-1.13Zm32.68,0H93.47c.83,0,1.51.51,1.51,1.13v7.21c0,.62-.68,1.13-1.51,1.13H79.76c-.83,0-1.51-.51-1.51-1.13V98a1.37,1.37,0,0,1,1.51-1.13ZM14.16,76.71h13.7c.83,0,1.51.51,1.51,1.14v7.2c0,.62-.68,1.13-1.51,1.13H14.62c-.83,0-1.5-.51-1.5-1.13v-7.2a1.36,1.36,0,0,1,1.5-1.14Zm32.92,0H60.79a1.36,1.36,0,0,1,1.5,1.14v7.2c0,.62-.68,1.13-1.5,1.13H47.08c-.83,0-1.51-.51-1.51-1.13v-7.2c0-.63.68-1.14,1.51-1.14Zm32.68,0H93.47c.83,0,1.51.51,1.51,1.14v7.2c0,.62-.68,1.13-1.51,1.13H79.76c-.83,0-1.51-.51-1.51-1.13v-7.2a1.37,1.37,0,0,1,1.51-1.14ZM14.16,56.6h13.7c.83,0,1.51.51,1.51,1.14v7.2c0,.62-.68,1.14-1.51,1.14H14.62a1.36,1.36,0,0,1-1.5-1.14v-7.2a1.36,1.36,0,0,1,1.5-1.14Zm32.92,0H60.79a1.36,1.36,0,0,1,1.5,1.14v7.2a1.37,1.37,0,0,1-1.5,1.14H47.08c-.83,0-1.51-.51-1.51-1.14v-7.2c0-.63.68-1.14,1.51-1.14Zm32.68,0H93.47c.83,0,1.51.51,1.51,1.14v7.2c0,.62-.68,1.14-1.51,1.14H79.76c-.83,0-1.51-.51-1.51-1.14v-7.2a1.37,1.37,0,0,1,1.51-1.14ZM.47,42.19H109.56a.46.46,0,0,1,.46.46h0v79.77a.47.47,0,0,1-.46.46H.47a.47.47,0,0,1-.47-.46V42.66a.47.47,0,0,1,.47-.47ZM7,47.71h96.93a1,1,0,0,1,.94.94v67.78a1,1,0,0,1-.94.94H6.08a1,1,0,0,1-.94-.94V49.58A1.87,1.87,0,0,1,7,47.71Z"></path></svg>',
    'arrowleft'             => '<svg width="14" height="14" class="svg-arrowleft" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120.64 122.88" style="enable-background:new 0 0 120.64 122.88" xml:space="preserve"><g><path d="M66.6,108.91c1.55,1.63,2.31,3.74,2.28,5.85c-0.03,2.11-0.84,4.2-2.44,5.79l-0.12,0.12c-1.58,1.5-3.6,2.23-5.61,2.2 c-2.01-0.03-4.02-0.82-5.55-2.37C37.5,102.85,20.03,84.9,2.48,67.11c-0.07-0.05-0.13-0.1-0.19-0.16C0.73,65.32-0.03,63.19,0,61.08 c0.03-2.11,0.85-4.21,2.45-5.8l0.27-0.26C20.21,37.47,37.65,19.87,55.17,2.36C56.71,0.82,58.7,0.03,60.71,0 c2.01-0.03,4.03,0.7,5.61,2.21l0.15,0.15c1.57,1.58,2.38,3.66,2.41,5.76c0.03,2.1-0.73,4.22-2.28,5.85L19.38,61.23L66.6,108.91 L66.6,108.91z M118.37,106.91c1.54,1.62,2.29,3.73,2.26,5.83c-0.03,2.11-0.84,4.2-2.44,5.79l-0.12,0.12 c-1.57,1.5-3.6,2.23-5.61,2.21c-2.01-0.03-4.02-0.82-5.55-2.37C89.63,101.2,71.76,84.2,54.24,67.12c-0.07-0.05-0.14-0.11-0.21-0.17 c-1.55-1.63-2.31-3.76-2.28-5.87c0.03-2.11,0.85-4.21,2.45-5.8C71.7,38.33,89.27,21.44,106.8,4.51l0.12-0.13 c1.53-1.54,3.53-2.32,5.54-2.35c2.01-0.03,4.03,0.7,5.61,2.21l0.15,0.15c1.57,1.58,2.38,3.66,2.41,5.76 c0.03,2.1-0.73,4.22-2.28,5.85L71.17,61.23L118.37,106.91L118.37,106.91z"></path></g></svg>',
    'arrowright'            => '<svg width="14" height="14" class="svg-arrowright" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120.64 122.88" style="enable-background:new 0 0 120.64 122.88" xml:space="preserve"><g><path d="M54.03,108.91c-1.55,1.63-2.31,3.74-2.28,5.85c0.03,2.11,0.84,4.2,2.44,5.79l0.12,0.12c1.58,1.5,3.6,2.23,5.61,2.2 c2.01-0.03,4.01-0.82,5.55-2.37c17.66-17.66,35.13-35.61,52.68-53.4c0.07-0.05,0.13-0.1,0.19-0.16c1.55-1.63,2.31-3.76,2.28-5.87 c-0.03-2.11-0.85-4.21-2.45-5.8l-0.27-0.26C100.43,37.47,82.98,19.87,65.46,2.36C63.93,0.82,61.93,0.03,59.92,0 c-2.01-0.03-4.03,0.7-5.61,2.21l-0.15,0.15c-1.57,1.58-2.38,3.66-2.41,5.76c-0.03,2.1,0.73,4.22,2.28,5.85l47.22,47.27 L54.03,108.91L54.03,108.91z M2.26,106.91c-1.54,1.62-2.29,3.73-2.26,5.83c0.03,2.11,0.84,4.2,2.44,5.79l0.12,0.12 c1.57,1.5,3.6,2.23,5.61,2.21c2.01-0.03,4.02-0.82,5.55-2.37C31.01,101.2,48.87,84.2,66.39,67.12c0.07-0.05,0.14-0.11,0.21-0.17 c1.55-1.63,2.31-3.76,2.28-5.87c-0.03-2.11-0.85-4.21-2.45-5.8C48.94,38.33,31.36,21.44,13.83,4.51l-0.12-0.13 c-1.53-1.54-3.53-2.32-5.54-2.35C6.16,2,4.14,2.73,2.56,4.23L2.41,4.38C0.84,5.96,0.03,8.05,0,10.14c-0.03,2.1,0.73,4.22,2.28,5.85 l47.18,45.24L2.26,106.91L2.26,106.91z"></path></g></svg>',
    'arrowcircleup'         => '<svg width="14" height="14" class="svg-arrowcircleup" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.883 122.882" enable-background="new 0 0 122.883 122.882" xml:space="preserve"><g><path d="M0,61.441L0,61.441h0.018c0,16.976,6.872,32.335,17.98,43.443c11.108,11.107,26.467,17.979,43.441,17.979v0.018h0.001 h0.001v-0.018c16.974,0,32.335-6.872,43.443-17.98s17.98-26.467,17.98-43.441h0.018v-0.001V61.44h-0.018 c0-16.975-6.873-32.334-17.98-43.443C93.775,6.89,78.418,0.018,61.443,0.018V0h-0.002l0,0v0.018 c-16.975,0-32.335,6.872-43.443,17.98C6.89,29.106,0.018,44.465,0.018,61.439H0V61.441L0,61.441z M42.48,71.7 c-1.962,1.908-5.101,1.865-7.009-0.098c-1.909-1.962-1.865-5.101,0.097-7.009l22.521-21.839l3.456,3.553l-3.46-3.569 c1.971-1.911,5.117-1.862,7.029,0.108c0.055,0.058,0.109,0.115,0.16,0.175L87.33,64.594c1.963,1.908,2.006,5.047,0.098,7.009 c-1.908,1.963-5.047,2.006-7.01,0.098L61.53,53.227L42.48,71.7L42.48,71.7z"></path></g></svg>',
    'close'                 => '<svg width="14" height="14" class="svg-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="121.31px" height="122.876px" viewBox="0 0 121.31 122.876" enable-background="new 0 0 121.31 122.876" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M90.914,5.296c6.927-7.034,18.188-7.065,25.154-0.068 c6.961,6.995,6.991,18.369,0.068,25.397L85.743,61.452l30.425,30.855c6.866,6.978,6.773,18.28-0.208,25.247 c-6.983,6.964-18.21,6.946-25.074-0.031L60.669,86.881L30.395,117.58c-6.927,7.034-18.188,7.065-25.154,0.068 c-6.961-6.995-6.992-18.369-0.068-25.397l30.393-30.827L5.142,30.568c-6.867-6.978-6.773-18.28,0.208-25.247 c6.983-6.963,18.21-6.946,25.074,0.031l30.217,30.643L90.914,5.296L90.914,5.296z"/></g></svg>',
    'phone'                 => '<svg width="14" height="14" class="svg-phone" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 122.27" style="enable-background:new 0 0 122.88 122.27" xml:space="preserve"><g><path d="M33.84,50.25c4.13,7.45,8.89,14.6,15.07,21.12c6.2,6.56,13.91,12.53,23.89,17.63c0.74,0.36,1.44,0.36,2.07,0.11 c0.95-0.36,1.92-1.15,2.87-2.1c0.74-0.74,1.66-1.92,2.62-3.21c3.84-5.05,8.59-11.32,15.3-8.18c0.15,0.07,0.26,0.15,0.41,0.21 l22.38,12.87c0.07,0.04,0.15,0.11,0.21,0.15c2.95,2.03,4.17,5.16,4.2,8.71c0,3.61-1.33,7.67-3.28,11.1 c-2.58,4.53-6.38,7.53-10.76,9.51c-4.17,1.92-8.81,2.95-13.27,3.61c-7,1.03-13.56,0.37-20.27-1.69 c-6.56-2.03-13.17-5.38-20.39-9.84l-0.53-0.34c-3.31-2.07-6.89-4.28-10.4-6.89C31.12,93.32,18.03,79.31,9.5,63.89 C2.35,50.95-1.55,36.98,0.58,23.67c1.18-7.3,4.31-13.94,9.77-18.32c4.76-3.84,11.17-5.94,19.47-5.2c0.95,0.07,1.8,0.62,2.25,1.44 l14.35,24.26c2.1,2.72,2.36,5.42,1.21,8.12c-0.95,2.21-2.87,4.25-5.49,6.15c-0.77,0.66-1.69,1.33-2.66,2.03 c-3.21,2.33-6.86,5.02-5.61,8.18L33.84,50.25L33.84,50.25L33.84,50.25z"/></g></svg>',
    'arrowchevronbottom'    => '<svg width="14" height="14" class="arrowchevronbottom" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 266.77"><path fill-rule="nonzero" d="M493.12 3.22c4.3-4.27 11.3-4.3 15.62-.04a10.85 10.85 0 0 1 .05 15.46L263.83 263.55c-4.3 4.28-11.3 4.3-15.63.05L3.21 18.64a10.85 10.85 0 0 1 .05-15.46c4.32-4.26 11.32-4.23 15.62.04L255.99 240.3 493.12 3.22z"/></svg>',
    'arrowchevrontop'       => '<svg width="14" height="14" class="arrowchevrontop" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 266.77"><path fill-rule="nonzero" d="M493.12 263.55c4.3 4.28 11.3 4.3 15.62.05 4.33-4.26 4.35-11.19.05-15.47L263.83 3.22c-4.3-4.27-11.3-4.3-15.63-.04L3.21 248.13c-4.3 4.28-4.28 11.21.05 15.47 4.32 4.25 11.32 4.23 15.62-.05L255.99 26.48l237.13 237.07z"/></svg>',
    'arrowchevronleft'      => '<svg width="14" height="14" class="arrowchevronleft" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 267 512.43"><path fill-rule="nonzero" d="M263.78 18.9c4.28-4.3 4.3-11.31.04-15.64a10.865 10.865 0 0 0-15.48-.04L3.22 248.38c-4.28 4.3-4.3 11.31-.04 15.64l245.16 245.2c4.28 4.3 11.22 4.28 15.48-.05s4.24-11.33-.04-15.63L26.5 256.22 263.78 18.9z"/></svg>',
    'arrowchevronright'     => '<svg width="14" height="14" class="arrowchevronright" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 267 512.43"><path fill-rule="nonzero" d="M3.22 18.9c-4.28-4.3-4.3-11.31-.04-15.64s11.2-4.35 15.48-.04l245.12 245.16c4.28 4.3 4.3 11.31.04 15.64L18.66 509.22a10.874 10.874 0 0 1-15.48-.05c-4.26-4.33-4.24-11.33.04-15.63L240.5 256.22 3.22 18.9z"/></svg>',
    'facebook'              => '<svg width="14" height="14" class="facebook" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M12 5.5H9v-2a1 1 0 0 1 1-1h1V0H9a3 3 0 0 0-3 3v2.5H4V8h2v8h3V8h2l1-2.5z" clip-rule="evenodd"/></svg>',
    'twitter'               => '<svg width="14" height="14" class="twitter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M12 12H8c-1.103 0-2-.897-2-2V9h6a2 2 0 0 0 0-4H6V2a2 2 0 0 0-4 0v8c0 3.309 2.691 6 6 6h4a2 2 0 0 0 0-4z"/></svg>',
    'google-plus'           => '<svg width="14" height="14" class="google-plus" viewBox="0 0 24 24"><path d="M12.694 12.56c-.472-.344-1.185-.863-1.194-1.063 0-.283.646-.924 1.165-1.438C13.861 8.872 15.5 7.248 15.5 4.997c0-1.881-.972-3.192-2.377-4H15.5a.5.5 0 0 0 0-1H9a7.243 7.243 0 0 0-1.242.114.462.462 0 0 0-.09.025.478.478 0 0 0-.091.01C5.123.638 2.5 2.434 2.5 5.997c0 3.441 3.219 4.679 5.536 4.943-.622 1.116-.38 2.264.048 3.091C5.039 14.249.5 15.566.5 19.497c0 1.149.376 2.103 1.118 2.836 1.557 1.538 4.29 1.669 5.717 1.669.171 0 .322-.002.45-.003L8 23.997c.085 0 8.5-.149 8.5-5.5 0-3.164-2.29-4.833-3.806-5.937zm.806 6.437c0 1.717-2.376 3-4.5 3-2.076 0-4.5-.786-4.5-3 0-2.249 2.803-3.94 5.363-3.999 1.116.688 3.637 2.544 3.637 3.999zM7.802 1.12a.821.821 0 0 0 .053-.017.526.526 0 0 0 .078-.007l.048-.009c1.435-.222 2.975 1.239 3.448 3.292.496 2.149-.303 4.175-1.779 4.516-1.478.345-3.084-1.131-3.58-3.279-.485-2.104.291-4.121 1.732-4.496zM23 9.997h-2.5v-2.5a.5.5 0 0 0-1 0v2.5H17a.5.5 0 0 0 0 1h2.5v2.5a.5.5 0 0 0 1 0v-2.5H23a.5.5 0 0 0 0-1z"/></svg>',
    'pinterest'             => '<svg width="14" height="14" class="pinterest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M8.717 0C4.332 0 2 2.81 2 5.874c0 1.421.794 3.193 2.065 3.755.193.087.298.05.341-.129.038-.136.205-.791.286-1.1a.283.283 0 0 0-.068-.278c-.422-.488-.757-1.377-.757-2.211 0-2.137 1.699-4.212 4.59-4.212 2.5 0 4.249 1.624 4.249 3.947 0 2.625-1.389 4.441-3.194 4.441-.999 0-1.743-.784-1.507-1.754.285-1.155.844-2.397.844-3.23 0-.747-.422-1.365-1.284-1.365-1.017 0-1.842 1.007-1.842 2.359 0 .859.304 1.439.304 1.439l-1.193 4.823c-.316 1.285.043 3.366.074 3.545.019.099.13.13.192.049.099-.13 1.315-1.865 1.656-3.119.124-.457.633-2.31.633-2.31.335.605 1.302 1.112 2.332 1.112 3.064 0 5.278-2.693 5.278-6.035C14.988 2.397 12.246 0 8.717 0"/></svg>',
    'facebook-square'       => '<svg width="14" height="14" class="facebook-square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="#1976D2" d="M14 0H2C.897 0 0 .897 0 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V2c0-1.103-.897-2-2-2z"/><path fill="#FAFAFA" fill-rule="evenodd" d="M13.5 8H11V6c0-.552.448-.5 1-.5h1V3h-2a3 3 0 0 0-3 3v2H6v2.5h2V16h3v-5.5h1.5l1-2.5z" clip-rule="evenodd"/></svg>',
    'twitter-square'        => '<svg width="14" height="14" class="twitter-square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.87 28.87"><g data-name="Layer 2"><g data-name="Layer 1"><rect width="28.87" height="28.87" fill="#00c7ff" rx="6.48" ry="6.48"/><path fill="#fff" fill-rule="evenodd" d="M11.74 18.11a3.29 3.29 0 0 1-3.05-2.28 3.26 3.26 0 0 0 1.41 0A3.28 3.28 0 0 1 8 14.26a3.18 3.18 0 0 1-.48-1.75 3.24 3.24 0 0 0 1.46.4 3.3 3.3 0 0 1-1.35-2A3.25 3.25 0 0 1 8 8.54 9.39 9.39 0 0 0 14.76 12c0-.13 0-.24-.05-.36a3.28 3.28 0 0 1 5.58-2.74.17.17 0 0 0 .17.05 6.6 6.6 0 0 0 1.91-.73A3.36 3.36 0 0 1 21 10a6.3 6.3 0 0 0 1.83-.49l-.33.49a6.44 6.44 0 0 1-1.19 1.13.11.11 0 0 0-.05.1 9.09 9.09 0 0 1-.06 1.46 9.66 9.66 0 0 1-.85 2.92 9.44 9.44 0 0 1-1.77 2.59 8.77 8.77 0 0 1-4.51 2.51 9.79 9.79 0 0 1-1.83.22A9.27 9.27 0 0 1 7 19.52l-.08-.05a6.64 6.64 0 0 0 3.26-.47 6.53 6.53 0 0 0 1.56-.89z"/></g></g></svg>',
    'pinterest-square'      => '<svg width="14" height="14" class="pinterest-square" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 128 128"><rect width="128" height="128" fill="#bd081c" rx="24" ry="24"/><path fill="#fff" d="M64.49 31.83c-17.57 0-26.7 11.3-26.49 23.62.1 5.72 3.4 12.85 8.52 15.11.78.34 1.19.19 1.35-.52.13-.54.77-3.19 1.05-4.42a1.15 1.15 0 0 0-.3-1.12 15 15 0 0 1-3.18-8.9C45.3 47 52 38.66 63.54 38.66c10 0 17.12 6.53 17.29 15.87C81 65.08 75.58 72.4 68.34 72.4c-4 0-7-3.16-6.16-7.06 1.07-4.63 3.21-9.64 3.15-13-.05-3-1.78-5.5-5.25-5.5-4.09 0-7.3 4.06-7.2 9.48a13.73 13.73 0 0 0 1.32 5.79s-3.75 16.36-4.43 19.4c-1.17 5.16.4 13.53.54 14.27a.43.43 0 0 0 .78.2c.39-.51 5.13-7.5 6.42-12.55.46-1.83 2.37-9.28 2.37-9.28 1.38 2.43 5.29 4.48 9.41 4.48 12.28 0 20.95-10.82 20.71-24.27-.23-12.89-11.38-22.54-25.5-22.54"/></svg>',
    'google-plus-square'    => '<svg width="14" height="14" class="google-plus-square" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 134 134"><rect width="134" height="134" fill="#ed2524" rx="13" ry="13"/><path fill="#fff" fill-rule="nonzero" d="M65 31c1 0 1 1 2 2 1 0 2 1 3 3 0 1 1 2 2 4v5c0 4-1 7-2 9l-3 3-3 3-2 2v3c0 1 0 2 1 3l1 1 4 3c2 2 4 4 5 6 2 2 3 5 3 9 0 5-2 9-7 13-4 4-11 6-20 6-7 0-13-1-16-4-4-3-6-6-6-10 0-2 1-4 2-7 1-2 3-4 6-6 4-2 7-3 11-4 4 0 7-1 9-1-1-1-1-2-2-3s-1-2-1-4v-2c1-1 1-2 1-2h-3c-6 0-10-2-13-5s-5-7-5-11c0-5 3-10 7-14 3-3 6-4 9-5s6-1 9-1h21l-6 4h-7zm4 60c0-3-1-5-2-7-2-2-5-4-9-7h-6c-3 0-5 1-7 2-1 0-1 0-2 1-1 0-2 1-3 1-1 1-2 2-3 4 0 1-1 3-1 4 0 4 2 7 5 9 3 3 8 4 13 4s9-1 11-3c3-2 4-5 4-8zM55 60c2 0 5-1 6-3 1-1 2-2 2-4v-3c0-4-1-9-3-13-1-2-2-3-4-5-1-1-3-1-5-1-3 0-6 1-7 3-2 2-3 5-3 8s1 7 4 11c1 2 2 4 4 5 1 2 3 2 6 2zM106 38H95V28h-5v10H79v6h11v11h5V44h11z"/></svg>',
    'question'              => '<svg width="14" height="14" class="question" viewBox="0 0 32 32"><g data-name="Question"><path d="M16,0A16,16,0,1,0,32,16,16.019,16.019,0,0,0,16,0Zm0,30A14,14,0,1,1,30,16,14.015,14.015,0,0,1,16,30Z"/><path d="M16,6a6.006,6.006,0,0,0-6,6h2a4,4,0,0,1,4-4,4,4,0,0,1,1.151,7.832A2.985,2.985,0,0,0,15,18.7V22h2V18.7a1,1,0,0,1,.726-.953A6,6,0,0,0,16,6Z"/><rect width="2" height="2" x="15" y="24"/></g></svg>',

) );

/*-----------------------------------------------------------------------------------*/
/* Responsi Version */
/*-----------------------------------------------------------------------------------*/

global $responsi_version;
$responsi_version = RESPONSI_FRAMEWORK_VERSION;

/*-----------------------------------------------------------------------------------*/
/* Shift click */
/*-----------------------------------------------------------------------------------*/

global $shiftclick;
$shiftclick = '';
if( is_customize_preview() ){
    $shiftclick = '<span title="' . __( 'Click to edit element style CSS', 'responsi' ) . '" class="shiftclick customize-partial-edit-shortcut customize-partial-edit-shortcut-extender_logo_selective_refresh" title="Shift-click to edit style CSS."><button aria-label="Click to edit this menu." title="Click to edit this menu." class="customize-partial-edit-shortcut-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg></button></span>';
}

/*-----------------------------------------------------------------------------------*/
/* ResponsiFramework */
/*-----------------------------------------------------------------------------------*/

$responsi_requires = array(
    'functions/admin-functions.php',
    'functions/admin-setup.php',
    'functions/admin-custom-metabox.php',
    'functions/theme-functions.php',
    'functions/theme-hooks.php',
    'functions/theme-actions.php',
    'functions/theme-extension.php',
    'functions/theme-sidebar-init.php',
    'functions/block-patterns.php',
);

foreach ( $responsi_requires as $i ) {
    $located = locate_template( $i, true );
    if ( '' === $located ) {
        if ( file_exists( $i ) && function_exists( 'load_template' ) ) {
            load_template( $i, true );
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Allow child themes/plugins to add widgets to be loaded */
/*-----------------------------------------------------------------------------------*/

$responsi_customize_disabled_addon = false;
if( isset( $_GET['disabled-addon'] ) && 'disabled' === $_GET['disabled-addon'] ) {
    $responsi_customize_disabled_addon = true;
}

$responsi_includes = apply_filters( 'responsi_includes', array() );
if ( is_array( $responsi_includes ) && count( $responsi_includes ) > 0 ) {
    foreach ( $responsi_includes as $i ){
        $located = locate_template( $i, true );
        if ( '' === $located ) {
            if ( file_exists( $i ) && function_exists('load_template') ) {
                load_template( $i, true );
            }
        }
    }
}

if ( version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
    
    require dirname(__FILE__) . '/../vendor/autoload.php';

    new \A3Rev\Responsi\Customizer();
    new \A3Rev\Responsi\Layout();
    new \A3Rev\Responsi\Header();
    new \A3Rev\Responsi\Navigation();
    new \A3Rev\Responsi\Sidebar();
    new \A3Rev\Responsi\Footer();
    new \A3Rev\Responsi\Posts();
    new \A3Rev\Responsi\Pages();
    new \A3Rev\Responsi\Blogs();
    new \A3Rev\Responsi\Settings();
    new \A3Rev\Responsi\Privacy();

    if( !$responsi_customize_disabled_addon ){
        do_action( 'responsi_allow_addon_customizer' );
    }

} else {
    return;
}

/*-----------------------------------------------------------------------------------*/
/* Allow Responsi Customizer */
/*-----------------------------------------------------------------------------------*/

$responsi_includes_customizer = array();

if( !$responsi_customize_disabled_addon ){
    $responsi_includes_customizer = apply_filters( 'responsi_includes_customizer', $responsi_includes_customizer );
}

if( is_array( $responsi_includes_customizer ) && count( $responsi_includes_customizer ) > 0 ){
    foreach ( $responsi_includes_customizer as $i ) {
        $located = locate_template( $i, true );
        if ( '' === $located ) {
            if ( file_exists( $i ) && function_exists('load_template') ){
                load_template( $i, true );
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* default Options Function - responsi_default_options */
/*-----------------------------------------------------------------------------------*/

function responsi_default_options( $type = 'options' )
{
    if ( 'options' === $type ) {
        $responsi_default_options = apply_filters( 'responsi_default_options', array() );
    } else {
        $responsi_default_options = apply_filters( 'responsi_default_options_' . $type, array() );
    }

    $options = array();

    if ( is_array( $responsi_default_options ) && count( $responsi_default_options ) > 0 ) {
        foreach ( $responsi_default_options as $option_id => $default ) {

            if ( isset($default['control']['type']) ) {
                $type = $default['control']['type'];
                switch ( $type ) {
                    case "multitext":
                        $i = 0;
                        foreach ( $default['control']['choices'] as $key => $value ) {
                            $options[$option_id . '_' . $key] = $default['setting']['default'][$i];
                            $i++;
                        }
                    break;

                    case "imulticheckbox":
                        $i = 0;
                        foreach ( $default['control']['choices'] as $key => $value ) {
                            $options[$option_id . '_' . $key] = $default['setting']['default'][$i];
                            $i++;
                        }
                    break;

                    default:
                        if ( 'ilabel' !== $type && isset( $default['setting']['default']) ) {
                            $options[$option_id] = $default['setting']['default'];
                        }
                    break;
                }
            }
        }
    }
    return $options;
}

/*-----------------------------------------------------------------------------------*/
/* Global $responsi_options for theme blank-child-theme */
/*-----------------------------------------------------------------------------------*/
function _blank_child_customize_options( $slug = '', $_customize_options = array(), $_default_options = array() )
{  
    if( '' === $slug ) return $_customize_options;
            
    $responsi_blank_child =  get_option( $slug . '_responsi-blank-child', array() );

    $_is_blank = ( is_array($responsi_blank_child) && isset($responsi_blank_child['_is_blank'] ) && $responsi_blank_child['_is_blank'] === true ? true : false ) ;

    if( !$_is_blank ){
        $responsi_mods = get_option( $slug .'_responsi', array() );

        if( is_array($responsi_mods) ){
            $_customize_options = array_replace_recursive( $_customize_options, $responsi_mods );
        }

        if( is_array( $responsi_mods ) ){
        
            foreach( $responsi_mods as $key => $value ){

                if( !array_key_exists( $key, $responsi_blank_child ) ){

                    $responsi_blank_child[$key] = $value ;
                    $_is_blank = true;

                }
            }

        }

        if( $_is_blank ){

            if( is_array( $responsi_blank_child ) ){
                foreach( $responsi_blank_child as $key => $value ){
                    if( array_key_exists( $key, $_default_options )){
                        if( is_array( $value ) && is_array( $_default_options[$key] ) ){
                            $new_opt = array_diff_assoc( $value, $_default_options[$key] );
                            if( is_array( $new_opt ) && count( $new_opt ) > 0 ){
                                $responsi_blank_child[$key] = $value;
                            }else{
                                unset($responsi_blank_child[$key]);
                            }
                        }else{
                            if( !is_array( $value ) && !is_array($_default_options[$key]) && $value == $_default_options[$key] ){
                                unset($responsi_blank_child[$key]);
                            }
                        }
                    }
                }
            }

            $responsi_blank_child['_is_blank'] = true;
            update_option( $slug . '_responsi-blank-child',  $responsi_blank_child );

        }
    }

    if( is_array($responsi_blank_child) ){
        $_customize_options = array_replace_recursive( $_customize_options, $responsi_blank_child );
    }

    return $_customize_options;

}

/*-----------------------------------------------------------------------------------*/
/* Global $responsi_options for theme and Addon added on Customize */
/*-----------------------------------------------------------------------------------*/

function responsi_options()
{
    global $wp_customize, $responsi_options, $responsi_blog_animation;

    $responsi_default_options = responsi_default_options();

    $responsi_options = apply_filters( 'responsi_options_default', $responsi_default_options );

    $responsi_theme_mods = get_theme_mods();

    if( is_array( $responsi_theme_mods ) ){
        $responsi_options = array_replace_recursive( $responsi_options, $responsi_theme_mods );
    }

    $_childthemes = get_option('stylesheet');

    if( 'responsi-blank-child' === $_childthemes ){

        $responsi_blank_child = $responsi_theme_mods;

        $_is_blank = ( is_array($responsi_blank_child) && isset($responsi_blank_child['_is_blank'] ) && $responsi_blank_child['_is_blank'] === true ? true : false ) ;

        if( !$_is_blank ){

            $theme_mods_responsi = get_option( 'theme_mods_responsi' );
            
            if( is_array( $theme_mods_responsi ) ){
                $responsi_options = array_replace_recursive( $responsi_options, $theme_mods_responsi );
            }

            if( is_array( $theme_mods_responsi ) ){
                
                foreach( $theme_mods_responsi as $key => $value ){

                    if( !array_key_exists( $key, $responsi_blank_child ) ){

                        $responsi_blank_child[$key] = $value ;
                        $_is_blank = true;

                    }
                }

            }

            if( $_is_blank ){

                if( is_array( $responsi_blank_child ) ){
                    foreach( $responsi_blank_child as $key => $value ){
                        if( array_key_exists( $key, $responsi_default_options )){
                            if( is_array( $value ) && is_array( $responsi_default_options[$key] ) ){
                                $new_opt = array_diff_assoc( $value, $responsi_default_options[$key] );
                                if( is_array( $new_opt ) && count( $new_opt ) > 0 ){
                                    $responsi_blank_child[$key] = $value;
                                }else{
                                    unset($responsi_blank_child[$key]);
                                }
                            }else{
                                if( !is_array( $value ) && !is_array($responsi_default_options[$key]) && $value == $responsi_default_options[$key] ){
                                    unset($responsi_blank_child[$key]);
                                }
                            }
                        }
                    }
                }

                $responsi_blank_child['_is_blank'] = true;
                update_option( 'theme_mods_responsi-blank-child',  $responsi_blank_child );

            }

        }

        if( is_array( $responsi_blank_child ) ){
            $responsi_options = array_replace_recursive( $responsi_options, $responsi_blank_child );
        }
    }

    foreach( $responsi_options as $key => $value ){
        if( !array_key_exists( $key, $responsi_default_options ) ){
            unset( $responsi_options[$key] );
        }
    }

    $responsi_options = apply_filters( 'responsi_options_before', $responsi_options );

    if( is_customize_preview() && ( isset( $_REQUEST['changeset_uuid'] ) || isset( $_REQUEST['customize_changeset_uuid'] ) ) ){
        $changeset_data = $wp_customize->changeset_data();
        if ( is_array($changeset_data) ) {
            if( count( $changeset_data ) > 0 ){
                $responsi_options_preview = array();
                foreach ( $changeset_data as $setting_id => $setting_params ){
                    if ( ! array_key_exists( 'value', $setting_params ) ) {
                        continue;
                    }

                    if ( isset( $setting_params['type'] ) && 'theme_mod' === $setting_params['type'] ) {
                        $namespace_pattern = '/^(?P<stylesheet>.+?)::(?P<setting_id>.+)$/';
                        if ( preg_match( $namespace_pattern, $setting_id, $matches ) && get_stylesheet() === $matches['stylesheet'] ) {
                            $responsi_options_preview[ $matches['setting_id'] ] = $setting_params['value'];
                        }
                    } else {
                        $responsi_options_preview[ $setting_id ] = $setting_params['value'];
                    }
                }
                $responsi_options_preview = apply_filters( 'responsi_customized_post_value', $responsi_options_preview );
                if ( is_array($responsi_options) && is_array( $responsi_options_preview ) && count( $responsi_options_preview ) > 0 ) {
                    if ( is_object( $responsi_options_preview ) ){
                        $responsi_options_preview = clone $responsi_options_preview;
                    }
                    $responsi_options = array_replace_recursive( $responsi_options, $responsi_options_preview );
                }
            }
        }
    }

    if ( isset($_POST['customized']) ){
        $responsi_options         = apply_filters( 'responsi_options_preview_before', $responsi_options );
        $responsi_options_preview = json_decode( wp_unslash( $_POST['customized'] ), true );
        $responsi_options_preview = apply_filters( 'responsi_customized_post_value', $responsi_options_preview );
        if ( is_array($responsi_options) && is_array($responsi_options_preview) ) {
            if ( is_object( $responsi_options_preview ) ){
                $responsi_options_preview = clone $responsi_options_preview;
            }
            $responsi_options = array_replace_recursive( $responsi_options, $responsi_options_preview );
        }
        $responsi_options = apply_filters( 'responsi_options_preview_after', $responsi_options );
    }

    $responsi_options = apply_filters( 'responsi_options_after', $responsi_options );

    if( function_exists('responsi_generate_animation') && is_array($responsi_options) && isset($responsi_options['responsi_blog_animation']) ){
        $responsi_blog_animation = responsi_generate_animation($responsi_options['responsi_blog_animation']);
    }

    return $responsi_options;
}

add_action( 'init', 'responsi_options', 1 );
add_action( 'widgets_init', 'responsi_options', 1 );
?>
