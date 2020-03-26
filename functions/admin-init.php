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
    $gFonts;

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
    $shiftclick = '<span class="shiftclick" title="' . __( 'Click to edit element style CSS', 'responsi' ) . '"><i class="responsi-icon responsi-icon-edit" aria-hidden="true"></i></span>';
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
